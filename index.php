<?php

session_start();
if(!isset($_SESSION['userId'])){
    header('Location: login.php');
}


require_once 'src/User.php';
require_once 'src/Tweet.php';
require_once 'connection.php';




/*
 * SELECT Users.name, Tweets.tweet
FROM Users
JOIN Tweets ON Users.id = Tweets.userId;
 */



if($_SERVER['REQUEST_METHOD'] =='POST'){
    if(isset($_POST['tweetToAdd']) && isset($_SESSION['userId'])){
        require_once 'src/Tweet.php';
        require_once 'connection.php';
        $tweetToAdd = $_POST['tweetToAdd'];
        $currentUserId = $_SESSION['userId'];
        
        $tweet = new Tweet();
        $tweet->setUserId($currentUserId);
        $tweet->setTweet($tweetToAdd);
        
       // $newMessage = Message::saveTheMessageToTheDB($conn, $userId, $messageToAdd);
        
        
        if($tweet->saveTheTweetToTheDB($conn)){
        } else {
            echo 'blad';
        }
    }
}

?>

<html>
    <head>
         <meta charset="utf-8">  
    </head>
    <body>
        <p>Strona główna</p>
        
         <?php
         require_once 'src/Tweet.php';
         require_once 'connection.php';
         require_once 'src/User.php';
         require_once 'src/Comment.php';
         $tweets = Tweet::loadAllTweets($conn);
         foreach($tweets as $tweet){
             $tweetId = $tweet->getId();
             
             $tweetToEcho = $tweet->getTweet();
             $tweetAuthorId = $tweet->getUserId();
             $date = $tweet->getDate();
             
            
            $user = User::loadUserById($conn, $tweetAuthorId);
            $userName = $user->getName();
            $userID = $user->getId();
            $numberOfComments = Comment::loadAllCommentsByTweetId($conn, $tweetId);
             ?>
             <table>
             <tr>
                 <td>
                     <a href="userWebPage.php?userId=<?php echo $userID; ?>"><?php echo $userName; ?></a>
                 </td>
                 <td><?php echo $tweetToEcho; ?> </td>
                 <td><?php echo 'Ilość komenatarzy: ' .  count($numberOfComments); ?> </td>
                 <td><a href="showThePost.php?tweetId=<?php echo $tweetId; ?>">Skomentuj post</a></td>
             </tr>
             
            </table>
       
            <?php 
         }
        
        ?>
             
         
        <form method="POST" action="#">
            <textarea name="tweetToAdd" rows="8" cols="40" maxlength="140">Wpisz wiadomość</textarea>
            <br>
            <input type="submit">
        </form>
        
       
        <?php
        if(isset($_SESSION['userId'])){
            echo '<a href="logout.php">Logout</a>';
        }
        
        
        ?>
        <br>
        <a href="checkTheMassage.php?userId=<?php echo $_SESSION['userId']; ?>"> Sprawdź pocztę </a>
        
        
    </body>
</html>