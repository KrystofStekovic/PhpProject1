<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace App\Model;

use Nette,
    Nette\Mail\Message;

/**
 * Description of ProduktyManager
 *
 * @author Krystof
 */
class MailManager extends Nette\Object {

    /** @var Nette\Mail\Mailer */
    private $mailer;

    public function __construct(Nette\Mail\SmtpMailer $mailer) {
        $this->mailer = $mailer;
    }
    
    public function sendRegEmail($email, $html){
        $mail = new Message;
        $mail->setFrom('BioCulture <registrace@bioculture.cz>')
                ->addTo($email)
                ->setSubject('Potvrzení registrace')
                ->setHtmlBody($html);
        $this->mailer->send($mail);
    }

    public function sendForgotPass($email, $html) {
        $mail = new Message;
        $mail->setFrom('BioCulture <registrace@bioculture.cz>')
                ->addTo($email)
                ->setSubject('Potvrzení změny hesla')
                ->setHtmlBody($html);
        $this->mailer->send($mail);
        
    }

}
