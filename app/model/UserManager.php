<?php

namespace App\Model;

use Nette,
    Nette\Utils\Strings,
    Nette\Mail\Message,
    Nette\Mail\SmtpMailer,
    Nette\Security\Passwords;

/**
 * Users management.
 */
class UserManager extends Nette\Object implements Nette\Security\IAuthenticator {

    const
            TABLE_NAME = 'uzivatele',
            COLUMN_ID = 'id_uzivatele',
            COLUMN_NAME = 'email',
            COLUMN_PASSWORD_HASH = 'heslo',
            COLUMN_ROLE = 'role',
            COLUMN_ACTIVED = 'actived',
            COLUMN_ACTIV_CODE = 'activ_code';

    /** @var Nette\Database\Context */
    private $database;

    public function __construct(Nette\Database\Context $database) {
        $this->database = $database;
    }

    /**
     * Performs an authentication.
     * @return Nette\Security\Identity
     * @throws Nette\Security\AuthenticationException
     */
    public function authenticate(array $credentials) {
        list($username, $password) = $credentials;

        $row = $this->database->table(self::TABLE_NAME)->where(self::COLUMN_NAME, $username)->fetch();

        if (!$row) {
            throw new Nette\Security\AuthenticationException('The username is incorrect.', self::IDENTITY_NOT_FOUND);
        } elseif (!Passwords::verify($password, $row[self::COLUMN_PASSWORD_HASH])) {
            throw new Nette\Security\AuthenticationException('The password is incorrect.', self::INVALID_CREDENTIAL);
        } elseif (Passwords::needsRehash($row[self::COLUMN_PASSWORD_HASH])) {
            $row->update(array(
                self::COLUMN_PASSWORD_HASH => Passwords::hash($password),
            ));
        }

        $arr = $row->toArray();
        unset($arr[self::COLUMN_PASSWORD_HASH]);
        return new Nette\Security\Identity($row[self::COLUMN_ID], $row[self::COLUMN_ROLE], $arr);
    }

    /**
     * Adds new user.
     * @param  string
     * @param  string
     * @return void
     */
    public function add($username, $password) {
        $params = array(
            'activCode' => Strings::random(150, 'A-Za-z0-9'));
        $latte = new Nette\Latte\Engine;
        $latte->renderToString('registremail.latte', $params);
//        $template = $this->createTemplate()->setFile('registrEmail.latte');
        $mail = new Message;
        $mail->setFrom('Franta <tofisk@gmail.com>')
                ->addTo($username)
                ->setSubject('Potvrzení registrace')
                ->setBody($latte);
        $mailer = new Nette\Mail\SmtpMailer(array(
            'host' => 'smtp.gmail.com',
            'username' => 'tofisk@gmail.com',
            'password' => 'rh7u5b24h',
            'secure' => 'ssl',
        ));
        $mailer->send($mail);
        $this->database->table(self::TABLE_NAME)->insert(array(
            self::COLUMN_NAME => $username,
            self::COLUMN_PASSWORD_HASH => Passwords::hash($password),
            self::COLUMN_ACTIV_CODE => $$params->activ_code
        ));
    }

}
