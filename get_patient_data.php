<?php
require 'database/db.php';

header('Content-Type: application/json');
header("Access-Control-Allow-Origin: *");
$input = file_get_contents('php://input');
$data = json_decode($input);

//1-getalldata
if ($_GET["data"] == "get_patient") {
    $sql = "SELECT * FROM tblpatient";
    $result = $conn->prepare($sql);
    $result->execute();
    while ($row = $result->fetch(PDO::FETCH_ASSOC)) {
        $patient[] = $row;
    }
    echo json_encode($patient ?? []);
}

if ($_GET["data"] == "get_tod") {
    $sql = "SELECT * FROM tbltod";
    $result = $conn->prepare($sql);
    $result->execute();
    while ($row = $result->fetch(PDO::FETCH_ASSOC)) {
        $tod[] = $row;
    }
    echo json_encode($tod ?? []);
}

// //3-add_doctor
if ($_GET["data"] == "add_patient") {
    if ($data->first_name) {

        $firstname = $data->first_name;
        $lastname = $data->last_name;
        $sex = $data->sex;
        $dob = $data->dob;
        $blood = $data->blood;
        $mobile = $data->mobile;
        $email = $data->email;
        $address = $data->address;
        $remarks = $data->remarks;

        echo $remarks;
        $sql = "INSERT INTO tblpatient(first_name,last_name,sex,dob,blood,mobile,email,address,remarks) values(:firstname,:lastname,:sex,:dob,:blood,:mobile,:email,:address,:remarks);";
        $insert = $conn->prepare($sql);

        $insert->bindParam(':firstname', $firstname);
        $insert->bindParam(':lastname', $lastname);
        $insert->bindParam(':sex', $sex);
        $insert->bindParam(':dob', $dob);
        $insert->bindParam(':blood', $blood);
        $insert->bindParam(':mobile', $mobile);
        $insert->bindParam(':email', $email);
        $insert->bindParam(':address', $address);
        $insert->bindParam(':remarks', $remarks);

        if ($insert->execute()) {
            echo json_encode("Insert Success");
        } else {
            echo json_encode("Insert Failed");
        }
    }
}

//update doctor
if ($_GET['data'] == "update_patient") {
    $pid = $data->pid;
    $firstname = $data->first_name;
    $lastname = $data->last_name;
    $sex = $data->sex;
    $dob = $data->dob;
    $blood = $data->blood;
    $mobile = $data->mobile;
    $email = $data->email;
    $address = $data->address;
    $remarks = $data->remarks;

    $sql = "UPDATE tblpatient SET first_name=:firstname,last_name=:lastname,sex=:sex,dob=:dob,blood=:blood,mobile=:mobile,email=:email,address=:address,remarks=:remarks where pid=:pid";
    $update = $conn->prepare($sql);
    $update->bindParam(':firstname', $firstname);
    $update->bindParam(':lastname', $lastname);
    $update->bindParam(':sex', $sex);
    $update->bindParam(':dob', $dob);
    $update->bindParam(':blood', $blood);
    $update->bindParam(':mobile', $mobile);
    $update->bindParam(':email', $email);
    $update->bindParam(':address', $address);
    $update->bindParam(':remarks', $remarks);
    $update->bindParam(':pid', $pid);

    if ($update->execute()) {
        echo json_encode("Data Update Success");
    } else {
        echo json_encode("Data Update Failed");
    }
}


//search
if ($_GET['data'] == "search_patient") {
    $pid = $data->pid;
    $firstname = $data->first_name;
    $lastname = $data->last_name;
    $sql = "SELECT * FROM tblpatient WHERE pid=:pid OR first_name LIKE CONCAT('%',:firstname,'%') OR last_name LIKE CONCAT('%',:lastname,'%')";
    $result = $conn->prepare($sql);
    $result->bindParam(':pid', $pid);
    $result->bindParam(':firstname', $firstname);
    $result->bindParam(':lastname', $lastname);
    $result->execute();
    while ($row = $result->fetch(PDO::FETCH_ASSOC)) {
        $patient[] = $row;
    }
    echo json_encode($patient ?? []);
}

//delete
if ($_GET['data'] == "delete_patient") {
    $pid= $_GET['pid'];
    $sql = "DELETE FROM tblpatient WHERE pid=:pid";
    $delete = $conn->prepare($sql);
    $delete->bindParam(':pid', $pid);
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