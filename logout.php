<?php
session_start();
// Destroy session
session_destroy();
// Unset cookies
setcookie('user_login', '', 0, "/");

header("Location: index.php");
