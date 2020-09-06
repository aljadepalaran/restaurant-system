<?php
    class User{

        // Database Connection
        private $conn;
        private $table = 'users';

        // User Properties.
        public $userid;
        public $username;
        public $firstname;
        public $surname;
        public $email;
        public $created;
        public $hash;

        // Constructor
        public function __construct($db){

            $this->conn = $db;

        }

        // Returns all of the users.
        public function all(){

            $query = 'SELECT * FROM ' . "$this->table";

            $statement = $this->conn->prepare($query);

            $statement->execute();

            return $statement;

        }

        // Returns a single user based on the user ID.
        public function single(){

            $query = 'SELECT * FROM ' . "$this->table" . ' WHERE userid = ? LIMIT 1'; // Query

            $statement = $this->conn->prepare($query);

            $statement->bindParam(1,$this->id); // Bind ID

            $statement->execute(); // Execute

            $row = $statement->fetch(PDO::FETCH_ASSOC);

            // Set Properties
            $this->userid = $row['userid'];
            $this->username = $row['username'];
            $this->firstname = $row['firstname'];
            $this->surname = $row['surname'];
            $this->email = $row['email'];
            $this->created = $row['created'];
            $this->hash = $row['hash'];

            return $this;
        }

        // Function to create a new user.
        public function create(){
            //Query
            $query = 'INSERT INTO ' . $this->table . '
            SET
                username = :username,
                firstname = :firstname,
                surname = :surname,
                email = :email,
                created = :created,
                hash = :hash';

            $statement = $this->conn->prepare($query);

            $this->username = htmlspecialchars(strip_tags($this->username));
            $this->username = htmlspecialchars(strip_tags($this->firstname));
            $this->surname = htmlspecialchars(strip_tags($this->surname));
            $this->email = htmlspecialchars(strip_tags($this->email));
            $this->created = htmlspecialchars(strip_tags($this->created));
            $this->hash = htmlspecialchars(strip_tags($this->hash));

            // Bind data
            $statement->bindParam(':username', $this->username);
            $statement->bindParam(':firstname', $this->firstname);
            $statement->bindParam(':surname', $this->surname);
            $statement->bindParam(':email', $this->email);
            $statement->bindParam(':created', $this->created);
            $statement->bindParam(':hash', $this->hash);

            // Execute
            if($statement->execute()){

                return true;

            }

            printf("Error: %s.\n", $statement->error);// Print error

            return false;

        }
        
        // Function to update a user based on the user ID.
        public function update(){
            
            $query = 'UPDATE ' . $this->table . '
            SET
                username = :username,
                firstname = :firstname,
                surname = :surname,
                email = :email,
                created = :created,
                hash = :hash
            WHERE userid = :userid';

            $statement = $this->conn->prepare($query);

            $this->userid = htmlspecialchars(strip_tags($this->userid));
            $this->username = htmlspecialchars(strip_tags($this->username));
            $this->firstname = htmlspecialchars(strip_tags($this->firstname));
            $this->surname = htmlspecialchars(strip_tags($this->surname));
            $this->email = htmlspecialchars(strip_tags($this->email));
            $this->created = htmlspecialchars(strip_tags($this->created));
            $this->hash = htmlspecialchars(strip_tags($this->hash));

            $statement->bindParam(':userid', $this->userid);
            $statement->bindParam(':username', $this->username);
            $statement->bindParam(':firstname', $this->firstname);
            $statement->bindParam(':surname', $this->surname);
            $statement->bindParam(':email', $this->email);
            $statement->bindParam(':created', $this->created);
            $statement->bindParam(':hash', $this->hash);
            
            if($statement->execute()){

                return true;

            }
            
            printf("Error: %s.\n", $statement->error);

            return false;

        }

        // Function to delete a user based on the user ID.
        public function delete(){

            $query = 'DELETE FROM ' . $this->table . ' WHERE userid = :userid';

            $this->userid = htmlspecialchars(strip_tags($this->userid));

            $statement = $this->conn->prepare($query);

            $statement->bindParam(':userid', $this->userid);

            if($statement->execute()){

                return true;

            }
            
            printf("Error: %s.\n", $statement->error);

            return false;

        }

    }