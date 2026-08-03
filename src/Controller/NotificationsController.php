<?php
declare(strict_types=1);

namespace App\Controller;

class NotificationsController extends AppController
{
    public function index()
    {
        $identity = $this->Authentication->getIdentity();
        $notificationsTable = $this->fetchTable('Notifications');

        $notifications = $notificationsTable->find()
            ->where(['user_id' => $identity->id])
            ->order(['created' => 'DESC'])
            ->all();

        $this->set(compact('notifications'));
    }

    public function markRead($id = null)
    {
        $identity = $this->Authentication->getIdentity();
        $notificationsTable = $this->fetchTable('Notifications');

        $notification = $notificationsTable->find()
            ->where(['id' => $id, 'user_id' => $identity->id])
            ->first();

        if ($notification) {
            $notification->is_read = 1;
            $notificationsTable->save($notification);
        }

        return $this->redirect(['action' => 'index']);
    }
}
