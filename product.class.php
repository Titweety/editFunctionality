<?php
    require_once "database.class.php";

    class Product{
        public $name;
        public $category;
        public $price;
        public $availability;

        protected $db;

        function __construct(){
            $this->db = new Database;
        }

        function add(){
            $sql = "INSERT INTO product(name, category, price, availability) VALUES (:name, :category, :price, :availability)";

            $query = $this->db->connect()->prepare($sql);

            $query->bindParam(":name", $this->name);
            $query->bindParam(":category", $this->category);
            $query->bindParam(":price", $this->price);
            $query->bindParam(":availability", $this->availability);

            if ($query->execute()){
                return true;
            } else{
                return false;
            }
        }

        function showAll(){
            $sql = "SELECT * FROM product ORDER BY name ASC";

            $query = $this->db->connect()->prepare($sql);
            $data = null;

            if ($query->execute()){
                $data = $query->fetchAll();
            }
            return $data;
        }
        function edit(){
            $sql = "UPDATE product SET name = :name, category = :category, price = :price, availability = :availability WHERE id = :id;";

            $query = $this->db->connect()->prepare($sql);

            $query->bindParam(':name', $this->name);
            $query->bindParam(':category', $this->category);
            $query->bindParam(':price', $this->price);
            $query->bindParam(':availability', $this->availability);
            $query->bindParam(':id', $this->id);

            return $query->execute();
        }
        function fetchRecord($recordID){
            $sql = "SELECT * FROM product WHERE id = :recordID;";

            $sql = $this->db->connect()->prepare($sql);

            $query->bindParam(':recordID', $recordID);

            $data = null;

            if ($query->execute()){
                $data = $query->fetch();
            }
            return $data;
        }
    }
?>