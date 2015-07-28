<?php

namespace App\Presenters;

use App\Components\EditUserCollectionControl;
use App\Models\Entities\User;

class UsersPresenter extends BaseAdminPresenter
{
    /**
     * @var User
     */
    private $user;

    public function actionList()
    {
        $this->template->users = $this->context->userModel->getAll();
    }

    /**
     * @param int $userId
     */
    public function actionEditCollection($userId)
    {
        $this->user = $this->context->userModel->get($userId);
    }

    /**
     * @return EditUserCollectionControl
     */
    public function createComponentEditUserCollectionControl()
    {
        return new EditUserCollectionControl($this->user, $this->context->userModel, $this->context->albumModel);
    }

    /**
     * @param int $userId
     */
    public function actionDelete($userId)
    {
        $this->context->usersModel->delete($userId);

        $this->flashMessage('User has been deleted');
        $this->redirect('list');
    }
}