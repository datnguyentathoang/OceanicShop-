<?php
session_start();
session_unset();
session_destroy();
setcookie(session_name(), '', time() - 3600, '/'); // Clears the session cookie
header('location: ../public/Homepage.php');
exit();
?>