<?php 

namespace App\Models;
use MF\Model\Model;

class Employee extends Model{
     
    private $id;
    private $nome;
    private $cargo;
    private $data_nascimento;
    private $data_admissao;
    
    public function __get($atributo){
        return $this->$atributo;
    }

    public function __set($atributo, $valor){
        $this->$atributo = $valor;
    }

    public function registerEmployee(){
        $query = "INSERT INTO tb_employees(nome, cargo, data_nascimento, data_admissao) 
        values (:nome, :cargo, :data_nascimento, :data_admissao)";       
        $stmt = $this->db->prepare($query);
        $stmt->bindvalue(":nome", $this->nome);
        $stmt->bindvalue(":cargo", $this->cargo);
        $stmt->bindvalue(":data_nascimento", $this->data_nascimento);
        $stmt->bindvalue(":data_admissao", $this->data_admissao);
        $stmt->execute();
    }

    public function updateEmployee(){
        $query = "UPDATE tb_employees SET nome = :nome, cargo = :cargo , data_nascimento = :data_nascimento , data_admissao = :data_admissao WHERE id = :id";       
        $stmt = $this->db->prepare($query);
        $stmt->bindvalue(":nome", $this->nome);
        $stmt->bindvalue(":cargo", $this->cargo);
        $stmt->bindvalue(":data_nascimento", $this->data_nascimento);
        $stmt->bindvalue(":data_admissao", $this->data_admissao);
        $stmt->bindvalue(":id", $this->id);
        $stmt->execute();
    }

    public function deleteEmployee(){
        $query = "DELETE FROM tb_employees where id = :id";     
        $stmt = $this->db->prepare($query);
        $stmt->bindvalue(":id", $this->id);
        $stmt->execute();
    }

    public function getAll(){
        $query = "SELECT * FROM tb_employees";      
        $stmt = $this->db->prepare($query);
        $stmt->execute();
        return $stmt->fetchAll();
    }

    public function getAllEmployeesFilter() {
        $query = "SELECT * FROM tb_employees WHERE data_admissao = :data_admissao";      
        $stmt = $this->db->prepare($query);
        $stmt->bindvalue(":data_admissao", $this->data_admissao);
        $stmt->execute();
        return $stmt->fetchAll();
    }
}

?>