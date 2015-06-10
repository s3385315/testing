<?php
require_once('../../connect_pdo.php');
require_once('winestore_functions.php');

$region_name_from_get = (isset($_GET["region_name"]) && !is_null($_GET["region_name"])) ?
    $_GET["region_name"] : null;

// Ensure a connection to the DB has been established
// or display an error message
$dbh = connect_to_db();
if (is_null($dbh)) {
    echo "<p class=\"db_error\">Could not establish a connection to the database. Please try again later.</p>\n";
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

    <!-- script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.4/jquery.min.js"></script -->
</head>

<body>
<h1>Browse Wines By Region</h1>
<form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="get">
    <select name="region_name">
        <?php
            foreach(getAllRegions($dbh) as $region) {
                $region_name = $region['region_name'];
                echo "<option value=\"$region_name\"";
                echo ($region_name_from_get === $region_name)
                    ? " selected=selected>"
                    : ">";
                echo $region_name . "</option>" . PHP_EOL;
        }
        ?>
    </select>
    <input type="submit" value="Explore!"/>
</form>

<?php
    if (!is_null($region_name_from_get)) {
        $wineries = getAllWineryInRegionByName($dbh, $region_name_from_get);

        if (is_null($wineries)) {
            echo "<p>No wineries in the " . $region_name_from_get . " region.</p>" . PHP_EOL;
        }
        else {
            echo "<p>Displaying wineries in the " .$region_name_from_get . " region: </p>" . PHP_EOL;
            foreach ($wineries as $winery) {
                ?>
                <ul>
                    <li><?php echo $winery['winery_name'] ?></li>
                    <ul>
                    <?php
                    $wines = getWinesByWineryId($dbh, $winery['winery_id']);

                    if (is_null($wines)) {
                        ?>
                        <li>No wines at this winery! Bummer...</li>
                        <?php
                    }
                    else {
                        foreach ($wines as $wine) {
                            echo "<li>" . $wine->getName() . "</li>" . PHP_EOL;
                        }
                    } ?>
                    </ul>
                </ul>
            <?php
            }
        }

    }
?>

</body>
</html>

