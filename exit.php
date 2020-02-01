<?php
session_start();
$login_page = "pages/autho.html";
session_destroy();
setcookie('user', $user['login'], time() - 3600, "/");
header("Location: $login_page");