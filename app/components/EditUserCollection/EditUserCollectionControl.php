<?php

namespace App\Components;

use App\Models\AlbumModel;
use App\Models\Entities\Album;
use App\Models\Entities\User;
use App\Models\UserModel;
use Nette\Application\UI\Form;

class EditUserCollectionControl extends BaseControl
{
    /**
     * @var User
     */
    private $user;

    /**
     * @var UserModel
     */
    private $userModel;

    /**
     * @var AlbumModel
     */
    private $albumModel;

    /**
     * EditUserCollectionControl constructor.
     * @param User $user
     * @param UserModel $userModel
     * @param AlbumModel $albumModel
     */
    public function __construct(User $user, UserModel $userModel, AlbumModel $albumModel)
    {
        $this->user = $user;
        $this->userModel = $userModel;
        $this->albumModel = $albumModel;
    }

    /**
     * @param $name
     */
    public function createComponentEditUserCollectionForm($name)
    {
        $form = new Form($this, $name);
        $albumsContainer = $form->addContainer('albums');

        $albums = $this->albumModel->getAll();

        /**
         * @var Album $album
         */
        foreach ($albums as $album) {
            $label = $album->getAlbumName() . '(' . $album->getArtist() . ', ' . $album->getYear() . ')';
            $albumsContainer->addCheckbox($album->getAlbumId(), $label);
        }

        foreach ($this->user->getAlbums() as $userAlbums) {
            $albumsContainer[$userAlbums->getAlbumId()]->setDefaultValue(TRUE);
        }


        $form->addSubmit('assign', 'Assign');

        $form->onSuccess[] = $this->successEditUserCollectionForm;
    }

    /**
     * @param Form $form
     */
    public function successEditUserCollectionForm(Form $form)
    {
        $albumIds = $form->values->albums;
        $albums = [];

        foreach ($albumIds as $albumId => $isSet) {
            if ($isSet) {
                $albums[] = $this->albumModel->get($albumId);
            }
        }

        $this->userModel->assignAlbums($this->user, $albums);

        $this->presenter->flashMessage('Albums have been assigend');
        $this->presenter->redirect(':Users:List');
    }
}