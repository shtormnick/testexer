<?php
session_start();
if (!empty($_SESSION['logged_in'])) {
    header('Location: ../pages/adminpage.php');

}
$login = filter_var(trim($_POST['login']), FILTER_SANITIZE_STRING);
$pass = filter_var(trim($_POST['pswd']), FILTER_SANITIZE_STRING);

$pass = md5($pass . "qwerty23212qwerty");

$conn_string = "host=localhost dbname=adminUser user=homestead password=secret";
$db_connection = pg_connect($conn_string);

$select = "SELECT * FROM users WHERE login = '$login' AND password = '$pass'";
$result = pg_query($db_connection, $select);
if ($result === false) {
    echo(pg_last_error($db_connection));
}

$user = pg_fetch_assoc($result);


if ($user == false || count($user) == 0) {
    echo "User not find";
    exit();
} else {
    $_SESSION['logged_in'] = True;
    $_SESSION['user_id'] = $user['id'];
}


setcookie('user', $user['login'], time() + 3600, "/");

pg_close($db_connection);
header('Location: ../pages/adminpage.php');