<?php

namespace src;

use PDO;

class UserDao {

    public $pdo;

    public function __construct($pdo)
    {
        $this->pdo = $pdo;
    }

    public function create(User $user){
        $id = md5(time().rand(9, 9999));
        $sql = $this->pdo->prepare("INSERT INTO users (id,nome,email) VALUES (:id,:nome,:email)");
        $sql->bindValue(':id',$id);
        $sql->bindValue(':nome',$user->nome);
        $sql->bindValue(':email',$user->email);
        $sql->execute();
    }

    public function listAll(){
        $sql = $this->pdo->query("SELECT * FROM users");
        $data = $sql->fetchAll(PDO::FETCH_ASSOC);
        return $data;
    }

    public function update(User $user){
        // var_dump($produto);
        $id = md5(time() * rand(9, 9999));
        $sql = $this->pdo->prepare("UPDATE users SET nome = :nome, email = :email WHERE id = :id");
        // $user->nome ? $sql->bindValue(':nome',$user->nome) : '';
        $sql->bindValue(':nome',$user->nome);
        $sql->bindValue(':email',$user->email);
        $sql->bindValue(':id',$user->id);
        $sql->execute();
        
        return true;
    }

    public function delete($id){
        $sql = $this->pdo->prepare("DELETE FROM users WHERE id = :id");
        $sql->bindValue(':id',$id);
        $sql->execute();
    }

    public function findById($id){
        $sql = $this->pdo->prepare("SELECT * FROM users WHERE id = :id");
        $sql->bindValue(':id',$id);
        $sql->execute();
        if($sql->rowCount() > 0){
            $data = $sql->fetch(PDO::FETCH_ASSOC);
            return $data;
        }   
        return false;
    }

    public function findByIdWithAdress($id){
        $sql = $this->pdo->prepare("SELECT users.*, enderecos.*
        FROM users 
        INNER JOIN enderecos ON enderecos.id = users.id_enderecos
        WHERE users.id = :id");
        $sql->bindValue(':id',$id);
        $sql->execute();
        if($sql->rowCount() > 0){
            $data = $sql->fetch(PDO::FETCH_ASSOC);
            return $data;
        }
        return false;
    }

}