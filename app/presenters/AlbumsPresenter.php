<?php

namespace App\Presenters;

use App\Components\AlbumControl;
use App\Models\Entities\Album;

class AlbumsPresenter extends BasePresenter
{
    /**
     * @var Album
     */
    private $album;

    public function actionList()
    {
        $this->template->albums = $this->context->albumModel->getAll();
    }

    public function actionEdit($albumId)
    {
        $this->album = $this->context->albumModel->get($albumId);
    }

    /**
     * @param $albumId
     */
    public function actionDelete($albumId)
    {
        $this->context->albumModel->delete($albumId);
        $this->flashMessage('Album has been deleted');
        $this->redirect('list');
    }

    /**
     * @return AlbumControl
     */
    public function createComponentAddAlbumControl()
    {
        return new AlbumControl($this->context->albumModel);
    }
    /**
     * @return AlbumControl
     */
    public function createComponentEditAlbumControl()
    {
        return new AlbumControl($this->context->albumModel, $this->album);
    }
}