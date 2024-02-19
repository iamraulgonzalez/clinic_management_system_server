<?php
require 'database/db.php';

header('Content-Type: application/json');
header("Access-Control-Allow-Origin: *");
$input = file_get_contents('php://input');
$data = json_decode($input);

//1-getalldata
if ($_GET["data"] == "get_nurse") {
    $sql = "SELECT * FROM tblnurse";
    $result = $conn->prepare($sql);
    $result->execute();
    while ($row = $result->fetch(PDO::FETCH_ASSOC)) {
        $nurse[] = $row;
    }
    echo json_encode($nurse ?? []);
}


// //3-add_doctor
if ($_GET["data"] == "add_nurse") {
    try{
    if ($data->first_name) {
        $firstname = $data->first_name;
        $lastname = $data->last_name;
        $sex = $data->sex;
        $dob = $data->dob;
        $blood= $data->blood;
        $mobile = $data->mobile;
        $email = $data->email;
        $address = $data->address;

        $sql = "INSERT INTO tblnurse(first_name,last_name,sex,dob,blood,mobile,email,address) values(:firstname,:lastname,:sex,:dob,:blood,:mobile,:email,:address);";
        $insert = $conn->prepare($sql);

        $insert->bindParam(':firstname', $firstname);
        $insert->bindParam(':lastname', $lastname);
        $insert->bindParam(':sex', $sex);
        $insert->bindParam(':dob', $dob);
        $insert->bindParam(':blood', $blood);
        $insert->bindParam(':mobile', $mobile);
        $insert->bindParam(':email', $email);
        $insert->bindParam(':address', $address);

        if ($insert->execute()) {
            echo json_encode("Insert Success");
        } else {
            echo json_encode("Insert Failed");
        }
    }else{
        echo json_encode("You Input Faild");
    }
}catch(Error){
    echo("Erro hz ov");
}
}

//update doctor
if ($_GET['data'] == "update_nurse") {
    $n_id = $data->n_id;
    $firstname = $data->first_name;
    $lastname = $data->last_name;
    $sex = $data->sex;
    $dob = $data->dob;
    $blood = $data->blood;
    $mobile = $data->mobile;
    $email = $data->email;
    $address = $data->address;

    $sql = "UPDATE tblnurse SET first_name=:firstname,last_name=:lastname,sex=:sex,dob=:dob,blood=:blood,mobile=:mobile,email=:email,address=:address where n_id=:n_id";
    $update = $conn->prepare($sql);
    $update->bindParam(':firstname', $firstname);
    $update->bindParam(':lastname', $lastname);
    $update->bindParam(':sex', $sex);
    $update->bindParam(':dob', $dob);
    $update->bindParam(':blood', $blood);
    $update->bindParam(':mobile', $mobile);
    $update->bindParam(':email', $email);
    $update->bindParam(':address', $address);
    $update->bindParam(':n_id', $n_id);

    if ($update->execute()) {
        echo json_encode("Data Update Success");
    } else {
        echo json_encode("Data Update Failed");
    }
}


//search
if ($_GET['data'] == "search_nurse") {
    $n_id = $data->n_id;
    $firstname = $data->first_name;
    $lastname = $data->last_name;
    $sql = "SELECT * FROM tblnurse WHERE n_id=:n_id OR first_name LIKE CONCAT('%',:firstname,'%') OR last_name LIKE CONCAT('%',:lastname,'%')";
    $result = $conn->prepare($sql);
    $result->bindParam(':n_id', $n_id);
    $result->bindParam(':firstname', $firstname);
    $result->bindParam(':lastname', $lastname);
    $result->execute();
    while ($row = $result->fetch(PDO::FETCH_ASSOC)) {
        $nurse[] = $row;
    }
    echo json_encode($nurse??[]);
}

//delete
if ($_GET['data'] == "delete_nurse") {
    $n_id = $_GET['n_id'];
    $sql = "DELETE FROM tblnurse WHERE n_id=:n_id";
    $delete = $conn->prepare($sql);
    $delete->bindParam(':n_id', $n_id);
    if ($delete->execute()) {
        echo json_encode("Delete Success");
    } else {
        echo json_encode("Delete Failed");
    }
}

if($_GET["data"] == "get_count"){
    $table = $data->table;
    $name = $data->name;
    $sql = "SELECT Count(*) as $name  FROM $table";
     $result = $conn->prepare($sql);
     $result->execute();
     $row=$result->fetch(PDO::FETCH_ASSOC);
    echo json_encode($row);
}