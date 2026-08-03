<?php
namespace App\Model\Entity;

use Cake\ORM\Entity;

class Review extends Entity
{
    protected array $_accessible = [
        '*' => true,
        'id' => false,
    ];
}
