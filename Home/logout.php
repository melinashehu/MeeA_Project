<?php

session_start();

session_unset();
session_destroy();

header("Location: /codding-community-platform/Log-In/login.php");
exit;
?>