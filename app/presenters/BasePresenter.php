<?php

namespace App\Presenters;

use Nette,
    Nette\Application\UI\Form,
    Nette\Security\User;


/**
 * Base presenter for all application presenters.
 */
abstract class BasePresenter extends Nette\Application\UI\Presenter
{

    protected $database;

}
