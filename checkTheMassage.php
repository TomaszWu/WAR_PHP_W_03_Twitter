<?php
session_start();
var_dump($_GET);



if ($_SERVER['REQUEST_METHOD'] == 'GET') {
    require_once 'src/Massage.php';
    require_once 'connection.php';
    $receiverId = $_GET['userId'];
    $massages = Massage::loadAllReceivedMassages($conn, $receiverId);
     if($result == true && $result->num_rows > 0){
            foreach($result as $row){
                $massageStatus = $row['status'];
                if($row['status'] == 0){
                    ?> <a href="#?massageId=<?php echo $row['id']; ?>"><?php echo  'Nadawca: ' . $row['sender'] . ' Data wysłania wiadomości: ' . $row['date'] . ' ' . substr($row['massage'], 0, 30) . ' NOWA WIADMOŚĆ!' . ('<br>'); ?></a> <?php
                        $query = "UPDATE Massages SET Status = 1 WHERE id = '$massageStatus'";
                        
                    } else {
                    ?> <a href="#?massageId=<?php echo $row['id']; ?>"><?php echo  $row['massage'] . ('<br>'); ?></a> <?php
                    }
            }
        }
    
    
}



?>




<html>
    <head>
        <meta charset="utf-8"> 
    </head>
    <body>
        
    </body>
</html>