<?php
    $host = "localhost";
    $user = "yash";
    $pass = "password";
    $dbname = "workshop";

    $conn = new mysqli($host, $user, $pass, $dbname);

    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }
    $headers = getallheaders();
    if ($headers["Content-Type"] == "application/json") {
        $_POST = json_decode(file_get_contents("php://input"), true);
    }
    if (isset($_POST['fetchall'])) {
        $query = "select * from tasks";
        $result = $conn->query($query);
        $rows = array();


        while($row = $result->fetch_assoc()) {
            $rows[] = $row;
        }
        $response = array();
        $response['length'] = count($rows);
        $response['data'] = $rows;
        echo json_encode($response);
    }
?>