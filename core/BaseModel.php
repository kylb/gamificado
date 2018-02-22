<?php
namespace Core;
use PDO;

abstract class BaseModel{
    private $pdo;
    protected $table;

    public function __construct(PDO $pdo){
        $this->pdo = $pdo;
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

    public function create(array $data){
        $data = $this->prepareDataInsert($data);
        $query = "INSERT INTO {$this->table} ({$data[0]}) VALUES ({$data[1]})";
        $stmt = $this->pdo->prepare($query);
        for($i = 0; $i < count($data[2]); $i++){
            $stmt->bindValue("{$data[2][$i]}","{$data[3][$i]}");
        }
        $result = $stmt->execute();
        $stmt->closeCursor();
        return $result;
    }

    public function update (array $data, array $conditions){
        $data = $this->prepareDataUpdate($data,$conditions);
        $query = "UPDATE {$this->table} SET {$data[0][0]} WHERE 1 = 1 {$data[1][0]}";
        $stmt = $this->pdo->prepare($query);
        for($i = 0; $i < count($data[0][1]); $i++){
            $stmt->bindValue("{$data[0][1][$i]}","{$data[0][2][$i]}");
        }
        for($i = 0; $i < count($data[1][1]); $i++){
            $stmt->bindValue("{$data[1][1][$i]}","{$data[1][2][$i]}");
        }
        $result = $stmt->execute();
        $stmt->closeCursor();
        return $result;
    }

    /*
     * kylb@github.com: 10/02/2018
     * metodo refatorado para atender a mais de uma clausula where
     */
    public function delete (array $conditions){
        $data = $this->prepareDataDelete($conditions);
        $query = "DELETE FROM {$this->table} WHERE 1 = 1 {$data[1][0]}";
        $stmt = $this->pdo->prepare($query);
        for($i = 0; $i < count($data[1][1]); $i++){
            $stmt->bindValue("{$data[1][1][$i]}","{$data[1][2][$i]}");
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

    /*
     * kylb@github.com: 10/02/2018
     * metodo refatorado para atender a mais de uma clausula where
     */
    private function prepareDataUpdate(array $data, array $conditions){
        $strKeysBinds = "";
        $strWhere = "";
        $binds = [];
        $values = [];
        $bindsWhere = [];
        $valuesWhere = [];
        foreach ($data as $key => $value){
            $strKeysBinds = "{$strKeysBinds}, {$key}=:{$key}";
            $binds[] = ":{$key}";
            $values[] = $value;
        }
        foreach ($conditions as $key => $value){
            $strWhere = "{$strWhere} AND {$key}=:{$key}";
            $bindsWhere[] = ":{$key}";
            $valuesWhere[] = $value;
        }
        $strKeysBinds = substr($strKeysBinds, 1);
        return  [0 => [$strKeysBinds, $binds, $values],
                 1 => [$strWhere, $bindsWhere, $valuesWhere]];
    }

    /*
     * kylb@github.com: 10/02/2018
     * metodo criado para atender a mais de uma clausula where
     */
    private function prepareDataDelete(array $conditions){
        $strWhere = "";
        $bindsWhere = [];
        $valuesWhere = [];
        foreach ($conditions as $key => $value){
            $strWhere = "{$strWhere} AND {$key}=:{$key}";
            $bindsWhere[] = ":{$key}";
            $valuesWhere[] = $value;
        }
        return  [0 => ['', [], []],
                 1 => [$strWhere, $bindsWhere, $valuesWhere]];
    }
}