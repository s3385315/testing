<?php
    require_once('wine.php');

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

    function getRegionIdFromName($dbh, $name) {
        $sql = 'SELECT region_id
        FROM region
        WHERE region_name = ?';

        // Prepare SQL statement
        $stmt = $dbh->prepare($sql);

        // Bind region name variable to SQL statement
        $stmt->bindValue(1, $name);

        // Execute the SQL statement
        $stmt->execute();

        // Fetch an integer index array of result(s)
        $result = $stmt->fetch(PDO::FETCH_ASSOC);

        // Return region id or null if region name couldn't be found
        return ($result) ? $result['region_id'] : null;
    }

    function getAllWineryInRegionByName($dbh, $name) {
        // Check if connection is open
        if (is_null($dbh))
            return null;

        // Find region id or return null if a match isn't found
        if (is_null(($region_id = getRegionIdFromName($dbh, $name)))) {
            return null;
        }

        $sql = 'SELECT winery_id, winery_name
               FROM winery
               WHERE region_id = :region_id';

        $stmt = $dbh->prepare($sql);
        $stmt->bindValue(':region_id', $region_id);
        $stmt->execute();

        $results = $stmt->fetchAll(PDO::FETCH_ASSOC);

        return (!empty($results) && $results) ? $results : null;
    }

    function getWinesByWineryId($dbh, $winery_id) {
        $sql = 'SELECT * FROM wine WHERE winery_id = :winery_id';
        $stmt = $dbh->prepare($sql);
        $stmt->bindValue(':winery_id', $winery_id);
        $stmt->execute();

        $results = array();
        foreach ($stmt->fetchAll(PDO::FETCH_ASSOC) as $wine) {

            array_push($results, new Wine(
                (int) $wine['wine_id'],
                $wine['wine_name'],
                (int) $wine['wine_type'],
                (int) $wine['year'],
                (int) $wine['winery_id'],
                $wine['description']
            ));
        }

        return (!empty($results)) ? $results : null;
    }
?>