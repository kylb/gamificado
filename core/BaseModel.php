<?php
namespace Core;
abstract class BaseModel{
    protected $pdo;
    protected $table;

    public function __construct(){
        if(func_num_args() > 0){
            $pdo = func_get_arg(0);
            $this->pdo = $pdo;
        } else{
            $this->pdo = DataBase::getDatabase();
        }
    }

    public function All(){

        $query = "SELECT * FROM {$this->table} ORDER BY 1 DESC";
        $stmt = $this->pdo->prepare($query);
        $stmt->execute();
        $result = $stmt->fetchAll();
        $stmt->closeCursor();
        return $result;
    }

    public function find($id){
        $query = "SELECT * FROM  {$this->table} WHERE id =:id";
        $stmt = $this->pdo->prepare($query);
        $stmt->bindValue(":id",$id);
        $stmt->execute();
        $result = $stmt->fetch();
        $stmt->closeCursor();
        return $result;
    }
    public function findAll($id){
        $query = "SELECT * FROM  {$this->table} WHERE id =:id";
        $stmt = $this->pdo->prepare($query);
        $stmt->bindValue(":id",$id);
        $stmt->execute();
        $result = $stmt->fetchAll();
        $stmt->closeCursor();
        return $result;
    }

        public function findEssays($id){
        $query = "SELECT * FROM  {$this->table} WHERE id_publication =id";
        $stmt = $this->pdo->prepare($query);
        $stmt->bindValue(":id",$id);
        $stmt->execute();
        $result = $stmt->fetchAll();
        $stmt->closeCursor();
        return $result;
    }


    public function create(array $data){
        $data = $this->prepareDataInsert($data);
        $query = "INSERT INTO `{$this->table}` ({$data[0]}) VALUES ({$data[1]})";
        $stmt = $this->pdo->prepare($query);
        for($i = 0; $i < count($data[2]); $i++){
            $stmt->bindValue("{$data[2][$i]}","{$data[3][$i]}");
        }
        $result = $stmt->execute();
        $stmt->closeCursor();
        return $result;
    }

    private function prepareDataInsert(array $data){
        $strKeys = "";
        $strBinds = "";
        $binds = [];
        $values = [];
        foreach ($data as $key => $value){
            $strKeys = "{$strKeys},{$key}";
            $strBinds = "{$strBinds},:{$key}";
            $binds [] = ":{$key}";
            $values [] = $value;
        }
        $strKeys = substr($strKeys, 1);
        $strBinds = substr($strBinds, 1);

        return [ $strKeys, $strBinds, $binds, $values ];
    }

    public function update(array $data, $id) {
        $data = $this->prepareDataUpdate($data);
        $query = "UPDATE `{$this->table}` SET {$data[0]}  WHERE id=:id";
        $stmt = $this->pdo->prepare($query);
        $stmt->bindValue(":id", $id);
        for($i = 0; $i < count($data[1]); $i++){
            $stmt->bindValue("{$data[1][$i]}", $data[2][$i]);
        }
        $result = $stmt->execute();
        $stmt->closeCursor();
        return $result;
    }

    public function delete($id){
        $query = "DELETE FROM `{$this->table}` WHERE id=:id";
        $stmt = $this->pdo->prepare($query);
        $stmt->bindValue(":id", $id);
        $result = $stmt->execute();
        $stmt->closeCursor();
        return $result;
    }

    private function prepareDataUpdate(array $data) {
        $strKeysBinds = "";
        $binds = [];
        $values = [];
        foreach ($data as $key => $value){
            $strKeysBinds = "{$strKeysBinds},{$key}=:{$key}";
            $binds[] = ":{$key}";
            $values[] = $value;
        }
        $strKeysBinds = substr($strKeysBinds, 1);
        return [$strKeysBinds, $binds, $values];
    }

    /*
     * kylb@github.com: 23/03/2018
     * Criação de métodos para CRUD com condições where
     */

    private function prepareWhere(array $conditions){
        $strWhere = "";
        $bindsWhere = [];
        $valuesWhere = [];
        foreach ($conditions as $key => $value){
            $strWhere = "{$strWhere} AND {$key}=:{$key}";
            $bindsWhere[] = ":{$key}";
            $valuesWhere[] = $value;
        }
        return  [$strWhere, $bindsWhere, $valuesWhere];
    }

    public function findWhere(array $conditions){
        $where = $this->prepareWhere($conditions);
        $query = "SELECT * FROM `{$this->table}` WHERE 1 = 1 {$where[0]}";
        $stmt = $this->pdo->prepare($query);
        for($i = 0; $i < count($where[1]); $i++){
            $stmt->bindValue("{$where[1][$i]}","{$where[2][$i]}");
        }
        $stmt->execute();
        $result = $stmt->fetch();
        $stmt->closeCursor();
        return $result;
    }

    public function findWhereAll(array $conditions){
        $where = $this->prepareWhere($conditions);
        $query = "SELECT * FROM `{$this->table}` WHERE 1 = 1 {$where[0]}";
        $stmt = $this->pdo->prepare($query);
        for($i = 0; $i < count($where[1]); $i++){
            $stmt->bindValue("{$where[1][$i]}","{$where[2][$i]}");
        }
        $stmt->execute();
        $result = $stmt->fetchAll();
        $stmt->closeCursor();
        return $result;
    }

    public function updateWhere (array $data, array $conditions){
        $data = $this->prepareDataUpdate($data);
        $where = $this->prepareWhere($conditions);
        $query = "UPDATE {$this->table} SET {$data[0]} WHERE 1 = 1 {$where[0]}";
        $stmt = $this->pdo->prepare($query);
        for($i = 0; $i < count($data[1]); $i++){
            $stmt->bindValue("{$data[1][$i]}","{$data[2][$i]}");
        }
        for($i = 0; $i < count($where[1]); $i++){
            $stmt->bindValue("{$where[1][$i]}","{$where[2][$i]}");
        }
        $result = $stmt->execute();
        $stmt->closeCursor();
        return $result;
    }

    public function deleteWhere (array $conditions){
        $where = $this->prepareWhere($conditions);
        $query = "DELETE FROM `{$this->table}` WHERE 1 = 1 {$where[0]}";
        $stmt = $this->pdo->prepare($query);
        for($i = 0; $i < count($where[1]); $i++){
            $stmt->bindValue("{$where[1][$i]}","{$where[2][$i]}");
        }
        $result = $stmt->execute();
        $stmt->closeCursor();
        return $result;
    }

    public function getPdo(){
        return $this->pdo;
    }

    public function getLastInsertId(){
        return $this->pdo->lastInsertId();
    }
}
