<?php
namespace App\Model\Table;

use Cake\ORM\Table;

class AdminsTable extends Table
{
    public function initialize(array $config): void
    {
        parent::initialize($config);

        $this->setTable('admins');
        $this->setDisplayField('parlour_name');
        $this->setPrimaryKey('id');

        $this->addBehavior('Timestamp');

        $this->belongsTo('Users', [
            'foreignKey' => 'user_id',
            'joinType' => 'INNER',
        ]);
        $this->hasOne('Parlours', [
            'foreignKey' => 'admin_id',
        ]);
    }
}
