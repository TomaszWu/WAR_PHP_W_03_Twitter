<?php
session_start();
if (!isset($_SESSION['userId'])) {
    header('Location: login.php');
}

require_once 'src/User.php';
require_once 'src/Tweet.php';
require_once 'connection.php';


if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    if (isset($_POST['tweetToAdd']) && isset($_SESSION['userId'])) {
        require_once 'src/Tweet.php';
        require_once 'connection.php';
        $tweetToAdd = $_POST['tweetToAdd'];
        $currentUserId = $_SESSION['userId'];

        $tweet = new Tweet();
        $tweet->setUserId($currentUserId);
        $tweet->setTweet($tweetToAdd);

        if ($tweet->saveTheTweetToTheDB($conn)) {
            
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


<?php
require_once 'src/Tweet.php';
require_once 'connection.php';
require_once 'src/User.php';
require_once 'src/Comment.php';

$currentUserId = $_SESSION['userId'];
$currentUserNameToLoad = User::loadUserById($conn, $currentUserId);
$currentUserName = $currentUserNameToLoad->getName();
?><p><?php echo "Bieżący użytkownik: $currentUserName."; ?> </p>
        <p>Strona główna: </p>
        <?php
        $tweets = Tweet::loadAllTweets($conn);
        foreach ($tweets as $tweet) {
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
                    <td><?php echo 'Ilość komenatarzy: ' . count($numberOfComments); ?> </td>
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
if (isset($_SESSION['userId'])) {
    echo '<a href="logout.php">Logout</a>';
}
?>
        <br>
        <a href="checkTheMassage.php?userId=<?php echo $_SESSION['userId']; ?>"> Sprawdź pocztę </a>
        <?php
        require_once 'src/Massage.php';
        $receivedMassages = Massage::loadAllReceivedMassagesByUserId($conn, $currentUserId);
        foreach ($receivedMassages as $massageToCheckIfItIsANewone) {
            if ($massageToCheckIfItIsANewone['status'] == 0) {
                echo ('<br>') . 'Masz nową wiadomość w skrzynce odbiorczej!';
                return true;
            } else {
                echo ('<br>') . 'Brak nowych wiadomości w skrzynce odbiorczej!';
                return false;
            }
        }
        ?>

    </body>
</html>

<?php
$conn->close();
$conn = null;
?>