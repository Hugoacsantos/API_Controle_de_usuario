<?php

namespace src;

use Exception;
use src\UserDao;

class EnderecoServices
{
    public $enderecoDao;
    public $userDao;
    public function __construct(EnderecoDao $enderecoDao,UserDao $userDao)
    {
        $this->enderecoDao = $enderecoDao;
        $this->userDao = $userDao;
    }

    public function create(Endereco $endereco){
        if($this->userDao->findById($endereco->id_user) === false){
            return throw new Exception("Usuario nao existe");
        }
        $id = md5(time().rand(0,999));
        $endereco->id = $id;

        $this->enderecoDao->add($endereco);
    }
    
    public function remove($id_user, Endereco $endereco){
        $user = $this->userDao->findById($id_user);
        if($user->id == $endereco->id_user){
            $this->enderecoDao->remove($endereco->id);
        }
    }

    public function find($id_user){
       return $this->enderecoDao->list($id_user);
    }

}
