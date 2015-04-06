<?php

namespace App\Model;

use Nette,
    Nette\Utils\Strings,
    Nette\Mail\Message,
    Nette\Mail\SmtpMailer,
    Nette\Security\Passwords,
    Nette\Tracy\Debugger;

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

        $row = $this->database->table(self::TABLE_NAME)->where('email = ? AND actived = ?', $username, 1)->fetch();

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
     * @param String username registracni email
     * @param String password heslo uzivatele
     * @param String activeCode aktivacni cod
     */
    public function add($username, $password, $activeCode) {
        $this->database->table(self::TABLE_NAME)->insert(array(
            self::COLUMN_NAME => $username,
            self::COLUMN_PASSWORD_HASH => Passwords::hash($password),
            self::COLUMN_ACTIV_CODE => $activeCode
        ));
    }
    
    /**
     * Aktivuje ucet uzivatele pokud se aktivacni cod shoduje s udajem v databazi
     * @param String activCode aktivacni cod
     */
    public function activateUser($activCode) {
        $user = $this->database->table(self::TABLE_NAME)->where('activ_code = ?', $activCode);
        $user->update(array(self::COLUMN_ACTIVED => 1));
    }

    public function changePass($email, $heslo, $stareHeslo) {
        $user = $this->database->table(self::TABLE_NAME)->where('email = ? AND heslo', $email);
        if($stareHeslo){
            
        }
    }

}
