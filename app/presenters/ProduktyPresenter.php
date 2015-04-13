<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace App\Presenters;

use Nette,
    Tracy\Debugger,
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

    /**
     * @var \App\Model\ProduktyManager
     * @inject
     */
    public $produktyManager;
    /**
     * @var \App\Model\ObrazkyManager
     * @inject
     */
    public $obrazkyManager;

    public function __construct(Nette\Database\Context $database) {
        $this->database = $database;
    }

    public function renderDefault() {
        $this->template->produkty = $this->produktyManager->getProdukty();
        $this->template->obrazky = $this->obrazkyManager->getObrazkyProduktu();
        $this->template->materialy = $this->produktyManager->getMaterialy();
        $this->template->kosik = $this->kosikManager->getMnozVKosiku($this->user->id);
    }

    public function createComponentProduktForm() {
        $materialy = null;
        foreach ($this->database->table('materialy') as $value) {
            $materialy[$value->id_materialu] = $value->nazev;
        }
        $form = new Form;
        $form->addText('nazev', 'Název:')
                ->setRequired();
        $form->addText('popis', 'Popis:')
                ->setRequired();
        $form->addText('cena', 'Cena:')
                ->setRequired();
        $form->addSelect('id_materialu', 'Materiál:', $materialy)
                ->setPrompt('Zvolte meteriál');
        $form->addText('mnozstvi', 'Zobrazené množství:')
                ->setRequired();
        $form->addText('odecetMnozstvi', 'Odpočítat ze skladu:')
                ->setRequired();
        $form->addUpload('obrazek', 'Obrázek:', TRUE)
                ->addRule(Form::IMAGE, 'Avatar musí být JPEG, PNG nebo GIF.');
        $form->addSubmit('send', 'Uložit produkt');
        $form->onSuccess[] = array($this, 'insertProdukt');
        return $form;
    }

    public function createComponentMnozstviForm($idProduktu) {
        $form = new Form;
        $form->addHidden('id_produktu');
        $form->addText('mnozstvi', '')
                ->addRule(Form::INTEGER, 'Množství musí být číslo')
                ->setType('number');
        $form->addSubmit('send', 'Přepočítat');
        $form->onSuccess[] = array($this, 'actionAddProduktu');
        return $form;
    }

    public function insertProdukt($form, $values) {

        $produktId = $this->getParameter('produktId');
        $produkt = $this->produktyManager->getProdukt($produktId);
        if ($produktId) {
            $this->obrazkyManager->updateObrazek($produkt->id_obrazku, $values->obrazek);
            $this->produktyManager->updateProdukt($values, $produktId);
            $this->flashMessage('Produkt byl úspěšně upraven.', 'success');
        } else {
            $idObrazku = $this->obrazkyManager->addObrazek($values->obrazek);
            $this->produktyManager->insertProdukt($values, $idObrazku);
            $this->flashMessage('Produkt byl úspěšně vložen.', 'success');
        }
        $this->redirect('this');
    }

    public function actionEdit($produktId) {
        $produkt = $this->produktyManager->getProdukt($produktId);
        if (!$produkt) {
            $this->error('Produkt nebyl nalezen');
        }
        $this['produktForm']->setDefaults($produkt->toArray());
    }

    public function actionDelete($produktId) {
        $this->produktyManager->getProdukty($produktId);
        $this->flashMessage('Produk byl úspěšně smazán.', 'success');
        $this->redirect('default');
    }

    public function actionAddProduktu($form, $values) {
        $this->kosikManager->addProdukt($this->user, $values->id_produktu, $values->mnozstvi);
        $this->redirect('this');
    }

}
