<?php
require 'database/db.php';

header('Content-Type: application/json');
header("Access-Control-Allow-Origin: *");
$input = file_get_contents('php://input');
$data = json_decode($input);

//1-getalldata
if ($_GET["data"] == "get_medicine") {
    $sql = "SELECT * FROM tblmedicine";
    $result = $conn->prepare($sql);
    $result->execute();
    while ($row = $result->fetch(PDO::FETCH_ASSOC)) {
        $medicine[] = $row;
    }
    echo json_encode($medicine ?? []);
}


// //3-add_doctor
if ($_GET["data"] == "add_medicine") {
    if ($data->mname) {

        $mname = $data->mname;
        $qty = $data->qty;
        $price = $data->price;
        $exp = $data->exp;
        $sql = "INSERT INTO tblmedicine(mname,qty,price,exp) values(:mname,:qty,:price,:exp);";
        $insert = $conn->prepare($sql);

        $insert->bindParam(':mname', $mname);
        $insert->bindParam(':qty', $qty);
        $insert->bindParam(':price', $price);
        $insert->bindParam(':exp', $exp);

        if ($insert->execute()) {
            echo json_encode("Insert Success");
        } else {
            echo json_encode("Insert Failed");
        }
    }
}

//update doctor
if ($_GET['data'] == "update_medicine") {
    $mid = $data->mid;
    $mname = $data->mname;
    $qty = $data->qty;
    $price = $data->price;
    $exp = $data->exp;

    $sql = "UPDATE tblmedicine SET mname=:mname,qty=:qty,price=:price,exp=:exp where mid=:mid";
    $update = $conn->prepare($sql);
    $update->bindParam(':mname', $mname);
    $update->bindParam(':qty', $qty);
    $update->bindParam(':price', $price);
    $update->bindParam(':exp', $exp);
    $update->bindParam(':mid', $mid);

    if ($update->execute()) {
        echo json_encode("Data Update Success");
    } else {
        echo json_encode("Data Update Failed");
    }
}


//search
if ($_GET['data'] == "search_medicine") {
    $mid = $data->mid;
    $mname = $data->mname;
    $sql = "SELECT * FROM tblmedicine WHERE mid=:mid OR mname LIKE CONCAT('%',:mname,'%')";
    $result = $conn->prepare($sql);
    $result->bindParam(':mid', $mid);
    $result->bindParam(':mname', $mname);
    $result->execute();
    while ($row = $result->fetch(PDO::FETCH_ASSOC)) {
        $medicine[] = $row;
    }
    echo json_encode($medicine ?? []);
}

//delete
if ($_GET['data'] == "delete_medicine") {
    $mid = $_GET['mid'];
    $sql = "DELETE FROM tblmedicine WHERE mid=:mid";
    $delete = $conn->prepare($sql);
    $delete->bindParam(':mid', $mid);
    if ($delete->execute()) {
        echo json_encode("Delete Success");
    } else {
        echo json_encode("Delete Failed");
    }
}

if ($_GET["data"] == "get_count") {
    $table = $data->table;
    $name = $data->name;
    $sql = "SELECT Count(*) as $name  FROM $table";
    $result = $conn->prepare($sql);
    $result->execute();
    $row = $result->fetch(PDO::FETCH_ASSOC);
    echo json_encode($row);
}

//3-get_graph
if ($_GET["data"] == "get_patient_byblood") {
    $sql = "SELECT * FROM vpatient";
    $result = $conn->prepare($sql);
    $result->execute();
    while ($row = $result->fetch(PDO::FETCH_ASSOC)) {
        $patient[] = $row;
    }
    echo json_encode($patient ?? []);
}

//3-get_graph
if ($_GET["data"] == "get_patient_bygender") {
    $sql = "SELECT * FROM vpatientgender";
    $result = $conn->prepare($sql);
    $result->execute();
    while ($row = $result->fetch(PDO::FETCH_ASSOC)) {
        $patient[] = $row;
    }
    echo json_encode($patient ?? []);
}