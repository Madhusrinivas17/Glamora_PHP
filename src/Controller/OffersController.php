<?php
declare(strict_types=1);

namespace App\Controller;

use Cake\Event\EventInterface;

class OffersController extends AppController
{
    public function beforeFilter(EventInterface $event)
    {
        parent::beforeFilter($event);
        $this->Authentication->addUnauthenticatedActions(['index']);
    }

    public function index()
    {
        $offersTable = $this->fetchTable('Offers');
        $offers = $offersTable->find()
            ->where(['is_active' => 1])
            ->order(['start_date' => 'DESC'])
            ->all();

        $this->set(compact('offers'));
    }
}
