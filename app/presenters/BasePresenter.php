<?php

namespace App\Presenters;

use Nette,
    Nette\Application\UI\Form;

/**
 * Base presenter for all application presenters.
 */
abstract class BasePresenter extends Nette\Application\UI\Presenter {

    protected $database;

    /**
     * Sign-in form factory.
     * @return Nette\Application\UI\Form
     */
    protected function createComponentSignInForm() {
        $form = new Nette\Application\UI\Form;
        $form->addText('email', 'Email:')
                ->setRequired('Napis svuj mail');
//                ->addRule(Form::EMAIL, 'zadej spravne email');

        $form->addPassword('heslo', 'heslo:')
                ->setRequired('Napis svoje heslo.');

        $form->addSubmit('send', 'Prihlasit');

        // call method signInFormSucceeded() on success
        $form->onSuccess[] = array($this, 'signInFormSucceeded');
        return $form;
    }

    public function signInFormSucceeded($form, $values) {

        try {
            $this->user->login($values->email, $values->heslo);
            $this->flashMessage('Uspesne prihlaseni.', 'success');
            $this->redirect('Homepage:');
        } catch (Nette\Security\AuthenticationException $e) {
            $form->addError($e->getTrace());
        }
    }

}
