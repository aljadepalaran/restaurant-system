<?php
    class Order{

        // Database Connection
        private $conn;
        private $table = 'orders';

        // User Properties.
        public $orderid;
        public $userid;
        public $datetime;
        public $total;

        // Constructor
        public function __construct($db){

            $this->conn = $db;

        }

        // Returns all of the order.
        public function all(){

            $query = 'SELECT * FROM ' . "$this->table";

            $statement = $this->conn->prepare($query);

            $statement->execute();

            return $statement;

        }

        // Returns a single order based on the order ID.
        public function single(){

            $query = 'SELECT * FROM ' . "$this->table" . ' WHERE orderid = ? LIMIT 1'; // Query

            $statement = $this->conn->prepare($query);

            $statement->bindParam(1,$this->id); // Bind ID

            $statement->execute(); // Execute

            $row = $statement->fetch(PDO::FETCH_ASSOC);

            // Set Properties
            $this->orderid = $row['orderid'];
            $this->userid = $row['userid'];
            $this->datetime = $row['datetime'];
            $this->total = $row['total'];

            return $this;
        }

        // Function to create a new order.
        public function create(){
            //Query
            $query = 'INSERT INTO ' . $this->table . '
            SET
                userid = :userid,
                datetime = :datetime,
                total = :total';

            $statement = $this->conn->prepare($query);

            $this->userid = htmlspecialchars(strip_tags($this->userid));
            $this->datetime = htmlspecialchars(strip_tags($this->datetime));
            $this->total = htmlspecialchars(strip_tags($this->total));

            // Bind data
            $statement->bindParam(':userid', $this->userid);
            $statement->bindParam(':datetime', $this->datetime);
            $statement->bindParam(':total', $this->total);

            // Execute
            if($statement->execute()){

                return true;

            }

            printf("Error: %s.\n", $statement->error);// Print error

            return false;

        }
        
        // Function to update an order based on the product ID.
        public function update(){
            
            $query = 'UPDATE ' . $this->table . '
            SET
                userid = :userid,
                datetime = :datetime,
                total = :price
            WHERE orderid = :orderid';

            $statement = $this->conn->prepare($query);

            $this->orderid = htmlspecialchars(strip_tags($this->orderid));
            $this->userid = htmlspecialchars(strip_tags($this->userid));
            $this->datetime = htmlspecialchars(strip_tags($this->datetime));
            $this->price = htmlspecialchars(strip_tags($this->price));

            $statement->bindParam(':orderid', $this->orderid);
            $statement->bindParam(':userid', $this->userid);
            $statement->bindParam(':datetime', $this->datetime);
            $statement->bindParam(':price', $this->price);
            
            if($statement->execute()){

                return true;

            }
            
            printf("Error: %s.\n", $statement->error);

            return false;

        }

        // Function to delete an order based on the order ID.
        public function delete(){

            $query = 'DELETE FROM ' . $this->table . ' WHERE orderid = :orderid';

            $this->orderid = htmlspecialchars(strip_tags($this->orderid));

            $statement = $this->conn->prepare($query);

            $statement->bindParam(':orderid', $this->orderid);

            if($statement->execute()){

                return true;

            }
            
            printf("Error: %s.\n", $statement->error);

            return false;

        }

    }