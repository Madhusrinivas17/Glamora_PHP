<?php
namespace App\Model\Entity;

use Cake\ORM\Entity;

class Service extends Entity
{
    protected array $_accessible = [
        '*' => true,
        'id' => false,
    ];
}
