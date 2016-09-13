<?php

require_once 'Tweet.php';

class Comment {

    private $id;
    private $commentedTweetById;
    private $autorOfTheCommentById;
    private $comment;
    private $date;

    public function __construct() {
        $this->id = -1;
        $this->commentedTweetById = '';
        $this->autorOfTheCommentById = '';
        $this->comment = '';
        $this->date = '';
    }

    public function getId() {
        return $this->id;
    }

    public function setCommentedTweetId($id) {
        $this->commentedTweetById = $id;
    }

    public function getCommentedTweetId() {
        return $this->commentedTweetById;
    }

    public function setAutorOfTheCommentById($autorOfTheCommentId) {
        return $this->autorOfTheCommentId = $autorOfTheCommentId;
    }

    public function getAutorOfTheCommentById() {
        return $this->autorOfTheCommentId;
    }

    public function setComment($comment) {
        if (strlen(trim($comment)) > 0 && strlen(trim($comment)) < 61) {
            $this->comment = $comment;
        }
    }

    public function getComment() {
        return $this->comment;
    }

    public function setDate() {
        $this->date = $date;
    }

    public function getDate() {
        return $this->date;
    }

    public function addACommentToTheTweet(mysqli $connection) {
        if ($this->id == -1) {
            $query = "INSERT INTO Comments (tweetId, userId, comment, date)
                    VALUES( '$this->commentedTweetById', '$this->autorOfTheCommentId', '$this->comment', NOW())
                    ";
            if ($connection->query($query)) {
                $this->id = $connection->insert_id;
                return true;
            } else {
                return false;
            }
        }
    }

   static public function loadAllCommentsByTweetId(mysqli $connection, $tweetId) {
       
        $query = "SELECT * FROM Comments
                
                 WHERE tweetId = '" . $connection->real_escape_string($tweetId) . "'
                ORDER BY Date DESC
                LIMIT 0, 5";
        $comments = [];
        $result = $connection->query($query);
        if ($result == true && $result->num_rows != 0) {
            foreach ($result as $row) {
                $loadedComment = new Comment;
                $loadedComment->id = $row['id'];
                $loadedComment->commentedTweetById = $row['tweetId'];
                $loadedComment->autorOfTheCommentById = $row['userId'];
                $loadedComment->comment = $row['comment'];
                $loadedComment->date = $row['date'];
                $comments[] = $loadedComment;
                
            }
            
        }

        return $comments;
    }

     static public function loadAllTweets(mysqli $connection){
        $query = "SELECT * FROM Tweets
                ORDER BY Date DESC
                LIMIT 0, 5;
                ";
        $tweets = [];
    
        $result = $connection->query($query);
        if($result == true && $result->num_rows != 0){
            foreach($result as $row){
                $loadedTweet = new Tweet();
                $loadedTweet->id = $row['id'];
                $loadedTweet->commentedTweetById = $row['userId'];
                $loadedTweet->tweet = $row['tweet'];
                $loadedTweet->date = $row['date'];
                
                $tweets[] = $loadedTweet;
            }
        }
        return $tweets;
    }
    
    
    
}
