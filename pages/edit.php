<?php
session_start();
$login_page = "/autho.html";
if ($_SESSION['logged_in'] !== True) {
    header("Location: $login_page");
}

$conn_string = "host=localhost dbname=adminUser user=homestead password=secret";
$db_connection = pg_connect($conn_string);


function insertSQL($table, $id, array $params)
{
    $sql = "UPDATE resource SET";
    foreach ($params as $field => $value) {
        $sql .= " $field = '$value' ,";
    }
    $sql = trim($sql, ',');
    $sql .= " Where id = '$id'";
    return $sql;
}

if (isset($_POST['id'])) {
    //var_dump($_POST);
    $params = $_POST;
    unset($params['id']);
    $sql = insertSQL('resource', $_POST['id'], $params);
    $results = pg_query($sql);
    if ($results === false) {
        echo pg_last_error();
        die("SQL error");
    }
    $_SESSION['message'] = "Edited Successfuly ";
    header("Location: /pages/adminpage.php");
}

if (isset($_GET['id'])) {
    $filter = ' WHERE id  = \'' . $_GET['id'] . '\' ';
    $resources = pg_query("SELECT * FROM resource " . $filter . ' ORDER BY id');
    } else {
        die("ID error");
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
        <h1>Edit resources</h1>
        <form action="/pages/edit.php" method="post">
            <table class="table table-dark">
                <thead>
                <tr>
                    <th scope="col">id</th>
                    <th scope="col">Ethernet resource</th>
                    <th scope="col">Url</th>
                    <th scope="col">Thematic</th>
                    <th scope="col">Status</th>
                </tr>
                </thead>
                <tbody>
                <?php
                while ($row = pg_fetch_assoc($resources)) {
                    echo "<tr>";
                    echo "<th scope='row'><input name='id' type='hidden' value='" . $row['id'] . "'> " . $row['id'] . "</th>";
                    echo "<th ><input name='resource_name'  value='" . $row['resource_name'] . "'></th>";
                    echo "<th ><input name='resource_url' value='" . $row['resource_url'] . "'></th>";
                    echo "<th ><input name='category' value='" . $row['category'] . "'></th>";
                    echo "<th ><input name='status' value='" . $row['status'] . "'></th>";
                    echo "</tr>";
                }
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