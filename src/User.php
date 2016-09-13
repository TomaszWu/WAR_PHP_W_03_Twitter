<?php

class User {
    private $id;
    private $name;
    private $email;
    private $hashedPassword;
    
    
    public function __construct() {
        $this->id = -1;
        $this->name = '';
        $this->email = '';
        $this->hashedPassword = '';
    }
    
    public function getId() {
        return $this->id;
    }
    
    public function setName($name) {
        if(is_string($name) && strlen($name) > 0) {
            $this->name = trim($name);
        }
        return $this;
    }
    
    public function getName() {
        return $this->name;
    }
    
    public function setEmail($email) {
        if(is_string($email) && strlen(trim($email)) > 5){
            $this->email = trim($email);
        }
        return $this;
    }
    
     public function getEmail() {
        return $this->email;
    }
    
    public function setPassword($password) {
        if(is_string($password) && strlen(trim($password)) > 5){
            $this->hashedPassword = password_hash($password, PASSWORD_DEFAULT);
        }
        return $this; // gdyby toś chciał wywołać kilka seterów ?? oO
    }
    
    public function getPassword() {
        return $this->hassedPassword;
    }
    
    public function saveToDB(mysqli $connection) {
        if($this->id == -1){
            $query = "INSERT INTO Users (email, name, hashed_password) 
                    VALUES ('$this->email', '$this->name', '$this->hashedPassword') ";
            if($connection->query($query)){
                $this->id = $connection->insert_id; // ostatni dodoany!!
                return true;
            } else {
                return false;
            }
        } else {
            // modyfikacja obiektu, na wypadek, gdyby istniał już dany email
            $query = "UPDATE Users SET 
                    name = '$this->name', email = '$this->email', hashed_password = '$this->hashedPassword'
                    WHERE id = $this->id";
            
            if($connection->query($query)){
                return true;
            } else {
                return false;
            }
        }
    }
    
    
    static public function loadUserById(mysqli $connection, $id){
        $query = "SELECT * FROM Users WHERE id = ".$connection->real_escape_string($id);
    
    $res = $connection->query($query);
    
        if($res && $res->num_rows != 0){
            $row = $res->fetch_assoc();
            $user = new User();
            $user->id = $row['id'];
            $user->setName($row['name']);
            $user->setEmail($row['email']);
            $user->hashedPassword = $row['hashed_password'];
            return $user;
        } 
            return null;
    }
    
    
    static public function loadAllUsers(mysqli $connection){
        $query = "SELECT * FROM Users";
        
        $users = [];
        $res = $connection->query($query);
        if($res){
            foreach($res as $row) {
                $user = new User();
                $user->id = $row['id'];
                $user->setName($row['name']);
                $user->setEmail($row['email']);
                $user->hashedPassword = $row['hashed_password'];
            
                $users[] = $user;
            }    
        }
        return $users;
    }
    
    
    public function delete(mysqli $connection){
        if($this->id != -1){
            $query = "DELETE FROM Users WHERE id = $this->id";
            if($connection->query($query)){
                $this->id = -1;
                return true;
            } else {
                return false;
            }
        }
        return true;
    }
    
    
    // pobieranie użytkownika po mail i sprawdzająca hasło
    
    
    static public function loadByEmail(mysqli $connection, $email){
        $query = "SELECT * FROM Users WHERE email = '".$connection->real_escape_string($email)."'";
        
        $res = $connection->query($query);
        if($res && $res->num_rows == 1){
            $row = $res->fetch_assoc();
            $user = new User();
            $user->id = $row['id'];
            $user->setName($row['name']);
            $user->setEmail($row['email']);
            $user->hashedPassword = $row['hashed_password'];
            
            return $user;
        }
        return null;
    }
    
    
    static public function login(mysqli $connection, $email, $password) {
        $user = self::loadByEmail($connection, $email);
        if($user && password_verify($password, $user->hashedPassword)){
            return $user;
        } else {
            return false;
        }
    }
    
    
    static public function showDetailsAboutUser(mysqli $connection, $userId) {
        $query = "SELECT * FROM Users WHERE id = '".$connection->real_escape_string($userId)."'";
        
    }
    
    
    static public function checkTheAuthorByTweeterId(mysqli $connection, $tweetId) {
        $query = "SELECT Users.name, Users.id FROM Users
                JOIN Tweets ON Tweets.userId = Users.id
                WHERE Tweets.id = '".$connection->real_escape_string($tweetId)."'";
        
        $res = $connection->query($query);
        if($res == true && $res->num_rows == 1){
            $row = $res->fetch_assoc();
            $foundUser = new User;
            $foundUser->name = $row['name'];
            $foundUser->id = $row['id'];
            return $foundUser;
        }
        
        return false;
                
    }
    static public function checkTheAuthorByCommentId(mysqli $connection, $commentId) {
         $query = "SELECT Users.name, Users.id FROM Users
                JOIN Comments ON Comments.userId = Users.id
                WHERE Comments.id = '".$connection->real_escape_string($commentId)."'";
        
        $res = $connection->query($query);
        if($res == true && $res->num_rows == 1){
            $row = $res->fetch_assoc();
            $foundUser = new User;
            $foundUser->name = $row['name'];
            $foundUser->id = $row['id'];
            return $foundUser;
        }
        return false;
    }
    
    
    
}







