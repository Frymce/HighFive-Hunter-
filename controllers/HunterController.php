<?php
require_once __DIR__.'/../models/Hunter.php';

class HunterController {
    private $hunterModel;

    public function __construct($pdo){
        $this->hunterModel = new Hunter($pdo);
    }
    public function handleRequest(){
        if($_SERVER["REQUEST_METHOD"] === 'POST' && isset($_POST['create'])){
            $describ = $_POST['describ'];
            $price = (float)$_POST['price'];
            $level = $_POST['level'] ; 

            $this->hunterModel->create($describ, $price, $level);
            // $this->flashMessage("Hunter créer avec sucès", 'green'); 
            
        }
        
        if(isset($_GET['delete'])){
            $id = $_GET['delete'];
            $this->hunterModel->delete($id);
            // $this->flashMessage("Hunter suprimer avec sucès", 'green'); 
        }

        // Gérer le filtrage par niveau
        if (isset($_GET['search']) && !empty($_GET['search'])) {
            $level = $_GET['search'];
            return $this->hunterModel->findByLevel($level);
        } else {
            // Si aucun filtre, retourner tous les chasseurs
            return $this->hunterModel->all();
        }

        // Gérer le tri des données
        if (isset($_GET['sort'])) {
            $sort = $_GET['sort'];
            $hunters = $this->hunterModel->sorted($sort);
            return $hunters->sort(function($a, $b) {
                // return ($sort === 'created_at' ? $a['created_at'] - $b['created_at'] : $b['created_at'] - $a['created_at']);
            });
        } else {
            return $this->hunterModel->all();
        }
    }

    public function getHunterById($id) {
        return $this->hunterModel->findById($id);
    }

}
?>