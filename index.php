<?php
    $host = "localhost";
    $user = "yash";
    $pass = "password";
    $dbname = "workshop";

    $conn = new mysqli($host, $user, $pass, $dbname);

    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }
    $alert_result = false;
    $message = '';
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
                $id = substr($key, 1);
                $query = "update tasks set status = 1 where id=$id";
                $alert_result = $conn->query($query);
                if($alert_result) {
                    $message = 'Marked as complete';
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
    $query = "select * from tasks";
    $result = $conn->query($query);

?>
<html>
    <head>
        <title>Workshop!</title>
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.4/css/bootstrap.min.css">
    </head>
    <body>
        <form action="index.php" method="POST">
            <?php
            if ($result->num_rows == 0) {
                echo "<strong>No rows</strong>";
            }
            else {
                if ($alert_result) {
                    echo "</div>
                        <div class=\"alert alert-success alert-dismissible\" role=\"alert\">".$message."</div>";
                }
                echo "
                    <table class=\"table table-striped table-bordered table-hover\">
                        <thead class=\"thead-light\">
                            <tr>
                                <th>ID</th>
                                <th>Task</th>
                                <th>Status</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                    ";
                $i = 1;
                while($row = $result->fetch_assoc()) {
                    echo "<tr>";
                    echo "<td>".$i++."</td>";
                    echo "<td>".$row['task']."</td>";
                    if ($row['status'] == 0) {
                        echo "<td style=\"color:red\">Not Complete</td>";
                    }
                    else {
                        echo "<td style=\"color:green\">Complete</td>";
                    }
                    echo "<center><td>";
                    if ($row['status'] == '0') {
                        echo "<button type=\"submit\" class=\"btn btn-success\" name=\"C".$row['id']."\">
                                    <span class=\"  glyphicon glyphicon-ok\"></span>
                                </button>";
                    }
                        echo "
                                <button type=\"submit\" class=\"btn btn-primary\" name=\"E".$row['id']."\">
                                    <span class=\"  glyphicon glyphicon-edit\"></span>
                                </button>
                                <button type=\"submit\" class=\"btn btn-danger\" name=\"D".$row['id']."\">
                                    <span class=\"glyphicon glyphicon-remove\"></span>
                                </button>
                            </td>
                        </center>
                        ";
                    echo "</tr>";
                }
                echo "
                        </tbody>
                    </table>
                ";
            }
            if(isset($_POST)) {
                foreach($_POST as $key => $value){
                    if($key[0] == 'E') {
                        $id = substr($key, 1);
                        $query = "select task from tasks where id=$id";
                        $result = $conn->query($query);
                        $row = $result->fetch_assoc();


                        echo "<form action=\"index.php\" method=\"POST\">";
                        echo "<strong> Task Name: </strong>";
                        echo "<input type=\"text\" name=\"newname\" value=\"".$row['task']."\"></input>";
                        echo "<button type=\"submit\" name=\"U".$id."\">Update</button>";
                        echo "</form>";
                    }
                }
            }
            unset($_POST);
            ?>
        </form>
        <script src="bootstrap.min.js"></script>
    </body>
</html>
