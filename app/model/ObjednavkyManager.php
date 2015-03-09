<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace App\Model;

use Nette;

/**
 * Description of ObjednavkyManager
 *
 * @author Krystof
 */
class ObjednavkyManager {

    const
            TABLE_NAME_OBJEDNAVKY = 'objednavky',
            COLUMN_ID_OBJEDNAVKY = 'id_objednavky',
            COLUMN_ID_UZIVATELE = 'id_uzivatele',
            COLUMN_ID_KOSIKU = 'id_kosiku',
            COLUMN_JMENO = 'jmeno',
            COLUMN_PRIJMENI = 'prijmeni',
            COLUMN_STAV = 'stav';

    /** @var Nette\Database\Context */
    private $database;

    public function __construct(Nette\Database\Context $database) {
        $this->database = $database;
    }

    public function objednejKosik($idUzivatele, $idkosiku, $jmeno, $prijmeni) {
        $material = $this->database->table(self::TABLE_NAME_OBJEDNAVKY)->insert(array(
            self::COLUMN_ID_UZIVATELE => $idUzivatele,
            self::COLUMN_ID_KOSIKU => $idkosiku,
            self::COLUMN_JMENO => $jmeno,
            self::COLUMN_PRIJMENI => $prijmeni,
            self::COLUMN_STAV => 'objednano'
        ));
    }

}
