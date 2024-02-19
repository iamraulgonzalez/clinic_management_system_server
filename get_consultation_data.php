<?php
require 'database/db.php';

header('Content-Type: application/json');
header("Access-Control-Allow-Origin: *");
$input = file_get_contents('php://input');
$data = json_decode($input);

//1-getalldata
if ($_GET["data"] == "get_consult") {
    $sql = "SELECT * FROM vconsult";
    $result = $conn->prepare($sql);
    $result->execute();
    while ($row = $result->fetch(PDO::FETCH_ASSOC)) {
        $consult[] = $row;
    }
    echo json_encode($consult ?? []);
}

if ($_GET["data"] == "add_consult") {
    if ($data->mc_date) {

        $mc_date = $data->mc_date;
        $doc_id = $data->doc_id;
        $pid = $data->pid;
        $consult_id = $data->consult_id;
        $blood_pressure = $data->blood_pressure;
        $heart_rate = $data->heart_rate;
        $height = $data->height;
        $weight = $data->weight;
        $mc_price = $data->mc_price;

        $sql = "INSERT INTO tblconsult(mc_date,doc_id,pid,consul_id,blood_pressure,heart_rate,height,weight,mc_price) values(:mc_date,:doc_id,:pid,:consult_id,:blood_pressure,:heart_rate,:height,:weight,:mc_price);";
        $insert = $conn->prepare($sql);

        $insert->bindParam(':mc_date', $mc_date);
        $insert->bindParam(':doc_id', $doc_id);
        $insert->bindParam(':pid', $pid);
        $insert->bindParam(':consult_id', $consult_id);
        $insert->bindParam(':blood_pressure', $blood_pressure);
        $insert->bindParam(':heart_rate', $heart_rate);
        $insert->bindParam(':height', $height);
        $insert->bindParam(':weight', $weight);
        $insert->bindParam(':mc_price', $mc_price);

        if ($insert->execute()) {
            echo json_encode("Insert Success");
        } else {
            echo json_encode("Insert Failed");
        }
    }
}

if ($_GET['data'] == "update_consult") {
    
    $mc_id = $data->mc_id;
    $mc_date = $data->mc_date;
    $doc_id = $data->doc_id;
    $pid = $data->pid;
    $consult_id = $data->consult_id;
    $blood_pressure = $data->blood_pressure;
    $heart_rate = $data->heart_rate;
    $height = $data->height;
    $weight = $data->weight;
    $mc_price = $data->mc_price;
    $sql = "UPDATE tblconsult SET mc_date=:mc_date,doc_id=:doc_id,pid=:pid,consul_id=:consult_id,blood_pressure=:blood_pressure,heart_rate=:heart_rate,height=:height,weight=:weight,mc_price=:mc_price  where mc_id =:mc_id";
    $update = $conn->prepare($sql);
    $update->bindParam(':mc_date', $mc_date);
    $update->bindParam(':doc_id', $doc_id);
    $update->bindParam(':pid', $pid);
    $update->bindParam(':consult_id', $consult_id);
    $update->bindParam(':blood_pressure', $blood_pressure);
    $update->bindParam(':heart_rate', $heart_rate);
    $update->bindParam(':height', $height);
    $update->bindParam(':weight', $weight);
    $update->bindParam(':mc_price', $mc_price);
    $update->bindParam(':mc_id',$mc_id);

    if ($update->execute()) {
        echo json_encode("Data Update Success");
    } else {
        echo json_encode("Data Update Failed");
    }
}

//search
if ($_GET['data'] == "search_consult") {
    $mc_id = $data->mc_id;
    $docName = $data->docName;
    $pName = $data->pName;
    $sql = "SELECT * FROM vconsult WHERE mc_id=:mc_id OR DoctorName LIKE CONCAT('%',:docName,'%') OR PatientName LIKE CONCAT('%',:pName,'%')";
    $result = $conn->prepare($sql);
    $result->bindParam(':mc_id', $mc_id);
    $result->bindParam(':docName', $docName);
    $result->bindParam(':pName', $pName);
    $result->execute();
    while ($row = $result->fetch(PDO::FETCH_ASSOC)) {
        $consule[] = $row;
    }
    echo json_encode($consule??[]);
}

//delete
if ($_GET['data'] == "delete_consult") {
    $mc_id= $_GET['mc_id'];
    $sql = "DELETE FROM tblconsult WHERE mc_id=:mc_id";
    $delete = $conn->prepare($sql);
    $delete->bindParam(':mc_id', $mc_id);
    if ($delete->execute()) {
        echo json_encode("Delete Success");
    } else {
        echo json_encode("Delete Failed");
    }
}