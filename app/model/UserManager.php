<?php

namespace App\Model;

use Nette,
    Nette\Utils\Strings,
    Nette\Mail\Message,
    Nette\Mail\SmtpMailer,
    Nette\Security\Passwords,
    Nette\Tracy\Debugger,
    Exception;

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
            COLUMN_ACTIV_CODE = 'activ_code',
            COLUMN_NEW_PASS = 'new_pass';

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
     * @param  string
     * @param  string
     * @return void
     * @throws Exception
     */
    public function add($username, $password, $activeCode) {
        $user = $this->database->table(self::TABLE_NAME)->where('email = ?', $username)->fetch();
        if($user){
            throw new Exception('Uživatel s touto emailovou adresou je již registrovaný.');
        }
        $params = array(
            'activCode' => Strings::random(150, 'A-Za-z0-9'));
        $this->database->table(self::TABLE_NAME)->insert(array(
            self::COLUMN_NAME => $username,
            self::COLUMN_PASSWORD_HASH => Passwords::hash($password),
            self::COLUMN_ACTIV_CODE => $activeCode
        ));
    }

    public function activateUser($activCode) {
        $user = $this->database->table(self::TABLE_NAME)->where('activ_code = ?', $activCode);
        $user->update(array(self::COLUMN_ACTIVED => 1));
    }

    public function changePass($email, $newPass, $oldPass, $activCode) {
        $user = $this->database->table(self::TABLE_NAME)->where('email = ?', $email)->fetch();
        if(!$user){
            throw new Exception('Uživatel s touto emailovou adresou není registrovaný.');
        }
        if (!$oldPass) {
            // vytvorit nove heslo a pockat po potvrzeni pres 
            $user = $this->database->table(self::TABLE_NAME)->where('email = ?', $email);
            $user->update(array(self::COLUMN_NEW_PASS => Passwords::hash($newPass),
                self::COLUMN_ACTIV_CODE => $activCode));
        } else {
            // prima zmena s overenim stejnosti stareho 
            $user = $this->database->table(self::TABLE_NAME)->where('email = ? AND heslo ?', array(
                self::COLUMN_NAME => $email,
                self::COLUMN_PASSWORD_HASH => Passwords::hash($oldPass)));
            $user->update(array(self::COLUMN_PASSWORD_HASH => Passwords::hash($newPass),
                self::COLUMN_ACTIV_CODE => $activCode));
        }
    }

    public function confirmChangePass($email, $activCode) {
//        $user = $this->database->table(self::TABLE_NAME)->where('activ_code = ? AND email = ?', array(
//                    self::COLUMN_NAME => $email,
//                    self::COLUMN_ACTIV_CODE => $activCode))->fetch();
        $user = $this->database->table(self::TABLE_NAME)->where('activ_code = ?', $activCode)->fetch();
        if ($user) {
            $user->update(array(
                self::COLUMN_PASSWORD_HASH => $user[self::COLUMN_NEW_PASS]
            ));
        }
    }

}
