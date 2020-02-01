<?php
session_start();
$login_page = "/autho.html";
if ($_SESSION['logged_in'] !== True) {
    header("Location: $login_page");
}

$conn_string = "host=localhost dbname=adminUser user=homestead password=secret";
$db_connection = pg_connect($conn_string);


function insertSQL($table, array $params)
{
    $sql = "insert INTO resource (".implode(',',array_keys($params)).")";

    $sql .= "VALUES ('".implode('\',\'', array_values($params))."')";
    return $sql;
}

if (isset($_POST['status'])){
    //var_dump($_POST);
    $params = $_POST;
    unset($params['id']);
    $sql = insertSQL('resource', $params);
    $results = pg_query($sql);
    if ($results === false) {
        echo pg_last_error();
        die("SQL error");
    }
    $_SESSION['message'] = "Inserted Successfully With Name: " . strtoupper($_POST['resource_name']);
    header("Location: /pages/adminpage.php");
}



pg_close($db_connection);

?>
<!DOCTYPE html>
<html lang="en">
<?php
include "./heade.html";
?>
<body>
<div class="container">
    <div class="jumbotron">
        <h1>Insert resources</h1>

        <form action="/pages/insert.php" method="post">

            <table class="table table-dark">
                <thead>
                <tr>

                    <th scope="col">Ethernet resource</th>
                    <th scope="col">Url</th>
                    <th scope="col">Thematic</th>
                    <th scope="col">Status</th>
                </tr>
                </thead>
                <tbody>

                <?php

                    echo "<th ><input name='resource_name' placeholder='Resource Name'></th>";
                    echo "<th ><input name='resource_url' placeholder='Resource URL'></th>";
                    echo "<th ><input name='category' placeholder='Category'></th>";
                    echo "<th ><input name='status' placeholder='Status'></th>";
                    echo "</tr>";

                ?>


                </tbody>

            </table>
            <input type="submit" value="Save">
        </form>
    </div>
    <p>For <a href="/exit.php">exit</a></p>
</div>
</body>
</html>