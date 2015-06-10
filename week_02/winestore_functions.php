<?php

function getAllRegions($dbh) {
    // Check if connection is open
    if (is_null($dbh))
    return null;

    // Prepare SQL statement to select all regions
    $stmt = $dbh->prepare("SELECT region_name FROM region");

    // Execute SQL statement
    $stmt->execute();

    // Return the results
    return $stmt->fetchAll();
}

function getWineIdFromName($dbh, $name) {
    $sql = 'SELECT region_id
    FROM region
    WHERE region_name = ?';

    $stmt = $dbh->prepare($sql);
    $stmt->bindValue(1, $name);
    $stmt->execute();

    $result = $stmt->fetch(PDO::FETCH_NUM);

    return ()

}

function getWineByRegionName($dbh, $name) {
    // Check if connection is open
    if (is_null($dbh))
    return null;

    // Find region id


}

?>