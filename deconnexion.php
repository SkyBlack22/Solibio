<?php
session_start();
setcookie('pseudo','',time()-3600);
setcookie('password','',time()-3600);
session_unset();
session_destroy();
header('Location: index.php');
exit();
?>