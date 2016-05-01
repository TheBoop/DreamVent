<?php

//Class for formatting table rows. Found on net.
class TableRows extends RecursiveIteratorIterator {
    function __construct($it) {
        parent::__construct($it, self::LEAVES_ONLY);
    }

    function current() {
        return "<td style='width:150px;border:1px solid black'>" . parent::current(). "</td>";
    }

    function beginChildren() {
        echo "<tr>";
    }

    function endChildren() {
        echo "</tr>" . "\n";
    }
}
//End class TableRows

//make table
echo "<table style='border: solid 3px black;'>";

$dbhost = 'localhost';
$dbname = 'test_schema';
$dbuser = 'root';
$dbpass = 'ucr'; 

$dsn = 'mysql:dbname='.$dbname.';host='.localhost.';';
$query = "
SELECT *
FROM test_table";

echo "<p>Grabbing stuff from the database.</p>";

try {
	$conn = new PDO($dsn, $dbuser, $dbpass);
	$conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
	$stmt = $conn->prepare($query);
    $stmt->execute();
	
	// set the resulting array to associative
    $result = $stmt->setFetchMode(PDO::FETCH_ASSOC);
	
	foreach(new TableRows(new RecursiveArrayIterator($stmt->fetchAll())) as $k=>$v) {
		echo $v;
	}
	$dsn = null;
	echo "</table>";

}
catch(PDOException $e){
	echo $e->getMessage();
}
?>