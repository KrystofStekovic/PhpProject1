<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace App\Model;

use Nette,
    Nette\Utils\Image;

/**
 * Description of ProduktyManager
 *
 * @author Krystof
 */
class ProduktyManager extends Nette\Object {

    /**
     * @var Nette\Database\Context
     */
    private $database;

    public function __construct(Nette\Database\Context $database) {
        $this->database = $database;
    }

    public function getProdukty() {
        $sql = "SELECT p.id_produktu, p.id_materialu, p.id_obrazku, p.nazev, p.popis, p.cena, p.mnozstvi, p.odecetMnozstvi, zk.mnozstvi 
FROM produkty p
LEFT OUTER JOIN zbozi_kosik zk ON p.id_materialu = zk.id_zbozi
";
        return $this->database->table('produkty');
    }

    public function getProdukt($idProduktu) {
        return $this->database->table('produkty')->get($idProduktu);
    }

    public function getObrazkyProduktu() {
        $produkty = $this->database->table('produkty');
        foreach ($produkty as $produkt) {
            $obr = Image::fromFile($produkt->ref('obrazky', 'id_obrazku')->adresa);
            $obr->resize(100, 100);
            $obrazky[$produkt->id_produktu] = $obr;
        }
        return $obrazky;
    }

    public function updateProdukt($values, $produktId) {
        $adresa = 'images/';
        if ($values->obrazek) {
            $file = $values->obrazek;
            $obrazek['nazev'] = $file->name;
            $obrazek['adresa'] = $adresa . $file->name;
            $file->move($adresa . $file->name);
            $idObr = $this->database->table('produkty')->where('id_produktu', $produktId)->fetch()->ref('obrazky', 'id_obrazku')->id_obrazku;
            $obr = $this->database->table('obrazky')->get($idObr);
            $obr->update($obrazek);
        }
        unset($values['obrazek']);
        $produkt = $this->database->table('produkty')->get($produktId);
        $produkt->update($values);
    }

    public function insertProdukt($values) {
        $adresa = 'images/';
        $file = $values->obrazek;
        $obrazek['nazev'] = $file->name;
        $obrazek['adresa'] = $adresa . $file->name;
        $file->move($adresa . $file->name);
        $obrazek = $this->database->table('obrazky')->insert($obrazek);
        $values['id_obrazku'] = $obrazek->id_obrazku;
        unset($values['obrazek']);
        $this->database->table('produkty')->insert($values);
//            $this->flashMessage('Produkt byl úspěšně vlozen.', 'success');
    }

    public function deleteProdukt($produktId) {
        $this->database->table('produkty')->where('id_produktu', $produktId)->delete();
    }

}
