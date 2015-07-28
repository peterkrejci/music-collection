<?php

namespace App\Presenters;

use App\Components\AddAlbumControl;

class AlbumsPresenter extends BasePresenter
{
    public function actionList()
    {
        $this->template->albums = $this->context->albumModel->getAll();
    }

    public function actionEdit($albumId)
    {

    }

    public function actionDelete($albumId)
    {

    }

    /**
     * @return AddAlbumControl
     */
    public function createComponentAddAlbumControl()
    {
        return new AddAlbumControl($this->context->albumModel);
    }
}