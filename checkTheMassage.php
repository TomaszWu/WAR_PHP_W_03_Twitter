<?php



if ($_SERVER['REQUEST_METHOD'] == 'GET') {
     if (isset($_GET['massageId'])) {
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
        <?php
        if ($_SERVER['REQUEST_METHOD'] == 'GET') {
    if (isset($_GET['userId'])) {
        require_once 'src/Massage.php';
        require_once 'connection.php';
        $receiverId = $_GET['userId'];
        $sentMassages = Massage::loadAllSentMassagesByUserId($conn, $receiverId);
        ?> <label>Wiadomości wysłane:</label> <?php
        if ($sentMassages == true && $sentMassages->num_rows > 0) {
            foreach ($sentMassages as $row) {
               ?> <ol> <?php
                $massageStatus = $row['status'];
                if ($row['status'] == 0) {
                    ?> <li><a href="checkTheMassage.php?massageId=<?php echo $row['id']; ?>"><?php echo ' Data wysłania wiadomości: ' . substr($row['date'], 0 , 10) . ' Odbiorca: ' . $row['receiver'] . ' Treść wiadomości: ' . substr($row['massage'], 0, 30) . '...' . 'NOWA WIADMOŚĆ!' . ('<br>'); ?></a></li> <?php
                } else {
                    ?> <li><a href="checkTheMassage.php?massageId=<?php echo $row['id']; ?>"><?php echo ' Data wysłania wiadomości: ' . substr($row['date'], 0 , 10) . ' Odbiorca: ' . $row['receiver'] . ' Treść wiadomości: ' . substr($row['massage'], 0, 30) . '...' . ('<br>'); ?></a> </li><?php
                }
                ?> </ol> <?php
            }
        }
        $receivedMassages = Massage::loadAllReceivedMassagesByUserId($conn, $receiverId);
        ?> <label>Wiadomości odebrane:</label> <?php
        if ($receivedMassages == true && $receivedMassages->num_rows > 0) {
            foreach ($receivedMassages as $row) {
                ?> <ol> <?php
                ?> <li><a href="checkTheMassage.php?massageId=<?php echo $row['id']; ?>"><?php echo 'Nadawca: ' . $row['sender'] . ' Data wysłania wiadomości: ' . substr($row['date'], 0 , 10) . ' Treść wiadomości: ' . substr($row['massage'], 0, 30) . '...' . ('<br>'); ?></a></li> <?php
                ?> </ol> <?php  
            }
        }
    }
        }
        ?>
    </body>
</html>