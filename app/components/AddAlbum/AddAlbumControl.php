<?php

namespace App\Components;

use App\Models\AlbumModel;
use Nette\Application\UI\Form;

class AddAlbumControl extends BaseControl
{
    /**
     * @var AlbumModel
     */
    private $albumModel;


    /**
     * AddAlbumControl constructor.
     * @param AlbumModel $albumModel
     */
    public function __construct(AlbumModel $albumModel)
    {
        $this->albumModel = $albumModel;
    }

    /**
     * @param string $name
     */
    public function createComponentAddAlbumForm($name)
    {
        $form = new Form($this, $name);

        $form->addText('artist', 'Artist')
            ->setRequired();
        $form->addText('albumName', 'Album name')
            ->setRequired();
        $form->addText('year', 'Year');
        $form->addSubmit('save', 'Add new album');

        $form->onSuccess[] = $this->successAddAlbumForm;
    }

    /**
     * @param Form $form
     */
    public function successAddAlbumForm(Form $form)
    {
        $this->albumModel->addAlbum($form->getValues());
        $this->flashMessage('Album has been added');

        $this->presenter->redirect(':Albums:List');
    }
}