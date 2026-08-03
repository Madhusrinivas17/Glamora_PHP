<?php
declare(strict_types=1);

namespace App\Controller;

use Cake\Controller\Controller;
use Cake\Event\EventInterface;

class AppController extends Controller
{
    public function initialize(): void
    {
        parent::initialize();

        $this->loadComponent('Flash');
        $this->loadComponent('Authentication.Authentication');
    }

    public function beforeFilter(EventInterface $event)
    {
        parent::beforeFilter($event);
        
        $identity = $this->Authentication->getIdentity();
        $authUser = $identity ? $identity->getOriginalData() : null;
        $isAdmin = ($authUser && isset($authUser->role) && $authUser->role === 'admin');

        $this->set(compact('authUser', 'isAdmin'));
    }
}
