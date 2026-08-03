<?php
namespace App\Model\Table;

use Cake\ORM\Table;

class ParloursTable extends Table
{
    public function initialize(array $config): void
    {
        parent::initialize($config);

        $this->setTable('parlours');
        $this->setDisplayField('name');
        $this->setPrimaryKey('id');

        $this->addBehavior('Timestamp');

        $this->belongsTo('Admins', [
            'foreignKey' => 'admin_id',
        ]);
    }
}
