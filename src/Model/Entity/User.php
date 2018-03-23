<?php
namespace App\Model\Entity;

use Cake\ORM\Entity;

class User extends Entity {
    private $username;

    public function __construct(array $properties = [], array $options = []) {
        parent::__construct($properties, $options);
        $this->username = 'jay.nguyen@jaydeveloper.com';
    }

    public function getUsername() {
        return $this->username;
    }
}
