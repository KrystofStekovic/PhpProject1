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

    public function getKosik($user) {
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
        $kosik = $this->getKosik($user);
        $this->database->table(self::TABLE_NAME_ZBOZI_KOSIKU)->insert(array(
            self::COLUMN_ID_KOSIKU => $kosik->id_kosiku,
            self::COLUMN_ID_ZBOZI => $idProduktu,
            self::COLUMN_MNOZSTVI => $mnozstvi,
        ));
    }

}
