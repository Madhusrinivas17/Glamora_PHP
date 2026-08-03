<?php
namespace App\Model\Table;

use Cake\ORM\Table;
use Cake\Validation\Validator;

class OtpVerificationsTable extends Table
{
    public function initialize(array $config): void
    {
        parent::initialize($config);

        $this->setTable('otp_verifications');
        $this->setDisplayField('user_email');
        $this->setPrimaryKey('id');

        $this->addBehavior('Timestamp');
    }

    public function validationDefault(Validator $validator): Validator
    {
        $validator
            ->integer('id')
            ->allowEmptyString('id', null, 'create');

        $validator
            ->email('user_email', false, 'Please enter a valid email address.')
            ->requirePresence('user_email', 'create')
            ->notEmptyString('user_email', 'Email is required.');

        $validator
            ->scalar('otp_code')
            ->requirePresence('otp_code', 'create')
            ->notEmptyString('otp_code', 'OTP code is required.');

        return $validator;
    }
}
