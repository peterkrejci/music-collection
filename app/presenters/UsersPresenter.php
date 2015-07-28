<?php

namespace App\Presenters;

class UsersPresenter extends BasePresenter
{
    public function actionList()
    {
        $this->template->users = $this->context->userModel->getAll();
    }

    /**
     * @param integer $userId
     */
    public function actionEdit($userId)
    {

    }

    /**
     * @param integer $userId
     */
    public function actionDelete($userId)
    {
        $this->context->usersModel->delete($userId);

        $this->flashMessage('User has been deleted');
        $this->redirect('list');
    }
}