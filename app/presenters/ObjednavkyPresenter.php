<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace App\Presenters;

use Nette;

/**
 * Description of ObjednavkyPresenter
 *
 * @author sasa
 */
class ObjednavkyPresenter extends BasePresenter{
    
    /**
     * @var \App\Model\KosikManager
     * @inject
     */
    public $kosikManager;
    
    public function renderDefault() {
        $this->template->kosiky = $this->kosikManager->getPrehledKosiku($this->user, null);
    }
    
    public function renderDetail($idKosiku) {
        $this->template->produkty = $this->kosikManager->getObsahKosiku($idKosiku);
        $this->template->prehled = $this->kosikManager->getPrehledKosiku($this->user, $idKosiku)->fetch();
    }
    
    public function renderObjednejKosik($idKosiku){
        
    }

    public function actionSmazatProdukt($produktId, $kosikId) {
        $this->kosikManager->smazProdukt($produktId, $kosikId);
        $this->redirect('detail?idKosiku='.$kosikId);
    }
}
