<?php
require 'database/db.php';

header('Content-Type: application/json');
header("Access-Control-Allow-Origin: *");
$input = file_get_contents('php://input');
$data = json_decode($input);

//1-getalldata
if ($_GET["data"] == "get_doctor") {
    $sql = "SELECT * FROM tbldoctor";
    $result = $conn->prepare($sql);
    $result->execute();
    while ($row = $result->fetch(PDO::FETCH_ASSOC)) {
        $doctor[] = $row;
    }
    echo json_encode($doctor ?? []);
}


// //3-add_doctor
if ($_GET["data"] == "add_doctor") {
    if ($data->first_name) {

        $firstname = $data->first_name;
        $lastname = $data->last_name;
        $sex = $data->sex;
        $dob = $data->dob;
        $bloodgroup = $data->blood_group;
        $mobile = $data->mobile;
        $email = $data->email;
        $address = $data->address;

        $sql = "insert into tbldoctor(first_name,last_name,sex,dob,blood_group,mobile,email,address) values(:firstname,:lastname,:sex,:dob,:bloodgroup,:mobile,:email,:address);";
        $insert = $conn->prepare($sql);

        $insert->bindParam(':firstname', $firstname);
        $insert->bindParam(':lastname', $lastname);
        $insert->bindParam(':sex', $sex);
        $insert->bindParam(':dob', $dob);
        $insert->bindParam(':bloodgroup', $bloodgroup);
        $insert->bindParam(':mobile', $mobile);
        $insert->bindParam(':email', $email);
        $insert->bindParam(':address', $address);

        if ($insert->execute()) {
            echo json_encode("Insert Success");
        } else {
            echo json_encode("Insert Failed");
        }
    }
}

//update doctor
if ($_GET['data'] == "update_doctor") {
    $docId = $data->doc_id;
    $firstname = $data->first_name;
    $lastname = $data->last_name;
    $sex = $data->sex;
    $dob = $data->dob;
    $bloodgroup = $data->blood_group;
    $mobile = $data->mobile;
    $email = $data->email;
    $address = $data->address;
    $sql = "UPDATE tbldoctor SET first_name=:firstname,last_name=:lastname,sex=:sex,dob=:dob,blood_group=:bloodgroup,mobile=:mobile,email=:email,address=:address where doc_id =:docId";
    $update = $conn->prepare($sql);
    $update->bindParam(':firstname', $firstname);
    $update->bindParam(':lastname', $lastname);
    $update->bindParam(':sex', $sex);
    $update->bindParam(':dob', $dob);
    $update->bindParam(':bloodgroup', $bloodgroup);
    $update->bindParam(':mobile', $mobile);
    $update->bindParam(':email', $email);
    $update->bindParam(':address', $address);
    $update->bindParam(':docId', $docId);

    if ($update->execute()) {
        echo json_encode("Data Update Success");
    } else {
        echo json_encode("Data Update Failed");
    }
}


//search
if ($_GET['data'] == "search_doctor") {
    $docId = $data->doc_id;
    $firstname = $data->first_name;
    $lastname = $data->last_name;
    $sql = "SELECT * FROM tbldoctor WHERE doc_id=:docId OR first_name LIKE CONCAT('%',:firstname,'%') OR last_name LIKE CONCAT('%',:lastname,'%')";
    $result = $conn->prepare($sql);
    $result->bindParam(':docId', $docId);
    $result->bindParam(':firstname', $firstname);
    $result->bindParam(':lastname', $lastname);
    $result->execute();
    while ($row = $result->fetch(PDO::FETCH_ASSOC)) {
        $doctor[] = $row;
    }
    echo json_encode($doctor??[]);
}

//delete
if ($_GET['data'] == "delete_doctor") {
     $doc_id= $_GET['doc_id'];
    // $doc_id = $data->id;
    $sql = "DELETE FROM tbldoctor WHERE doc_id=:doc_id";
    $delete = $conn->prepare($sql);
    $delete->bindParam(':doc_id', $doc_id);
    if ($delete->execute()) {
        echo json_encode("Delete Success");
    } else {
        echo json_encode("Delete Failed");
    }
}

if($_GET["data"] =="get_count"){
    $table = $data->table;
    $name = $data->name;
    $sql = "SELECT Count(*) as $name  FROM $table";
     $result = $conn->prepare($sql);
     $result->execute();
     $row=$result->fetch(PDO::FETCH_ASSOC);
    echo json_encode($row);
}

//3-get_graph
if ($_GET["data"] == "get_doctor_bygender") {
    $sql = "SELECT * FROM vdoctor";
    $result = $conn->prepare($sql);
    $result->execute();
    while ($row = $result->fetch(PDO::FETCH_ASSOC)) {
        $doctor[] = $row;
    }
    echo json_encode($doctor ?? []);
}