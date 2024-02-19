<?php
require 'database/db.php';

header('Content-Type: application/json');
header("Access-Control-Allow-Origin: *");
$input = file_get_contents('php://input');
$data = json_decode($input);

//1-getalldata
if ($_GET["data"] == "get_app") {
    $sql = "SELECT * FROM vappointment";
    $result = $conn->prepare($sql);
    $result->execute();
    while ($row = $result->fetch(PDO::FETCH_ASSOC)) {
        $appointment[] = $row;
    }
    echo json_encode($appointment ?? []);
}

if ($_GET["data"] == "add_appointment") {
    if ($data->doc_id) {

        $doc_id = $data->doc_id;
        $pid = $data->pid;
        $a_date = $data->a_date;
        $discription = $data->discription;

        $sql = "INSERT INTO appointment(doc_id,pid,a_date,discription) values(:doc_id,:pid,:a_date,:discription);";
        $insert = $conn->prepare($sql);

        $insert->bindParam(':doc_id', $doc_id);
        $insert->bindParam(':pid', $pid);
        $insert->bindParam(':a_date', $a_date);
        $insert->bindParam(':discription', $discription);

        if ($insert->execute()) {
            echo json_encode("Insert Success");
        } else {
            echo json_encode("Insert Failed");
        }
    }
}

if ($_GET['data'] == "update_appointment") {
    $a_id = $data->a_id;
    $doc_id = $data->doc_id;
    $pid = $data->pid;
    $a_date = $data->a_date;
    $discription = $data->discription;
    $sql = "UPDATE appointment SET doc_id=:doc_id,pid=:pid,a_date=:a_date,discription=:discription where a_id =:a_id";
    $update = $conn->prepare($sql);
    $update->bindParam(':doc_id', $doc_id);
    $update->bindParam(':pid', $pid);
    $update->bindParam(':a_date', $a_date);
    $update->bindParam(':discription', $discription);
    $update->bindParam(':a_id', $a_id);

    if ($update->execute()) {
        echo json_encode("Data Update Success");
    } else {
        echo json_encode("Data Update Failed");
    }
}

//search
if ($_GET['data'] == "search_appointment") {
    $a_id = $data->a_id;
    $docName = $data->docName;
    $pName = $data->pName;
    $sql = "SELECT * FROM vappointment WHERE a_id=:a_id OR DoctorName LIKE CONCAT('%',:docName,'%') OR PatientName LIKE CONCAT('%',:pName,'%')";
    $result = $conn->prepare($sql);
    $result->bindParam(':a_id', $a_id);
    $result->bindParam(':docName', $docName);
    $result->bindParam(':pName', $pName);
    $result->execute();
    while ($row = $result->fetch(PDO::FETCH_ASSOC)) {
        $appointment[] = $row;
    }
    echo json_encode($appointment??[]);
}

//delete
if ($_GET['data'] == "delete_appointment") {
    $a_id= $_GET['a_id'];
    $sql = "DELETE FROM appointment WHERE a_id=:a_id";
    $delete = $conn->prepare($sql);
    $delete->bindParam(':a_id', $a_id);
    if ($delete->execute()) {
        echo json_encode("Delete Success");
    } else {
        echo json_encode("Delete Failed");
    }
}