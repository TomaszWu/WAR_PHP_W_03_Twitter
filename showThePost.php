<?php

session_start();

/*

CREATE TABLE Comments(
id INT( 6 ) UNSIGNED AUTO_INCREMENT PRIMARY KEY ,
tweetId INT,
authorId INT,
message VARCHAR( 60 ) NOT NULL ,
date TIMESTAMP;
);
)
 */


if ($_SERVER['REQUEST_METHOD'] == 'GET') {
    if (isset($_GET['tweetId'])) {
        require_once 'src/User.php';
        require_once 'src/Tweet.php';
        require_once 'connection.php';
        $tweetId = $_GET['tweetId'];
        $tweet = Tweet::loadTweetById($conn, $tweetId);
        $tweetToShow = $tweet->getTweet();
        $author = User::checkTheAuthorByTweeterId($conn, $tweetId);
        $authorName = $author->getName();
        $authorId = $author->getId();
        $_SESSION['autorName'] = $authorName;
        $_SESSION['tweetId'] = $tweetId;
        $_SESSION['tweetToShow'] = $tweetToShow;
    }
} elseif ($_SERVER['REQUEST_METHOD'] == 'POST') {
    if (isset($_POST['commentToAdd'])) {
        require_once 'src/Comment.php';
        require_once 'connection.php';
        $commentToAdd = $_POST['commentToAdd'];
        $authorName = $_SESSION['autorName'];
        $commentedTweetId = $_SESSION['tweetId'];
        $userId = $_SESSION['userId'];
        $tweetToShow = $_SESSION['tweetToShow'];
        $comment = new Comment();
        $comment->setCommentedTweetId($commentedTweetId);
        $comment->setComment($commentToAdd);
        $comment->setAutorOfTheCommentById($userId);
        if ($comment->addACommentToTheTweet($conn)) {
            
        } else {
            echo 'Błąd!';
        }
    }
}
$conn->close();
$conn = null;
?>


<html>
    <head>
        <meta charset="utf-8">  
    </head>
    <body>





        <table>
            <tr><?php echo 'Autor: ' . $authorName . ' ' ?></tr>
            <br>
            <tr><?php echo 'Tweet: ' . $tweetToShow ?></tr>


            <br>

            <?php
            require_once 'src/User.php';
            require_once 'src/Tweet.php';
            require_once 'connection.php';
            require_once 'src/Comment.php';

            $comments = Comment::loadAllCommentsByTweetId($conn, $_SESSION['tweetId']);
            foreach ($comments as $comment) {
                $commentToShow = $comment->getComment();
                $dateToShow = $comment->getDate();
                $comment = $comment->getId();
                $authorOfTheComment = User::checkTheAuthorByCommentId($conn, $comment);
                $userName = $authorOfTheComment->getName();
                ?>
                <tr><?php echo 'Autor: ' . $userName . ' Tweet: ' . $commentToShow . ' Data: ' . $dateToShow . ('<br>'); ?> </tr>
                <?php
            }
            ?>

        </table>

        <form action="#" method="POST">
            <textarea name="commentToAdd" rows="8" cols="40" maxlength="60">Wpisz komentarz</textarea>
            <br>
            <input type="submit" value="Dodaj komentarz">
        </form>
    </body>
</head>