<?php
namespace App\Model\Table;

use Cake\ORM\Table;

class AppointmentsTable extends Table
{
    public function initialize(array $config): void
    {
        parent::initialize($config);

        $this->setTable('appointments');
        $this->setPrimaryKey('id');

        $this->addBehavior('Timestamp');

        $this->belongsTo('Users', [
            'foreignKey' => 'user_id',
            'joinType' => 'INNER',
        ]);
        $this->belongsTo('Services', [
            'foreignKey' => 'service_id',
            'joinType' => 'INNER',
        ]);
        $this->belongsTo('Beauticians', [
            'foreignKey' => 'beautician_id',
        ]);
        $this->belongsTo('Slots', [
            'foreignKey' => 'slot_id',
        ]);
        $this->hasOne('Payments', [
            'foreignKey' => 'appointment_id',
            'dependent' => true,
        ]);
        $this->hasMany('CustomerHistories', [
            'foreignKey' => 'appointment_id',
        ]);
    }
}
