<?php

        require_once '../src/User.php';
        require_once '../src/Tweet.php';
        require_once 'connection.php';
        
        $tweet = Tweet::loadTweetById($conn, 5);

var_dump($tweet);
