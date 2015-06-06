<html>
<head><title>Wines</title></head>

<?php
require_once('../connect_pdo.php');

echo "<pre>\n";

foreach ($dbh->query("SELECT * FROM wine") as $row) {
    foreach ($row as $item) {
        echo $item . " ";
    }

    echo "\n";
}

echo "</pre>";

// Close DB connection
$dbh = null;
?>

</body>
</html>
