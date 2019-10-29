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
    if(isset($_POST)) {
        foreach($_POST as $key => $value){
            if($key[0] == 'D') {
                $id = substr($key, 1);
                $query = "delete from tasks where id=$id";
                $alert_result = $conn->query($query);
                if($alert_result) {
                    $message = 'Deleted successfully';
                }
            }
            else if ($key[0] == 'C') {
                // $id = substr($key, 1);
                $id = $_POST['id'];
                $query = "update tasks set status = 1 where id=$id";
                $alert_result = $conn->query($query);
                if($alert_result) {
                    $res = array();
                    $res['status'] = 200;
                    echo json_encode($res);
                }  
            }
            else if ($key[0] == 'U') {
                $id = substr($key, 1);
                $newname = $_POST['newname'];

                $query = "update tasks set task=\"$newname\" where id=$id";
                $alert_result = $conn->query($query);
                if($alert_result) {
                    $message = 'Updated task';
                } 
            }
        }
    }
    // if (isset($_POST['complete'])) {
    //     echo json_encode("")
    //     $query = "select * from tasks";
    //     $result = $conn->query($query);
    //     $rows = array();


    //     while($row = $result->fetch_assoc()) {
    //         $rows[] = $row;
    //     }
    //     $response = array();
    //     $response['length'] = count($rows);
    //     $response['data'] = $rows;
    //     echo json_encode($response);
    // }
?>