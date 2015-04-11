<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace App\Model;

use Nette;

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
    
    public function getMaterialy(){
        $mat = $this->database->table('materialy');
        foreach ($mat as $material) {
            $materialy[$material->id_materialu] = $material->nazev;
        }
        return $materialy;
    }

    public function getProdukt($idProduktu) {
        return $this->database->table('produkty')->get($idProduktu);
    }

    public function updateProdukt($values, $produktId) {
        unset($values['obrazek']);
        $produkt = $this->database->table('produkty')->where('id_produktu = ?', $produktId);
        $produkt->update($values);
    }

    public function insertProdukt($values, $idObrazku) {
        unset($values['obrazek']);
        $values['id_obrazku'] = $idObrazku;
        $this->database->table('produkty')->insert($values);
//            $this->flashMessage('Produkt byl úspěšně vlozen.', 'success');
    }

    public function deleteProdukt($produktId) {
        $this->database->table('produkty')->where('id_produktu', $produktId)->delete();
    }

}
