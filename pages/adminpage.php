<?php
session_start();
$login_page = " ../pages/autho.html";
if ($_SESSION['logged_in'] !== True) {
    header("Location: $login_page");
}
$user_id = $_SESSION['user_id'];

$conn_string = "host=localhost dbname=adminUser user=homestead password=secret";
$db_connection = pg_connect($conn_string);
$filter = '';
if (isset($_GET['status']))
    $filter = ' AND status = \'' . $_GET['status'] . '\' ';

if (isset($_GET['category']))
    $filter = ' AND category = \'' . $_GET['category'] . '\' ';

$per_page = 15;


if (!isset($_GET['page']) || $_GET['page'] <= 1) {
    $_GET['page'] = 1;
    $page_off = 0;
    $page = 1;
}
$page_off = $_GET['page'] - 1;
$page = $_GET['page'];

$off_set = $per_page * $page_off;

$off_set = ' offset ' . $off_set;
$sql = "SELECT * FROM resource  WHERE user_id = ${user_id} ${filter}  ORDER BY id limit  ${per_page}  ${off_set}";
$resources = pg_query($db_connection, $sql);
$count = pg_query("SELECT count(*) FROM resource  WHERE user_id = ${user_id} " );
$pages = ceil($count / $per_page);
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
        <h1>List of resources</h1>
        <div class="d-flex">
            <div class="dropdown mr-1">
                <button type="button" class="btn btn-secondary dropdown-toggle" id="dropdownMenu1"
                        data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" data-offset="10,20">
                    Status
                </button>
                <div class="dropdown-menu" aria-labelledby="dropdownMenuOffset">
                    <a class="dropdown-item" href="?status=active">Active</a>
                    <a class="dropdown-item" href="?status=no active">No active</a>
                    <a class="dropdown-item" href="/pages/adminpage.php">All</a>
                </div>
            </div>
            <div class="btn-group">
                <button type="button" class="btn btn-secondary dropdown-toggle " id="dropdownMenu2"
                        data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" data-reference="parent">
                    Category
                </button>
                <div class="dropdown-menu" aria-labelledby="dropdownMenu2">
                    <a class="dropdown-item" href="?category=Video">Video</a>
                    <a class="dropdown-item" href="?category=Music">Music</a>
                    <a class="dropdown-item" href="/pages/adminpage.php">All</a>
                </div>
            </div>
        </div>
        <table class="table table-dark">
            <thead>
            <tr>
                <th scope="col">id</th>
                <th scope="col">Ethernet resource</th>
                <th scope="col">Url</th>
                <th scope="col">Thematic</th>
                <th scope="col">Status</th>
                <th scope="col">Actions</th>
                <th scope="col">URL`s</th>
            </tr>
            </thead>
            <tbody>
            <?php
            while ($row = pg_fetch_assoc($resources)) {
                echo "<tr>";
                echo "<th scope='row'>" . $row['id'] . "</th>";
                echo "<th>" . $row['resource_name'] . "</th>";
                echo "<th>" . $row['resource_url'] . "</th>";
                echo "<th>" . $row['category'] . "</th>";
                echo "<th>" . $row['status'] . " </th>";
                echo "<th>". "<a href='/pages/edit.php?id=" . $row['id'] . "'><button id='actions' class='btn btn-primary' type='button'>Edit</button></a>/
                    <form action='/pages/delete.php' method='post'> <input type='hidden' name='id' value='" . $row['id'] . "'><button id='actions' class='btn btn-danger' type='submit'>Delete</button> </form> </th>";
                echo "<th>" . "<a href='/pages/statistic2.php?id=" . $row['id'] . "'><button id='actions' class='btn btn-primary' type='button'>Statistic</button></a> </th>";
                echo "<th><textarea><script type=\"text/javascript\" src='http://testexer.test/js/visits.php?id=${row['id']}'></script></textarea> </th>";
                echo "</tr>";
            }
            ?>
            </tbody>
        </table>
        <a href="/pages/insert.php"><button id="add" class="btn btn-primary" type='button'>Add</button></a>
            <nav aria-label="..." style="margin-top: 5px">
                <ul class="pagination pagination-lg">
                    <?php
                    if ($page - 1 > 0):
                        ?>
                        <li class="page-item">
                            <a class="page-link" href="?page=<?php echo $page - 1; ?>" aria-label="Previous">
                                <span aria-hidden="true">&laquo;</span>
                                <span class="sr-only">Previous</span>
                            </a>
                        </li>
                    <?php
                    endif;
                    for ($p = 1; $p <= $pages; $p++) {
                        ?>
                        <li class="page-item <?php if ($p == $_GET['page']) echo 'disabled'; ?> ">
                            <a class="page-link" href="?page=<?php echo $p ?>"
                                <?php if ($p == $_GET['page']) echo 'tabindex="-1"'; ?>> <?php echo $p; ?></a>
                        </li>
                        <?php
                    }
                    if ($page + 1 <= $pages):
                        ?>
                        <li class="page-item">
                            <a class="page-link" href="?page=<?php echo $page + 1; ?>" aria-label="Next">
                                <span aria-hidden="true">&raquo;</span>
                                <span class="sr-only">Next</span>
                            </a>
                        </li>
                    <?php
                    endif;
                    ?>
                </ul>
            </nav>
    </div>
    <p>For <a href="/exit.php">exit</a></p>
</div>
</body>
</html>