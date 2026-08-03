<?php
namespace App\Model\Table;

use Cake\ORM\Table;

class AvailabilitiesTable extends Table
{
    public function initialize(array $config): void
    {
        parent::initialize($config);

        $this->setTable('availabilities');
        $this->setPrimaryKey('id');

        $this->addBehavior('Timestamp');

        $this->belongsTo('Beauticians', [
            'foreignKey' => 'beautician_id',
            'joinType' => 'INNER',
        ]);
    }
}
