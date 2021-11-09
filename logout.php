<?php
session_start();
session_start();
unset($_SESSION['name']);
unset($_SESSION['user_id']);
header('Location: main.php');
  