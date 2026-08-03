<?php
namespace App\Model\Entity;

use Cake\ORM\Entity;

class Availability extends Entity
{
    protected array $_accessible = [
        '*' => true,
        'id' => false,
    ];
}
