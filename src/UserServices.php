<?php

namespace src;

class UserServices
{

    private UserDao $userDao;
    public function __construct(UserDao $userDao)
    {
        $this->userDao = $userDao;
    }

    public function add(User $user){
        
        $this->userDao->create($user);

        return true;
    }
    
    public function listAll(){
        
        return $this->userDao->listAll();
    }

    public function update(User $user){
        $userBanco = $this->userDao->findById($user->id);
        $user->nome = $user->nome ?? $userBanco->nome;
        if($user->email == '' || $user->email != $userBanco->email){
            $user->email = $userBanco->email;
        }
        
        $this->userDao->update($user);
    }

    public function delete($id){
        return $this->delete($id);
    }

    public function get($id){
        return $this->userDao->findById($id);
    }

}
