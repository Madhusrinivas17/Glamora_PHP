<?php
namespace App\Model\Table;

use Cake\ORM\Table;
use Cake\Validation\Validator;

class UsersTable extends Table
{
    public function initialize(array $config): void
    {
        parent::initialize($config);

        $this->setTable('users');
        $this->setDisplayField('full_name');
        $this->setPrimaryKey('id');

        $this->addBehavior('Timestamp');

        $this->hasOne('Admins', [
            'foreignKey' => 'user_id',
            'dependent' => true,
        ]);
        $this->hasMany('Appointments', [
            'foreignKey' => 'user_id',
        ]);
        $this->hasMany('Notifications', [
            'foreignKey' => 'user_id',
        ]);
        $this->hasMany('Reviews', [
            'foreignKey' => 'user_id',
        ]);
        $this->hasMany('CustomerHistories', [
            'foreignKey' => 'user_id',
        ]);
    }

    public function validationDefault(Validator $validator): Validator
    {
        $validator
            ->integer('id')
            ->allowEmptyString('id', null, 'create');

        $validator
            ->scalar('full_name')
            ->maxLength('full_name', 150)
            ->requirePresence('full_name', 'create')
            ->notEmptyString('full_name', 'Full name is required.');

        $validator
            ->email('email', false, 'Please enter a valid email address.')
            ->requirePresence('email', 'create')
            ->notEmptyString('email', 'Email is required.');

        $validator
            ->scalar('phone')
            ->maxLength('phone', 30)
            ->requirePresence('phone', 'create')
            ->notEmptyString('phone', 'Phone number is required.');

        $validator
            ->scalar('password')
            ->minLength('password', 6, 'Password must be at least 6 characters.')
            ->requirePresence('password', 'create')
            ->notEmptyString('password', 'Password is required.');

        $validator
            ->scalar('role')
            ->inList('role', ['user', 'admin'], 'Invalid user role.');

        return $validator;
    }
}
