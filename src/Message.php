<?php

/*

CREATE TABLE Messages(
id INT( 6 ) UNSIGNED AUTO_INCREMENT PRIMARY KEY ,
userId INT,
message VARCHAR( 140 ) NOT NULL ,
date TIMESTAMP;
);
)
 */



class Message {
    private $id;
    private $userId;
    private $message;
    
 public function __construct() {
     $this->id = -1;
     $this->userId = '';
     $this->message = '';
 }   
    
 public function getId() {
     return $this-> id;
 }
    
 public function setUserId($id){
     $this->userId = $id;
 }
 
 public function getUserId(){
     return $this->userId;
 }
 
 public function setMessage($message) {
     if(strlen(trim($message)) > 0 && strlen(trim($message)) < 141){
         $this->message = $message;
     }
 }
 
 public function saveTheMessageToTheDB (mysqli $connection){
     if($this->id == -1){
         $query = "INSERT INTO Messages (userId, message, date) 
                   VALUES ('$this->userId', '$this->message', NOW())
                 ";
         if($connection->query($query)){
             $this->id = $connection->insert_id;
             return true;
         } else {
             return false;
         }
            
     }
     
     
 }
    
}