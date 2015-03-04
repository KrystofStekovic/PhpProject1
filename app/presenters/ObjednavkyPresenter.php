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
        $this->template->kosiky = $this->kosikManager->getPrehledKosiku($this->user);
    }
    
    public function renderDetail($idKosiku) {
        $this->template->produkty = $this->kosikManager->getObsahKosiku($idKosiku);
    }
}
