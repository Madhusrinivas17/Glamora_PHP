<?php
namespace App\Model\Entity;

use Cake\ORM\Entity;

class OtpVerification extends Entity
{
    protected array $_accessible = [
        '*' => true,
        'id' => false,
    ];
}
