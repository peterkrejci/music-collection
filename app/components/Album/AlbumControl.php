<?php

namespace App\Components;

use App\Models\AlbumModel;
use App\Models\Entities\Album;
use Nette\Application\UI\Form;

class AlbumControl extends BaseControl
{
    /**
     * @var AlbumModel
     */
    private $albumModel;

    /**
     * @var Album
     */
    private $album;

    /**
     * AddAlbumControl constructor.
     * @param AlbumModel $albumModel
     * @param Album $album
     */
    public function __construct(AlbumModel $albumModel, Album $album = NULL)
    {
        $this->albumModel = $albumModel;
        $this->album = $album;
    }

    /**
     * @param string $name
     */
    public function createComponentAlbumForm($name)
    {
        $form = new Form($this, $name);

        $form->addText('artist', 'Artist')
            ->setRequired();
        $form->addText('albumName', 'Album name')
            ->setRequired();
        $form->addText('year', 'Year');

        if ($this->album) {
            $form->setDefaults([
                'artist' => $this->album->getArtist(),
                'albumName' => $this->album->getAlbumName(),
                'year' => $this->album->getYear(),
            ]);

            $form->addSubmit('save', 'Edit album');
            $form->onSuccess[] = $this->successEditAlbumForm;
        } else {
            $form->addSubmit('save', 'Add new album');
            $form->onSuccess[] = $this->successAddAlbumForm;
        }
    }

    /**
     * @param Form $form
     */
    public function successAddAlbumForm(Form $form)
    {
        $this->albumModel->add($form->getValues());
        $this->presenter->flashMessage('Album has been added');

        $this->presenter->redirect(':Albums:List');
    }

    /**
     * @param Form $form
     */
    public function successEditAlbumForm(Form $form)
    {
        $this->albumModel->edit($this->album, $form->getValues());
        $this->presenter->flashMessage('Album has been edited');

        $this->presenter->redirect(':Albums:List');
    }
}