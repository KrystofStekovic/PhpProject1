<?php

namespace App\Presenters;

use Nette,
    Nette\Utils\Strings,
    Nette\Application\UI\Form;

/**
 * Sign in/out presenters.
 */
class SignPresenter extends BasePresenter {

    /**
     * @var \App\Model\UserManager
     * @inject
     */
    public $userManager;

    /**
     * @var \App\Model\MailManager 
     * @inject
     */
    public $mailManager;

    public function __construct(Nette\Database\Context $database) {
        $this->database = $database;
    }

    protected function createComponentNewUserForm() {
        $form = new Nette\Application\UI\Form;
        $form->addText('email', 'Email:')
                ->setRequired('Napis svuj mail')
                ->addRule(Form::EMAIL, 'Zadej správně email');
        $form->addPassword('heslo', 'Heslo:')
                ->setRequired('Napiš svoje heslo.');
        $form->addPassword('hesloZnova', 'Zopakovat heslo:')
                ->setRequired('Napiš svoje heslo znovu pro kontrolu.')
                ->addRule(Form::EQUAL, 'Hesla se neshodují', $form['heslo']);
        $form->addSubmit('send', 'Registrovat');
        // call method signInFormSucceeded() on success
        $form->onSuccess[] = array($this, 'addUserFormSucceeded');
        return $form;
    }

    protected function createComponentForgotPass() {
        $form = new Nette\Application\UI\Form;
        $form->addText('email', 'Email:')
                ->setRequired('Napis svuj mail')
                ->addRule(Form::EMAIL, 'Zadej správně email');
        $form->addPassword('heslo', 'Heslo:')
                ->setRequired('Napiš svoje heslo.');
        $form->addPassword('hesloZnova', 'Zopakovat heslo:')
                ->setRequired('Napiš svoje heslo.')
                ->addRule(Form::EQUAL, 'Hesla se neshodují', $form['heslo']);
        $form->addSubmit('send', 'Obnovit heslo');
        // call method signInFormSucceeded() on success
        $form->onSuccess[] = array($this, 'forgorPassFormSucceeded');
        return $form;
    }

    public function addUserFormSucceeded($form, $values) {
        try {
            $activCode = Strings::random(150, 'A-Za-z0-9');
            $this->userManager->add($values->email, $values->heslo, $activCode);
            $latte = new \Latte\Engine();
            $params = array('activCode' => $activCode);
            $html = $latte->renderToString(__DIR__ . '/../templates/regemail.latte', $params);
            $this->mailManager->sendRegEmail($values->email, $html);
            $this->flashMessage('Pro dokončení registrace kliněte na aktivační odkaz, který vám byl odeslán na email', 'success');
            $this->redirect('Homepage:');
        } catch (Exception $exc) {
//            echo $exc->getTraceAsString();
        }
    }

    public function forgorPassFormSucceeded($form, $values) {
        $this->userManager->changePass($values->email, $values->heslo, null);
    }

    public function actionOut() {
        $this->user->logout();
        $this->flashMessage('Byl jste odhlasen.');
        $this->redirect('in');
    }

    public function actionAktivUser($activCode) {
//        var_dump($activCode);
        $this->userManager->activateUser($activCode);
        $this->flashMessage('Účet byl aktivován.');
        $this->redirect('Homepage:');
    }

}
