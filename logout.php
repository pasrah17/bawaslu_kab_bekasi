<?php

session_start();

unset($_SESSION['username']);
unset($_SESSION['password']);

session_unset();
session_destroy();

header("location:login.php");