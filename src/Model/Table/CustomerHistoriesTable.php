<?php
namespace App\Model\Table;

use Cake\ORM\Table;

class CustomerHistoriesTable extends Table
{
    public function initialize(array $config): void
    {
        parent::initialize($config);

        $this->setTable('customer_histories');
        $this->setPrimaryKey('id');

        $this->addBehavior('Timestamp');

        $this->belongsTo('Users', [
            'foreignKey' => 'user_id',
            'joinType' => 'INNER',
        ]);
        $this->belongsTo('Appointments', [
            'foreignKey' => 'appointment_id',
        ]);
    }
}
