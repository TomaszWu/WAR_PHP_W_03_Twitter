<?php

//CREATE TABLE Massages(
//id INT( 6 ) UNSIGNED AUTO_INCREMENT PRIMARY KEY ,
//senderId INT,
//receiverId INT,
//message VARCHAR( 500 ) NOT NULL,
//status INT,
//date TIMESTAMP;
//);



class Massage {

    private $id;
    private $senderId;
    private $receiverId;
    private $massage;
    private $status;

    public function __construct() {
        $this->id = -1;
        $this->senderId = '';
        $this->receiverId = '';
        $this->massage = '';
        $this->status = '';
    }
    
    public function __destruct() {
    }

    public function getId() {
        return $this->id;
    }

    public function setSenderId($senderId) {
        $this->senderId = $senderId;
    }

    function getSenderId() {
        return $this->senderId;
    }

    function getReceiverId() {
        return $this->receiverId;
    }

    function getMassage() {
        return $this->massage;
    }

    function setReceiverId($receiverId) {
        $this->receiverId = $receiverId;
    }

    function setMassage($massage) {
        $this->massage = $massage;
    }

    function getStatus() {
        return $this->status;
    }

    function setStatus($status) {
        $this->status = $status;
    }

    public function addAMassageToTheDB(mysqli $connection) {
        if ($this->id == -1) {
            $query = "INSERT INTO Massages (senderId, receiverId, massage, status, date)
                    VALUES( '$this->senderId', '$this->receiverId', '$this->massage', $this->status, NOW()
                    )";
            if ($connection->query($query)) {
                $this->id = $connection->insert_id;
                return true;
            } else {
                return false;
            }
        }
    }

    static public function loadAllSentMassagesByUserId(mysqli $connection, $userId) {
        $query = "SELECT Massages.id, massage, status, date, Users.name AS sender, User2.name AS receiver
                 FROM Massages
                 JOIN Users ON Users.id = Massages.senderId
                JOIN Users AS User2 ON User2.id = Massages.receiverId
                WHERE Users.id = '" . $connection->real_escape_string($userId) . "'
                ORDER BY date DESC";
        $result = $connection->query($query);
        return $result;
//       
    }

    static public function loadAllReceivedMassagesByUserId(mysqli $connection, $userId) {
        $query = "SELECT Massages.id, massage, status, date, Users.name AS receiver, User2.name AS sender
                 FROM Massages
                 JOIN Users ON Users.id = Massages.receiverId
                JOIN Users AS User2 ON User2.id = Massages.senderId
                WHERE Users.id = '" . $connection->real_escape_string($userId) . "'
                ORDER BY date DESC";
        $result = $connection->query($query);
        return $result;
        
    }

    static public function changeTheStatusOfAMassage(mysqli $connection, $massageId) {
        $query = "UPDATE Massages SET `date` = `date`, status = 1 WHERE id = '$massageId'";
        if ($connection->query($query)) {
            return true;
        } else {
            return false;
        }
    }

    static public function loadAMassageByMassageId(mysqli $connection, $massageId) {
        $query = "SELECT massage FROM Massages WHERE id = '$massageId'";
        $result = $connection->query($query);
        if ($result == true && $result->num_rows == 1) {
            $row = $result->fetch_assoc();
            $massageToShow = new Massage();
            $massageToShow->massage = $row['massage'];
            return $massageToShow;
        }
        return null;
    }

}

        