<?php
session_start();
session_unset(); // Unsets all session variables
session_destroy(); // Destroys the session
header('Location: index.php'); // Redirect to the homepage or another page after logging out
exit;
?>
