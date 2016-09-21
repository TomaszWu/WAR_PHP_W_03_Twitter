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

    static public function loadAllReceivedMassages(mysqli $connection, $userId) {
        $query = "SELECT Massages.id, massage, status, date, Users.name AS sender, User2.name AS eeceiver
                 FROM Massages
                 JOIN Users ON Users.id = Massages.senderId
                JOIN Users AS User2 ON User2.id = Massages.receiverId
                WHERE Users.id = '".$connection->real_escape_string($userId)."'";
        $result = $connection->query($query);
        if($result == true && $result->num_rows > 0){
            foreach($result as $row){
                $massageStatus = $row['status'];
                if($row['status'] == 0){
                    ?> <a href="#?massageId=<?php echo $row['id']; ?>"><?php echo  'Nadawca: ' . $row['sender'] . ' Data wysłania wiadomości: ' . $row['date'] . ' ' . substr($row['massage'], 0, 30) . ' NOWA WIADMOŚĆ!' . ('<br>'); ?></a> <?php
                    } else {
                    ?> <a href="#?massageId=<?php echo $row['id']; ?>"><?php echo  $row['massage'] . ('<br>'); ?></a> <?php
                    }
            }
        }
    }   
    
    static public function changeTheStatusOfAMassage(mysqli $connection, $massageId){
        $query = "UPDATE Massages SET status = 1 WHERE id = '$massageId'";
    }
    
    
}

//SELECT massage, senderId AS Sender, receiverId AS Receiver, Users.name as Sender, User2.name as Receiver
//FROM Massages
//JOIN Users ON Users.id = Massages.senderId
//JOIN Users AS User2 ON User2.id = Massages.receiverId
//LIMIT 0 , 30
//
//SELECT massage, Users.name AS Sender, User2.name AS Receiver
//FROM Massages
//JOIN Users ON Users.id = Massages.senderId
//JOIN Users AS User2 ON User2.id = Massages.receiverId
//WHERE Users.id =71
//LIMIT 0 , 30
        
        