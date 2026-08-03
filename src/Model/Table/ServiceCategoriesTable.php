<?php
namespace App\Model\Table;

use Cake\ORM\Table;

class ServiceCategoriesTable extends Table
{
    public function initialize(array $config): void
    {
        parent::initialize($config);

        $this->setTable('service_categories');
        $this->setDisplayField('name');
        $this->setPrimaryKey('id');

        $this->addBehavior('Timestamp');

        $this->hasMany('Services', [
            'foreignKey' => 'category_id',
        ]);
    }
}
