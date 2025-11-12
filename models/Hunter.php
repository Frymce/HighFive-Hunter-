<?php 
require_once __DIR__ .'/../config/connexionDB.php';

class Hunter {
    private $pdo;

    public function __construct($pdo){
        $this->pdo = $pdo;
    }
    public function create ( $describ, $price, $level){
        $sql = 'INSERT INTO hunters (describ, price, level) VALUES (?, ?, ?)';
        $stmt = $this->pdo->prepare($sql);
        
        return $stmt->execute([$describ, $price, $level]);
    }

    public function delete($id){
        $sql = 'DELETE FROM hunters WHERE id = ?';
        $stmt = $this->pdo->prepare($sql);
        return $stmt->execute([$id]);
    }

    public function findById($id){
        $sql = 'SELECT * FROM hunters WHERE id = ?';
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute([$id]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function findByLevel($level){
        $sql = 'SELECT * FROM hunters WHERE level = ?';
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute([$level]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function sorted($sort){
        $sql = 'SELECT * FROM hunters ORDER BY $sort';
        $stmt = $this->pdo->prepare($sql);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function update($id, $describ, $price, $level){
        $sql = 'UPDATE hunters SET describ = ?, price = ?, level = ? WHERE id = ?';
        $stmt = $this->pdo->prepare($sql);
        return $stmt->execute([$describ, $price, $level, $id]);
    }

    public function all(){
        return $this->pdo->query('SELECT * FROM hunters')->fetchAll(PDO::FETCH_ASSOC);
    }
}

?>