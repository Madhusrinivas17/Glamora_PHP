<?php
namespace App\Model\Table;

use Cake\ORM\Table;

class OffersTable extends Table
{
    public function initialize(array $config): void
    {
        parent::initialize($config);

        $this->setTable('offers');
        $this->setPrimaryKey('id');

        $this->addBehavior('Timestamp');
    }
}
