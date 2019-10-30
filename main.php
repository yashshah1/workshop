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
        if (empty($_POST)) {
            $_POST = [];
        }

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
        die;
    }
    $action = false;
    if(isset($_POST)) {
        foreach($_POST as $key => $value){
            if ($key[0] == 'I') {
                $id = $_POST['id'];
                $query = "update tasks set status = 0 where id=$id";
                $alert_result = $conn->query($query);
                $action = true;
            }
            else if ($key[0] == 'D') {;
                $id = $_POST['id'];
                $query = "delete from tasks where id=$id";
                $alert_result = $conn->query($query);
                $action = true;
            }
            else if ($key[0] == 'C') {
                $id = $_POST['id'];
                $query = "update tasks set status = 1 where id=$id";
                $alert_result = $conn->query($query);
                $action = true;                
            }
            else if ($key[0] == 'U') {
                $id = substr($key, 1);
                $newname = $_POST['newname'];
                $query = "update tasks set task=\"$newname\" where id=$id";
                $action = true;
                $alert_result = $conn->query($query);
            }
            if($action) {
                if($alert_result) {
                    $res = array();
                    $res['status'] = 200;
                    echo json_encode($res);
                    die;
                }
                else {
                    $res = array();
                    $res['status'] = 500;
                    echo json_encode($res);
                    die;
                }
            }
        }
    }
?>