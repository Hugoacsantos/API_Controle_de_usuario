<?php

namespace src;

class User {

    public function __construct(
        public $id,
        public $nome,
        public $email,
        public ?Endereco $endereco = null,
    ){}
    
    public function adicionarEndereco(Endereco $endereco){
        $this->endereco = $endereco;
    }

}