<?php
declare(strict_types=1);

namespace Entities;
class UserEntity {
    private $name;
    private $api_token = '';

    public function __construct(string $name) {
        $this->name = $name;
       
    }

    public function getName() {
        return $this->name;
    }

    public function getApiToken() {
        return $this->api_token;
    }
    
    public function setApiToken(string  $api_token) {
        $this->api_token  =$api_token;
    }

}