<?php
require_once('../../connect_pdo.php');

$region_name_from_get = (isset($_GET["region_name"]) && !is_null($_GET["region_name"])) ?
    $_GET["region_name"] : null;

// Ensure a connection to the DB has been established
// or display an error message
$dbh = connect_to_db();
if (is_null($dbh)) {
    echo "<p class=\"db_error\">Could not establish a connection to the database. Please try again later.</p>\n";
}

function getAllRegions($dbh) {
    // Check if connection is open
    if (is_null($dbh))
        return null;

    // Prepare SQL statement to select all regions
    $stmt = $dbh->prepare("SELECT region_id, region_name FROM region");

    // Execute SQL statement
    $stmt->execute();

    // Return the results
    return $stmt->fetchAll();
}

?>

<!DOCTYPE html>
<html>
<head>
    <title>Browse By Region</title>
    <style>
        p.db_error {
            color: #DD0000;
        }
    </style>
</head>

<body>
<h1>Browse Wines By Region</h1>
<form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="get">
    <select name="region_name">
        <?php
            foreach(getAllRegions($dbh) as $region) {
            $region_name = $region['region_name'];
            echo "<option value=\"$region_name\">$region_name</option>\n";
        }
        ?>
    </select>
</form>



</body>
</html>

