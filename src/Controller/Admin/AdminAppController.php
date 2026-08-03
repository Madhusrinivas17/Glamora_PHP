<?php
declare(strict_types=1);

namespace App\Controller\Admin;

use App\Controller\AppController;
use Cake\Event\EventInterface;

class AdminAppController extends AppController
{
    public function beforeFilter(EventInterface $event)
    {
        parent::beforeFilter($event);

        $identity = $this->Authentication->getIdentity();
        if (!$identity || $identity->role !== 'admin') {
            $this->Flash->error(__('Access Denied. You must log in as an Admin/Salon Owner to view this section.'));
            return $this->redirect('/login?role=admin');
        }

        $this->viewBuilder()->setLayout('admin');
    }
}
