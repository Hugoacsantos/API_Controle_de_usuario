<?php

namespace src;

use PDO;

class EnderecoDao
{   
    public PDO $pdo;
    public function __construct(PDO $pdo)
    {
        $this->pdo = $pdo;
    }

    public function add(Endereco $endereco){
        $sql = $this->pdo->prepare("INSERT into enderecos (id,id_user,numero,bairro,cidade,estado) VALUES (:id,:id_user,:numero,:bairro,:cidade,:estado)");
        $sql->bindValue(':id',$endereco->id);
        $sql->bindValue(':id_user',$endereco->id_user);
        $sql->bindValue(':numero',$endereco->numero);
        $sql->bindValue(':bairro',$endereco->bairro);
        $sql->bindValue(':cidade',$endereco->cidade);
        $sql->bindValue(':estado',$endereco->estado);
        $sql->execute();
    }

    public function remove($id){
        $sql = $this->pdo->prepare("DELETE * FROM enderecos WHERE id = :id");
        $sql->bindValue(':id',$id);
        $sql->execute();
    }

    public function list($id_user){
        $sql = $this->pdo->prepare("SELECT * FROM enderecos WHERE id_user = :id_user");
        $sql->bindValue(':id_user',$id_user);
        $sql->execute();
        $dados = $sql->fetch(PDO::FETCH_ASSOC);
        return $dados;
    }

}
