<?php
session_start();


if($_SERVER['REQUEST_METHOD'] == 'GET'){
    if(isset($_GET['userId'])){
        $userId = $_GET['userId'];
        require_once 'connection.php';
        require_once 'src/Tweet.php';
        require_once 'src/User.php';
        $allUsersTweets = Tweet::loadAllUSersTweets($conn, $userId);
        $userNameToGet = User::loadUserById($conn, $userId);
        $userName = $userNameToGet->getName();
        $receiverId = $userNameToGet->getId();
        
    }
}


?>

<html>
    <head>
         <meta charset="utf-8">  
    </head>
    <body>
        <?php
         echo 'Tweety użytkownika ' . $userName . ' :' . ('<br>');
         ?>
        <a href="sendAMassage.php?receiverId=<?php echo $userId; ?>">Wyślij wiadomość do użytkownika <?php echo $userName; ?></a>
        <?php
        foreach($allUsersTweets as $tweet){
            $tweetId = $tweet->getId();
            $tweetToShow = $tweet->getTweet();
            $dateOfTweet = $tweet->getDate();
            require_once 'connection.php';
            require_once 'src/Comment.php';
            $NumebrOfCommentsToTheTweet = count(Comment::loadAllCommentsByTweetId($conn, $tweetId));
            
           
            
        ?>
        <ul>
            <li> <?php echo $tweetToShow . ('<br>') . ' Data ' . $dateOfTweet . ' Ilość komentarzy: ' . $NumebrOfCommentsToTheTweet . ('<br>'); ?> </li>
            
        </ul>
        <?php
        }
        
        $conn->close();
        $conn = null;
        ?>
    </body>
</html>