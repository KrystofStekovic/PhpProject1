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
        if ($file) {
            $adresa = 'images/';
            $obrazek['nazev'] = $file->name;
            $obrazek['adresa'] = $adresa . $file->name;
            $file->move($adresa . $file->name);
            $obrazek = $this->database->table('obrazky')->insert($obrazek);
            return $obrazek->id_obrazku;
        } else {
            return null;
        }
    }

    public function updateObrazek($idObrazku, $file) {
        $adresa = 'images/';
        $obrazek['nazev'] = $file->name;
        $obrazek['adresa'] = $adresa . $file->name;
        $file->move($adresa . $file->name);
        $obr = $this->database->table('obrazky')->get($idObrazku);
        $obr->update($obrazek);
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

}
