<?php
namespace App\Model\Entity;

use Cake\ORM\Entity;

class Notification extends Entity
{
    protected array $_accessible = [
        '*' => true,
        'id' => false,
    ];
}
