<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace App\Presenters;

use Nette,
    Nette\Application\UI\Form;

/**
 * Description of ProduktyPresenter
 *
 * @author sasa
 */
class ProduktyPresenter extends BasePresenter {    
    
    /**
     * @var \App\Model\KosikManager
     * @inject
     */
    public $kosikManager;
    
    private $produkty;

    public function __construct(Nette\Database\Context $database) {
        $this->database = $database;
    }

    public function renderDefault() {
        $this->produkty = $this->database->table('produkty');
        $this->template->produkty = $this->produkty;
    }

    public function createComponentProduktForm() {
        $materialy = null;
        foreach ($this->database->table('materialy') as $value) {
            $materialy[$value->id_materialu] = $value->nazev;
        }
        $form = new Form;
        $form->addText('nazev', 'Nazev:')
                ->setRequired();
        $form->addText('popis', 'Popis:')
                ->setRequired();
        $form->addText('cena', 'Cena:')
                ->setRequired();
        $form->addSelect('id_materialu', 'Material:', $materialy)
                ->setPrompt('Zvolte meterial');
        $form->addText('mnozstvi', 'Zobrazene mnozstvi:')
                ->setRequired();
        $form->addText('odecetMnozstvi', 'Odpocitat ze skladu:')
                ->setRequired();
        $form->addSubmit('send', 'Ulozit produkt');
        $form->onSuccess[] = array($this, 'insertProdukt');
        return $form;
    }

    public function createComponentMnozstviForm() {
        $form = new Form;
        $form->addHidden('id_produktu');
        $form->addText('mnozstvi', '')
                ->setType('number');
        $form->onSuccess[] = array($this, 'actionAddProduktu');
        return $form;
    }

    public function insertProdukt($form, $values) {

        $produktId = $this->getParameter('produktId');

        if ($produktId) {
            $produkt = $this->database->table('produkty')->get($produktId);
            $produkt->update($values);
            $this->flashMessage('Produkt byl úspěšně upraven.', 'success');
        } else {
            $produkt = $this->database->table('produkty')->insert($values);
            $this->flashMessage('Produkt byl úspěšně vlozen.', 'success');
        }
        $this->redirect('this');
    }

    public function actionEdit($produktId) {
        $produkt = $this->database->table('produkty')->get($produktId);
        if (!$produkt) {
            $this->error('Produkt nebyl nalezen');
        }
        $this['produktForm']->setDefaults($produkt->toArray());
    }

    public function actionDelete($produktId) {
        $produkt = $this->database->table('produkty')->where('id_produktu', $produktId)->delete();
        $this->flashMessage('Produk byl úspěšně smazan.', 'success');
        $this->redirect('default');
    }

    public function actionAddProduktu($produktId) {
        $mnozstvi = $form->getHttpData($form::DATA_LINE, 'mnozstvi');
        $this->kosikManager->addProdukt($this->user, $produktId, $mnozstvi);
    }

}
