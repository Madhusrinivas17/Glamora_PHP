<?php
namespace App\Model\Entity;

use Cake\ORM\Entity;

class Payment extends Entity
{
    protected array $_accessible = [
        '*' => true,
        'id' => false,
    ];
}
