<html>
<head><title>Wines</title></head>

<?php
	require_once('../connect.php');

	$query = "SELECT * FROM wine";
	$result = mysql_query($query, $dbconn);

	echo "<pre>\n";

	while ($row = mysql_fetch_row($result)) {
		for ($i = 0; $i < mysql_num_fields($result); $i++) {
			echo $row[$i] . " ";
		}
		echo "\n";
	}

	echo "</pre>";

	// Close DB connection
	mysql_close($dbconn);
?>

</body>
</html>
