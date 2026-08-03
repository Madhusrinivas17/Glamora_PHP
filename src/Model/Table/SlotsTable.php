<?php
namespace App\Model\Table;

use Cake\ORM\Table;

class SlotsTable extends Table
{
    public function initialize(array $config): void
    {
        parent::initialize($config);

        $this->setTable('slots');
        $this->setPrimaryKey('id');

        $this->addBehavior('Timestamp');

        $this->belongsTo('Beauticians', [
            'foreignKey' => 'beautician_id',
        ]);
        $this->hasMany('Appointments', [
            'foreignKey' => 'slot_id',
        ]);
    }
}
