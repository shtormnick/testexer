<?php
session_start();
$login_page = "/autho.html";
if ($_SESSION['logged_in'] !== True) {
    header("Location: $login_page");
}

$conn_string = "host=localhost dbname=adminUser user=homestead password=secret";
$db_connection = pg_connect($conn_string);


if (isset($_POST['id'])) {

    $results = pg_query('DELETE from  resource where id = ' . $_POST["id"] );

    if ($results === false) {
        echo pg_last_error();
        die("SQL error");
    }
    pg_close($db_connection);
    $_SESSION['message'] = "Deleted Successfully ";
    header("Location: /pages/adminpage.php");
} else {
    die("ID error");
}
pg_close($db_connection);


