<?php
namespace App\Model\Table;

use Cake\ORM\Table;

class ServicesTable extends Table
{
    public function initialize(array $config): void
    {
        parent::initialize($config);

        $this->setTable('services');
        $this->setDisplayField('name');
        $this->setPrimaryKey('id');

        $this->addBehavior('Timestamp');

        $this->belongsTo('ServiceCategories', [
            'foreignKey' => 'category_id',
            'joinType' => 'INNER',
        ]);
        $this->hasMany('Appointments', [
            'foreignKey' => 'service_id',
        ]);
        $this->hasMany('Reviews', [
            'foreignKey' => 'service_id',
        ]);
        $this->hasMany('Favorites', [
            'foreignKey' => 'service_id',
        ]);
    }
}
