<?php
session_start();
var_dump($_GET);



if ($_SERVER['REQUEST_METHOD'] == 'GET') {
    if (isset($_GET['userId'])) {
        require_once 'src/Massage.php';
        require_once 'connection.php';
        $receiverId = $_GET['userId'];
        $sentMassages = Massage::loadAllSentMassagesByUserId($conn, $receiverId);

        if ($sentMassages == true && $sentMassages->num_rows > 0) {
            foreach ($sentMassages as $row) {
                $massageStatus = $row['status'];
                if ($row['status'] == 0) {
                    ?> <a href="checkTheMassage.php?massageId=<?php echo $row['id']; ?>"><?php echo ' Data wysłania wiadomości: ' . $row['date'] . ' Odbiorca: ' . $row['receiver'] . '  ' . substr($row['massage'], 0, 30) . ' NOWA WIADMOŚĆ!' . ('<br>'); ?></a> <?php
                } else {
                    ?> <a href="checkTheMassage.php?massageId=<?php echo $row['id']; ?>"><?php echo ' Data wysłania wiadomości: ' . $row['date'] . ' ' . substr($row['massage'], 0, 30) . ('<br>'); ?></a> <?php
                }
            }
        }
        $receivedMassages = Massage::loadAllReceivedMassagesByUserId($conn, $receiverId);
        if ($receivedMassages == true && $receivedMassages->num_rows > 0) {
            foreach ($receivedMassages as $row) {
                    ?> <a href="checkTheMassage.php?massageId=<?php echo $row['id']; ?>"><?php echo 'Nadawca: ' . $row['sender'] . ' Data wysłania wiadomości: ' . $row['date'] . ' Odbiorca: ' . $row['receiver'] . substr($row['massage'], 0, 30) . ('<br>'); ?></a> <?php
            }
        }
    } elseif (isset($_GET['massageId'])) {
        $massageId = $_GET['massageId'];
        require_once 'src/Massage.php';
        require_once 'connection.php';
        $changeTheStatus = Massage::changeTheStatusOfAMassage($conn, $massageId);
        $loadedSentMassage = Massage::loadAMassageByMassageId($conn, $massageId);
        $sentMassageToShow = $loadedSentMassage->getMassage();
        echo $sentMassageToShow;
    }
}
?>




<html>
    <head>
        <meta charset="utf-8"> 
    </head>
    <body>
        <label>Wysłane wiadomości:</label>
        <ol>
            
        </ol>
        
        
        
    </body>
</html>