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
 * Description of ObrazkyManager
 *
 * @author sasa
 */
class ObrazkyManager extends Nette\Object {

    /**
     * @var Nette\Database\Context
     */
    private $database;

    public function __construct(Nette\Database\Context $database) {
        $this->database = $database;
    }

    public function addObrazek($file) {
        if (is_uploaded_file($file['tmp_name'][0])) {
            $adresa = 'images/' . $file['name'][0];
            move_uploaded_file($file['tmp_name'][0], $adresa);
            $obrazek['nazev'] = $file['name'][0];
            $obrazek['adresa'] = $adresa;
            $obrazek = $this->database->table('obrazky')->insert($obrazek);
            return $obrazek->id_obrazku;
        } 
    }

    public function updateObrazek($idObrazku, $file) {
        if (is_uploaded_file($file['tmp_name'][0])) {
            $adresa = 'images/' . $file['name'][0];
            move_uploaded_file($file['tmp_name'][0], $adresa);
            $obrazek['nazev'] = $file['name'][0];
            $obrazek['adresa'] = $adresa;
            $obr = $this->database->table('obrazky')->get($idObrazku);
            $obr->update($obrazek);
        }
    }

    public function getObrazkyProduktu() {
        $produkty = $this->database->table('produkty');
        foreach ($produkty as $produkt) {
            $obr = $produkt->ref('obrazky', 'id_obrazku');
            if ($obr) {
                $obr = Image::fromFile($obr->adresa);
                $obr->resize(100, 100);
                $obrazky[$produkt->id_produktu] = $obr;
            }
        }
        return $obrazky;
    }

    public function getObrazky() {
        $obr = $this->database->table('obrazky');
        $obrazky = [];
        foreach ($obr as $obrazek) {
            $file = Image::fromFile($obrazek->adresa);
            $file->resize(50, 50);
            $pom['file'] = $file;
            $pom['adresa'] = $obrazek->adresa;
            array_push($obrazky, $pom);
        }
        return $obrazky;
    }

}
