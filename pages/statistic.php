<?php
session_start();
$login_page = " ../pages/autho.html";
if ($_SESSION['logged_in'] !== True) {
    header("Location: $login_page");
}
$conn_string = "host=localhost dbname=adminUser user=homestead password=secret";
$db_connection = pg_connect($conn_string);


$user_id = $_SESSION['user_id'];

$where = " WHERE u.id = $user_id ";

if (isset($_GET['id'])) {
    $where .= " AND r.id = ${_GET['id']}";
}
if (isset($_GET['datefrom'])) {
    $where .= " AND t.date > " . $_GET['datefrom'];
}
$sql = "
        select
            cl.resource_id as ct_id,
            cl.count as click,
            v.count as visits,
            to_char(v.visit_time, 'YY.MM.DD HH:MI')
        from clicks cl
        inner join  visits v on cl.resource_id = v.resource_id
        inner join resource r on cl.resource_id = r.id
        inner join users u on r.user_id = u.id "
    . $where .
    " ORDER BY v.visit_time;";
$statistic = pg_query($sql);

pg_close($db_connection);

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Страница пользователя</title>
    <?php
    include './heade.html';
    ?>
</head>
<body>

<div class="container">
    <div class="jumbotron">
        <!--        <div class="alert alert-primary">-->
        <!--            --><?php
        //            if (isset($_SESSION['message'])) {
        //                echo $_SESSION['message'];
        //                unset($_SESSION['message']);
        //            }
        //            ?>
        <!--        </div>-->
        <h1>Statistic of resource </h1>
        <table class="table table-dark">
            <thead>
            <tr>
                <th scope="col">id</th>
                <th scope="col">Click</th>
                <th scope="col">Visits</th>
                <th scope="col">Visit time</th>
            </tr>
            </thead>
            <tbody>
            <?php
            while ($row = pg_fetch_assoc($statistic)) {
                echo "<tr>";
                echo "<th scope='row'>" . $row['ct_id'] . "</th>";
                echo "<th>" . $row['click'] . "</th>";
                echo "<th>" . $row['visits'] . "</th>";
                echo "<th>" . $row['visit_time'] . "</th>";
                echo "</tr>";
            }
            ?>
            </tbody>
        </table>
    </div>
    <p>For <a href="/exit.php">exit</a></p>
</div>
</body>
</html>