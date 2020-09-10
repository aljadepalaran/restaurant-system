<?php
    class Product{

        // Database Connection
        private $conn;
        private $table = 'products';

        // User Properties.
        public $productid;
        public $p_name;
        public $p_details;
        public $price;

        // Constructor
        public function __construct($db){

            $this->conn = $db;

        }

        // Returns all of the prodcuts.
        public function all(){

            $query = 'SELECT * FROM ' . "$this->table";

            $statement = $this->conn->prepare($query);

            $statement->execute();

            return $statement;

        }

        // Returns a single product based on the product ID.
        public function single(){

            $query = 'SELECT * FROM ' . "$this->table" . ' WHERE productid = ? LIMIT 1'; // Query

            $statement = $this->conn->prepare($query);

            $statement->bindParam(1,$this->id); // Bind ID

            $statement->execute(); // Execute

            $row = $statement->fetch(PDO::FETCH_ASSOC);

            // Set Properties
            $this->productid = $row['productid'];
            $this->p_name = $row['p_name'];
            $this->p_details = $row['p_details'];
            $this->price = $row['price'];

            return $this;
        }

        // Function to create a new product.
        public function create(){
            //Query
            $query = 'INSERT INTO ' . $this->table . '
            SET
                p_name = :p_name,
                p_details = :p_details,
                price = :price';

            $statement = $this->conn->prepare($query);

            $this->p_name = htmlspecialchars(strip_tags($this->p_name));
            $this->p_details = htmlspecialchars(strip_tags($this->p_details));
            $this->price = htmlspecialchars(strip_tags($this->price));

            // Bind data
            $statement->bindParam(':p_name', $this->p_name);
            $statement->bindParam(':p_details', $this->p_details);
            $statement->bindParam(':price', $this->price);

            // Execute
            if($statement->execute()){

                return true;

            }

            printf("Error: %s.\n", $statement->error);// Print error

            return false;

        }
        
        // Function to update a product based on the product ID.
        public function update(){
            
            $query = 'UPDATE ' . $this->table . '
            SET
                p_name = :p_name,
                p_details = :p_details,
                price = :price
            WHERE productid = :productid';

            $statement = $this->conn->prepare($query);

            $this->productid = htmlspecialchars(strip_tags($this->productid));
            $this->p_name = htmlspecialchars(strip_tags($this->p_name));
            $this->p_details = htmlspecialchars(strip_tags($this->p_details));
            $this->price = htmlspecialchars(strip_tags($this->price));

            $statement->bindParam(':productid', $this->productid);
            $statement->bindParam(':p_name', $this->p_name);
            $statement->bindParam(':p_details', $this->p_details);
            $statement->bindParam(':price', $this->price);
            
            if($statement->execute()){

                return true;

            }
            
            printf("Error: %s.\n", $statement->error);

            return false;

        }

        // Function to delete a product based on the product ID.
        public function delete(){

            $query = 'DELETE FROM ' . $this->table . ' WHERE productid = :productid';

            $this->productid = htmlspecialchars(strip_tags($this->productid));

            $statement = $this->conn->prepare($query);

            $statement->bindParam(':productid', $this->productid);

            if($statement->execute()){

                return true;

            }
            
            printf("Error: %s.\n", $statement->error);

            return false;

        }

    }