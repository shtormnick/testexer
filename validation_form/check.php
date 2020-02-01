<?php
$login = filter_var(trim($_POST['login']), FILTER_SANITIZE_STRING);
$password = filter_var(trim($_POST['pswd']), FILTER_SANITIZE_STRING);
$contact = $_POST['cont'];



if (mb_strlen($login) < 5 || mb_strlen($login) > 90) {
    echo "Login length incorrect (must be more then 5 and less then 90)";
    exit();
} elseif ((mb_strlen($password) < 8 || mb_strlen($password) > 20)) {
    echo "Please enter the password minimum 8 length and less then 20";
    exit();
}

$password = md5($password."qwerty23212qwerty");

$conn_string = "host=localhost dbname=adminUser user=homestead password=secret";
$db_connection = pg_connect($conn_string);
$db_connection = pg_query("INSERT INTO users (login, password, contact) VALUES('$login','$password','$contact') ");
pg_close($db_connection);
header('Location: /pages/autho.html');
