<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace App\Model;

use Nette,
    Tracy\Debugger;

/**
 * Description of KosikManager
 *
 * @author Krystof
 */
class KosikManager extends Nette\Object {

    const
            TABLE_NAME_KOSIKY = 'kosiky',
            TABLE_NAME_ZBOZI_KOSIKU = 'zbozi_kosik',
            COLUMN_ID_KOSIKU = 'id_kosiku',
            COLUMN_ID_UZIVATELE = 'id_uzivatele',
            COLUMN_OTEVRENY = 'otevreny',
            COLUMN_ID_ZBOZI_KOSIK = 'id_zbozi_kosik',
            COLUMN_ID_ZBOZI = 'id_zbozi',
            COLUMN_MNOZSTVI = 'mnozstvi';

    /** @var Nette\Database\Context */
    private $database;

    public function __construct(Nette\Database\Context $database) {
        $this->database = $database;
    }

    public function getPrehledKosiku($user, $idkosiku) {
        $where = 'WHERE k.id_kosiku = ' . $idkosiku;
        $sql = 'SELECT
            k.id_kosiku,
            u.id_uzivatele,
            k.datum_vytvoreni, 
            COUNT(zk.id_zbozi) AS produkty, 
            SUM(zk.mnozstvi) AS produkty_celkem,
            Sum(p.cena*zk.mnozstvi) AS suma,
            k.stav AS stav
                FROM kosiky k 
                    NATURAL JOIN uzivatele u
                    NATURAL JOIN zbozi_kosik zk
                    INNER JOIN produkty p ON zk.id_zbozi = p.id_produktu
                ' . ($idkosiku ? $where : '') . '  
                GROUP BY k.id_kosiku
                ORDER BY k.datum_vytvoreni DESC';
        $kosiky = $this->database->query($sql);
        return $kosiky;
    }

    public function getObsahKosiku($idKosiku) {
        $sql = 'SELECT
            id_produktu,
            id_kosiku,
            datum_vytvoreni, 
            produkty.nazev AS produkt, 
            zbozi_kosik.mnozstvi AS mnozstvi,
            (zbozi_kosik.mnozstvi*produkty.cena) AS cena,
            id_uzivatele
                FROM kosiky 
                    NATURAL JOIN zbozi_kosik
                    INNER JOIN produkty ON zbozi_kosik.id_zbozi = produkty.id_produktu
                WHERE id_kosiku =  ? ';
        $kosiky = $this->database->queryArgs($sql, array($idKosiku));
        return $kosiky;
    }

    public function getOpenKosik($user) {
        $sql = "SELECT k.id_kosiku AS id_kosiku,
                    k.id_uzivatele AS id_uzivatele,
                    k.datum_vytvoreni AS datum
           	FROM kosiky k 
                WHERE k.stav = 'nový' AND k.id_uzivatele =  ? ";
        $kosik = $this->database->queryArgs($sql, array($user->id))->fetch();
//        $kosik = $this->database->table(self::TABLE_NAME_KOSIKY)
//                ->where(self::COLUMN_ID_UZIVATELE . ' = ? ', $user->id);
//                ->fetch();
//        $objednavka = $kosik->ref('objednavky', 'id_kosiku');
        if (!$kosik) {
            $this->database->table(self::TABLE_NAME_KOSIKY)->insert(array(
                self::COLUMN_ID_UZIVATELE => $user->id,
            ));
            $kosik = $this->database->queryArgs($sql, array($user->id))->fetch();
        }
        return $kosik;
    }

    public function addProdukt($user, $idProduktu, $mnozstvi) {
        $kosik = $this->getOpenKosik($user);
        $produkt = $this->database->table(self::TABLE_NAME_ZBOZI_KOSIKU)
                ->where(self::COLUMN_ID_ZBOZI . " = " . $idProduktu . " AND " . self::COLUMN_ID_KOSIKU . " = " . $kosik->id_kosiku)
                ->fetch();
        if ($produkt) {
            $mnoz = $produkt->mnozstvi + $mnozstvi;
            if ($mnoz > 0) {
                $produkt->update(array(
                    self::COLUMN_MNOZSTVI => $produkt->mnozstvi + $mnozstvi
                ));
            } else {
                $produkt->delete();
            }
        } else if ($mnozstvi > 0){
            $this->database->table(self::TABLE_NAME_ZBOZI_KOSIKU)->insert(array(
                self::COLUMN_ID_KOSIKU => $kosik->id_kosiku,
                self::COLUMN_ID_ZBOZI => $idProduktu,
                self::COLUMN_MNOZSTVI => $mnozstvi,
            ));
        }
    }

    public function smazProdukt($idProduktu, $idkosiku) {
        $this->database->table(self::TABLE_NAME_ZBOZI_KOSIKU)
                ->where(self::COLUMN_ID_ZBOZI . " = " . $idProduktu . " AND " . self::COLUMN_ID_KOSIKU . " = " . $idkosiku)
                ->delete();
    }

    public function getMnozVKosiku($idUzivatele) {
        $sql = "SELECT zk.id_zbozi AS id_zbozi, zk.mnozstvi AS mnozstvi FROM zbozi_kosik zk
JOIN (SELECT * FROM kosiky WHERE stav = 'nový') k ON zk.id_kosiku = k.id_kosiku 
WHERE id_uzivatele = ?";
        $mnoz = $this->database->queryArgs($sql, array($idUzivatele));
        $mnozstvi = array();
        foreach ($mnoz as $mn) {
            $mnozstvi[$mn->id_zbozi] = $mn->mnozstvi;
        }
        return $mnozstvi;
    }

}
