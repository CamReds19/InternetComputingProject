<?php

    function hashPass($password) {
        $_POST['password'] = password_hash($password, PASSWORD_DEFAULT);
    }

    if(isset($_POST['submit'])) {
        echo "SUBMIT";
    }
    else {
    }

    if(!empty($_POST['username']) || !empty($_POST['password'])) {
        // username is not none
        hashPass($_POST['password']);
        echo $_POST['username'] . "   ".  $_POST['password'];

        header("Location: chat.html?u=".urlencode($_POST['username'])."?p=".urlencode($_POST['password'])."?r=".urlencode($_POST['room']));

    }
    else {
        echo "FAIL";
    }
?>