<?php

namespace App\Presenters;

use Nette,
    Nette\Utils\Strings,
    Nette\Mail\Message,
    Nette\Mail\SmtpMailer,
    Nette\Tracy\Debugger,
    App\Model\UserManager;

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
     * @var Nette\Mail\SmtpMailer 
     * @inject
     */
    public $mailer;

    public function __construct(Nette\Database\Context $database) {
        $this->database = $database;
    }

    /**
     * Sign-in form factory.
     * @return Nette\Application\UI\Form
     */
    protected function createComponentSignInForm() {
        $form = new Nette\Application\UI\Form;
        $form->addText('email', 'Email:')
                ->setRequired('Napis svuj mail');

        $form->addPassword('heslo', 'heslo:')
                ->setRequired('Napis svoje heslo.');

        //$form->addCheckbox('remember', 'Keep me signed in');

        $form->addSubmit('send', 'Prihlasit');

        // call method signInFormSucceeded() on success
        $form->onSuccess[] = array($this, 'signInFormSucceeded');
        return $form;
    }

    protected function createComponentNewUserForm() {
        $form = new Nette\Application\UI\Form;
        $form->addText('email', 'Email:')
                ->setRequired('Napis svuj mail');

        $form->addPassword('heslo', 'heslo:')
                ->setRequired('Napis svoje heslo.');

        $form->addPassword('hesloZnova', 'zopakovat heslo:')
                ->setRequired('Napis svoje heslo.');

        //$form->addCheckbox('remember', 'Keep me signed in');

        $form->addSubmit('send', 'Registrovat');

        // call method signInFormSucceeded() on success
        $form->onSuccess[] = array($this, 'addUserFormSucceeded');
        return $form;
    }

    public function signInFormSucceeded($form, $values) {

        try {
            $this->user->login($values->email, $values->heslo);
            $this->flashMessage('Uspesne prihlaseni.', 'success');
            $this->redirect('Homepage:');
        } catch (Nette\Security\AuthenticationException $e) {
            $form->addError($e->getMessage());
        }
    }

    public function addUserFormSucceeded($form, $values) {
        $values->activ_code = Strings::random(150, 'A-Za-z0-9');
        $mail = new Message;
        $mail->setFrom('Franta <tofisk@gmail.com>')
                ->addTo('krystofstekovic@gmail.com')
                ->setSubject('Potvrzení registrace')
                ->setBody($values->activ_code);
        $mailer = new Nette\Mail\SmtpMailer(array(
            'host' => 'smtp.gmail.com',
            'username' => 'tofisk@gmail.com',
            'password' => 'rh7u5b24h',
            'secure' => 'ssl',
        ));
        $mailer->send($mail);
        $this->userManager->add($values->email, $values->heslo);
        $this->flashMessage('Uspesna registrace.', 'success');
        $this->redirect('Homepage:');
    }

    public function actionOut() {
        $this->user->logout();
        $this->flashMessage('Byl jste odhlasen.');
        $this->redirect('in');
    }

}
