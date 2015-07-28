<?php

namespace App\Components;

use Nette\Application\UI\Control;

class BaseControl extends Control
{
    public function render()
    {
        $reflection = $this->getReflection();
        $this->template->setFile(
            dirname($reflection->getFileName()) . DIRECTORY_SEPARATOR . $reflection->getShortName() . '.latte'
        );
        $this->template->render();
    }
}