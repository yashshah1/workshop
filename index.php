<?php
    $host = "localhost";
    $user = "root";
    $pass = "";
    $dbname = "workshop";

    $conn = new mysqli($host, $user, $pass, $dbname);

    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }
    $alert_result = false;
    $message = '';
    if(isset($_POST)) {
        if (isset($_POST['add_new_task'])) {
            $name = $_POST['name_of_task'];
            if (strlen($name) > 0) {
                $query = "insert into `tasks` (`id`, `task`, `status`) values (NULL, '$name', '0');";
                $alert_result = $conn->query($query);
                if($alert_result) {
                        $message = 'Added successfully';
                }
            }
        }
        else {
            foreach($_POST as $key => $value) {
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
                else if ($key[0] == 'I') {
                    $id = substr($key, 1);
    
                    $query = "update tasks set status=0 where id=$id";
                    $alert_result = $conn->query($query);
                    if($alert_result) {
                        $message = 'Marked as incomplete';
                    } 
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
        <style>
            body {
                width: 80%;
                margin-left: 10%;
                margin-top: 5%;
            }
        </style>
    </head>
    <body>
        <form action="index.php" method="POST">
            <?php
            if ($result->num_rows == 0) {
                echo "<strong>No rows</strong>";
            }
            else {
                if ($alert_result) {
                    echo "<div class=\"alert alert-success alert-dismissible\" role=\"alert\">".$message;
                    echo "<button type=\"button\" class=\"close\" data-dismiss=\"success\" aria-label=\"Close\">
                            <span aria-hidden=\"true\">&times;</span>
                         </button>";
                    echo "</div>";
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
                                    <span class=\"glyphicon glyphicon-ok\"></span>
                                </button>";
                    }
                    else {
                        echo "<button type=\"submit\" class=\"btn btn-success\" name=\"I".$row['id']."\">
                                    <span class=\"glyphicon glyphicon-refresh\"></span>
                                </button>";
                    }
                    echo "
                            <button type=\"submit\" class=\"btn btn-primary\" name=\"E".$row['id']."\">
                                <span class=\"glyphicon glyphicon-edit\"></span>
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

                        echo "<strong> Task Name: </strong>";
                        echo "<input type=\"text\" name=\"newname\" value=\"".$row['task']."\"></input>";
                        echo "<button type=\"submit\" name=\"U".$id."\">Update</button>";
                    }
                }
            }
            ?>
            <div>
                <h3>New task</h3>
                <p>Name: </p>
                <input type="text" name="name_of_task">
                <button type="submit" name="add_new_task">Add</button>  
            </div>
        </form>
        <script src="bootstrap.min.js"></script>
    </body>
</html>
