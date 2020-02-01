<?php
$conn_string = "host=localhost dbname=adminUser user=homestead password=secret";
if (!isset($_GET['id'])) die("No resource id");
if (isset($_GET['ip'])) $_SERVER['SERVER_ADDR'] = $_GET['ip'];
$db_connection = pg_connect($conn_string);
$sql = "
    INSERT INTO visits (resource_id,ip, visit_time, count, date)
    VALUES (${_GET['id']},'${_SERVER['SERVER_ADDR']}', now(), 1, now())
    ON CONFLICT (ip,resource_id,date) DO UPDATE
    SET count = excluded.count + visits.count;
    ";
$db_connection = pg_query($db_connection, $sql);

echo "var test = 'test';";
?>
<script>
    document.addEventListener('click', function (event) {

        var xhr = new XMLHttpRequest();
        xhr.open('GET', 'http://testexer.test/js/click.php?id=<?php echo $_GET['id']?>&click=true&ip=<?php echo $_SERVER['SERVER_ADDR']?>');
        xhr.send(null);
        console.log(event.target);

    }, false);
</script>