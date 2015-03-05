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
        $where = ' AND kosiky.id_kosiku = '.$idkosiku;
        $sql = 'SELECT
            id_kosiku,
            id_uzivatele,
            datum_vytvoreni, 
            COUNT(id_zbozi) AS produkty, 
            SUM(zbozi_kosik.mnozstvi) AS produkty_celkem,
            Sum(produkty.cena*zbozi_kosik.mnozstvi) AS suma 
                FROM kosiky 
                    NATURAL JOIN uzivatele
                    NATURAL JOIN zbozi_kosik
                    INNER JOIN produkty ON zbozi_kosik.id_zbozi = produkty.id_produktu
                WHERE kosiky.id_uzivatele = ?'.($idkosiku ? $where : '').'  
                GROUP BY kosiky.id_kosiku';
        $kosiky = $this->database->queryArgs($sql, array($user->id));
        return $kosiky;
    }

    public function getObsahKosiku($idKosiku) {
        $sql = 'SELECT
            id_produktu,
            id_kosiku,
            datum_vytvoreni, 
            produkty.nazev AS produkt, 
            zbozi_kosik.mnozstvi AS mnozstvi,
            (zbozi_kosik.mnozstvi*produkty.cena) AS cena
            
                FROM kosiky 
                    NATURAL JOIN zbozi_kosik
                    INNER JOIN produkty ON zbozi_kosik.id_zbozi = produkty.id_produktu
                WHERE id_kosiku =  ? ';
        $kosiky = $this->database->queryArgs($sql, array($idKosiku));
        return $kosiky;
    }

    public function getOpenKosik($user) {
        $kosik = $this->database->table(self::TABLE_NAME_KOSIKY)
                ->where(self::COLUMN_ID_UZIVATELE . ' = ? AND ' . self::COLUMN_OTEVRENY . ' = ?', $user->id, true)
                ->fetch();
        if (!$kosik) {
            $this->database->table(self::TABLE_NAME_KOSIKY)->insert(array(
                self::COLUMN_ID_UZIVATELE => $user->id,
            ));
            $kosik = $this->database->table(self::TABLE_NAME_KOSIKY)
                    ->where(self::COLUMN_ID_UZIVATELE . ' = ? AND ' . self::COLUMN_OTEVRENY . ' = ?', $user->id, true)
                    ->fetch();
        }
        return $kosik;
    }

    public function addProdukt($user, $idProduktu, $mnozstvi) {
        $kosik = $this->getOpenKosik($user);
        $produkt = $this->database->table(self::TABLE_NAME_ZBOZI_KOSIKU)
                ->where(self::COLUMN_ID_ZBOZI . " = " . $idProduktu . " AND " . self::COLUMN_ID_KOSIKU . " = " . $kosik->id_kosiku)
                ->fetch();
        if ($produkt) {
            $produkt->update(array(
                self::COLUMN_MNOZSTVI => $produkt->mnozstvi + $mnozstvi
            ));
        } else {
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

}
