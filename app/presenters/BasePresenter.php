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
                ->setRequired('Napiš svůj email')
                ->addRule(Form::EMAIL, 'Zadej správně email');

        $form->addPassword('heslo', 'heslo:')
                ->setRequired('Napiš svoje heslo.');

        $form->addSubmit('send', 'Přihlásit');

        // call method signInFormSucceeded() on success
        $form->onSuccess[] = array($this, 'signInFormSucceeded');
        return $form;
    }

    public function signInFormSucceeded($form, $values) {

        try {
            $this->user->login($values->email, $values->heslo);
            $this->flashMessage('Podařilo se úspěšně přihlásit.', 'success');
            $this->redirect('Homepage:');
        } catch (Nette\Security\AuthenticationException $e) {
            $this->flashMessage('Nepodařilo se úspěšně přihlásit, zkuste to prosím znova.', 'success');
        }
    }

}
