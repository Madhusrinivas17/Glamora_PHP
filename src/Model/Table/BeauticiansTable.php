<?php
namespace App\Model\Table;

use Cake\ORM\Table;

class BeauticiansTable extends Table
{
    public function initialize(array $config): void
    {
        parent::initialize($config);

        $this->setTable('beauticians');
        $this->setDisplayField('name');
        $this->setPrimaryKey('id');

        $this->addBehavior('Timestamp');

        $this->hasMany('Slots', [
            'foreignKey' => 'beautician_id',
        ]);
        $this->hasMany('Appointments', [
            'foreignKey' => 'beautician_id',
        ]);
        $this->hasMany('Availabilities', [
            'foreignKey' => 'beautician_id',
        ]);
    }
}
