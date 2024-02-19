<?php
require 'database/db.php';

if($_GET["data"] == "login") {
    $input = file_get_contents('php://input');
    $data = json_decode($input);

    $u = $data->username;
    $p = $data->password;

    // $sql = "SELECT * FROM tbluser WHERE username=:username AND password=:password;";

    // $query = $conn->prepare($sql);


    $sql = "SELECT Count(*) as count  FROM tbluser where username=:username AND password=:password";

    $result = $conn->prepare($sql);

    $result->bindParam(":username", $u);
    $result->bindParam(":password", $p);

    $result->execute();

    $row = $result->fetch(PDO::FETCH_ASSOC);

    //  {
//          row: {
    //        "count": 1
//          }
    //     }

    if($row["count"] == 1) {
        echo json_encode($row["count"]);
    } else {
        echo ("Invalid username or password!!");
    }
   
}