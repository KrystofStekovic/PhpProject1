<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of KosikPresenter
 *
 * @author Krystof
 */
class KosikPresenter {
    
    /**
     * @var \App\Model\KosikManager
     * @inject
     */
    public $kosikManager;
    
   
    
    protected function createComponentSignInForm() {
        $form = new Nette\Application\UI\Form;
        $form->addText('mnozstvi', 'Email:')
                ->setRequired('Napis svuj mail');

        $form->addPassword('heslo', 'heslo:')
                ->setRequired('Napis svoje heslo.');

        //$form->addCheckbox('remember', 'Keep me signed in');

        $form->addSubmit('send', 'Prihlasit');

        // call method signInFormSucceeded() on success
        $form->onSuccess[] = array($this, 'signInFormSucceeded');
        return $form;
    }
}
