<?php

namespace src;

class User {

    
    public function __construct(
        public $id,
        public $nome,
        public $email,
    ){}


}