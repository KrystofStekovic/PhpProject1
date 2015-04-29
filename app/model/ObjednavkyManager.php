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
            TABLE_NAME_KOSIKY = 'kosiky',
            COLUMN_ID_OBJEDNAVKY = 'id_objednavky',
            COLUMN_ID_UZIVATELE = 'id_uzivatele',
            COLUMN_ID_KOSIKU = 'id_kosiku',
            COLUMN_DATUM_VYTVORENI = 'datum_vytvoreni',
            COLUMN_DATUM_POTVRZENI = 'datum_potvrzeni',
            COLUMN_DATUM_ODESLANI = 'datum_odeslani',
            COLUMN_DATUM_DORUCENI = 'datum_doruceni',
            COLUMN_DATUM_OBJEDNANI = 'datum_objednani',
            COLUMN_JMENO = 'jmeno',
            COLUMN_PRIJMENI = 'prijmeni',
            COLUMN_ADRESA = 'adresa',
            COLUMN_MESTO = 'mesto',
            COLUMN_PSC = 'psc',
            COLUMN_STAV = 'stav';

    /** @var Nette\Database\Context */
    private $database;

    public function __construct(Nette\Database\Context $database) {
        $this->database = $database;
    }

    public function objednejKosik($idUzivatele, $idkosiku, $jmeno, $prijmeni, $adresa, $mesto, $psc) {
        $kosik = $this->database->table('kosiky')->get($idkosiku);
        $kosik->update(array(
            self::COLUMN_STAV => 'objednaný',
            self::COLUMN_JMENO => $jmeno,
            self::COLUMN_PRIJMENI => $prijmeni,
            self::COLUMN_ADRESA => $adresa,
            self::COLUMN_MESTO => $mesto,
            self::COLUMN_PSC => $psc,
            self::COLUMN_DATUM_OBJEDNANI => date("Y-m-d H:i:s")));
    }

    public function potvrditObjednavku($idKosiku) {
        $objednavka = $this->database->table(self::TABLE_NAME_KOSIKY)->where('id_kosiku = ?', $idKosiku);
        $objednavka->update(array(
            self::COLUMN_STAV => 'potvrzený',
            self::COLUMN_DATUM_POTVRZENI => date("Y-m-d H:i:s")
        ));
    }
    
    public function odeslanaObjednavka($idKosiku) {
        $objednavka = $this->database->table(self::TABLE_NAME_KOSIKY)->where('id_kosiku = ?', $idKosiku);
        $objednavka->update(array(
            self::COLUMN_STAV => 'odeslaný',
            self::COLUMN_DATUM_ODESLANI => date("Y-m-d H:i:s")
        ));
    }
    
    public function getObjednavky(){
        return $this->database->table(self::TABLE_NAME_KOSIKY)->order(self::COLUMN_DATUM_VYTVORENI." DESC");
    }

//    public function getObjednano() {
//        return $this->database->table(self::TABLE_NAME_OBJEDNAVKY)->where('stav = ?', 'objednano');
//    }

//    public function getZpracovani() {
//        
//    }

//    public function getOdeslano() {
//        
//    }

//    public function getPrijato() {
//        
//    }

}
