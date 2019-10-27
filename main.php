<?php
	$host = "localhost";
    $user = "yash";
    $pass = "password";
    $dbname = "workshop";

    $conn = new mysqli($host, $user, $pass, $dbname);

    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    $query = "select * from tasks";
    $result = $conn->query($query);
    $rows = array();


    while($row = $result->fetch_assoc()) {
    	$rows[] = $row;
    }
    echo json_encode($rows);
?>