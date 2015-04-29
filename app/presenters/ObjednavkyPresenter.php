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
 * Description of ObjednavkyPresenter
 *
 * @author Krystof
 */
class ObjednavkyPresenter extends BasePresenter {

    /**
     * @var \App\Model\KosikManager
     * @inject
     */
    public $kosikManager;

    /**
     * @var \App\Model\ObjednavkyManager
     * @inject
     */
    public $objednavkyManager;

    public function renderDefault() {
        $this->template->kosiky = $this->kosikManager->getPrehledKosiku($this->user, null);
        $kosik = $this->kosikManager->getOpenKosik($this->user);
        $this->template->produkty = $this->kosikManager->getObsahKosiku($kosik->id_kosiku);
        $this->template->prehled = $this->kosikManager->getPrehledKosiku($this->user, $kosik->id_kosiku)->fetch();
    }

    public function renderDetail($idKosiku) {
        $this->template->produkty = $this->kosikManager->getObsahKosiku($idKosiku);
        $this->template->prehled = $this->kosikManager->getPrehledKosiku($this->user, $idKosiku)->fetch();
    }

    public function renderAdmin() {
        if ($this->user->isInRole("admin")) {
            $this->template->objednavky = $this->objednavkyManager->getObjednavky();
        }
    }

    public function renderObjednejKosik($idKosiku) {
        $this['objednavkaForm']->setDefaults(array('idKosiku' => $idKosiku));
    }

    public function actionSmazatProdukt($produktId, $kosikId, $default) {
        $this->kosikManager->smazProdukt($produktId, $kosikId);
        if($default == 'default'){
            $this->redirect('default');
        }else{
            $this->redirect('detail?idKosiku=' . $kosikId);
        }
    }

    public function actionPotvrdit($objednavkaID) {
        if ($this->user->isInRole("admin")) {
            $this->objednavkyManager->potvrditObjednavku($objednavkaID);
            $this->redirect('admin');
        }
    }
    
    public function actionOdeslano($objednavkaID) {
        if ($this->user->isInRole("admin")) {
            $this->objednavkyManager->odeslanaObjednavka($objednavkaID);
            $this->redirect('admin');
        }
    }

    public function createComponentObjednavkaForm() {
        $form = new Form;
        $form->addText('jmeno', 'Jméno:')
                ->setRequired();
        $form->addText('prijmeni', 'Příjmení:')
                ->setRequired();
        $form->addText('adresa', 'Adresa:')
                ->setRequired();
        $form->addText('mesto', 'Město:')
                ->setRequired();
        $form->addText('psc', 'PSČ:')
                ->setRequired()
                ->addRule(Form::PATTERN, 'PSČ musí mít 5 číslic', '([0-9]\s*){5}');
        $form->addSubmit('send', 'Objednej');
        $form->onSuccess[] = array($this, 'vytvorObjednavku');
        return $form;
    }

    public function vytvorObjednavku($form, $values) {
        $idKosiku = $this->getParameter('idKosiku');
        $this->objednavkyManager->objednejKosik($this->user->id, $idKosiku, $values->jmeno, $values->prijmeni, $values->adresa, $values->mesto, $values->psc);
        $this->flashMessage('Košík byl objednán', 'success');
        $this->redirect('default');
    }

}
