<?php

session_start();

unset($_SESSION['id_user']);
unset($_SESSION['utilisateur']);
session_destroy();
  header("Location: index.php");


?>