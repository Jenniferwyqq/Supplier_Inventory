<?php

session_start();

$mysqli = new mysqli('localhost', 'root', '123', 'top_shoe') or die(mysqli_error($mysqli));

$id = 0;
$update = false;
$name = '';
$brand = '';

if (isset($_POST['save'])){
    $name = $_POST['name'];
    $brand = $_POST['brand'];
    
    $mysqli->query("INSERT INTO data (name, brand) VALUES('$name', '$brand')") or
            die($mysqli->error);
        
    $_SESSION['message'] = "Record has been saved!";
    $_SESSION['msg_type'] = "success";
    
    header("brand: index.php");
    
}

if (isset($_GET['delete'])){
    $id = $_GET['delete'];
    $mysqli->query("DELETE FROM data WHERE id=$id") or die($mysqli->error());
    
    $_SESSION['message'] = "Record has been deleted!";
    $_SESSION['msg_type'] = "danger";
    
    header("brand: index.php");
}

if (isset($_GET['edit'])){
    $id = $_GET['edit'];
    $update = true;
    $result = $mysqli->query("SELECT * FROM data WHERE id=$id") or die($mysqli->error());
    if (count($result)==1){
        $row = $result->fetch_array();
        $name = $row['name'];
        $brand = $row['brand'];
    }
}

if (isset($_POST['update'])){
    $id = $_POST['id'];
    $name = $_POST['name'];
    $brand = $_POST['brand'];
    
    $mysqli->query("UPDATE data SET name='$name', brand='$brand' WHERE id=$id") or
            die($mysqli->error);
    
    $_SESSION['message'] = "Record has been updated!";
    $_SESSION['msg_type'] = "warning";
    
    header('brand: index.php');
}