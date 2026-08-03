<?php
namespace App\Model\Entity;

use Cake\ORM\Entity;

class ServiceCategory extends Entity
{
    protected array $_accessible = [
        '*' => true,
        'id' => false,
    ];
}
