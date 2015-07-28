<?php

namespace App\Presenters;

use Nette;
use App\Model;

abstract class BaseAdminPresenter extends BasePresenter
{
    protected function startup()
    {
        if (!$this->getUser()->isLoggedIn()) {
            $this->redirect(':Sign:in');
        }

        parent::startup();
    }
}
