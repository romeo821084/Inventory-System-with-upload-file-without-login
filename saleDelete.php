<?php
include('dbh.php');
session_start();

if(isset($_GET['id'])) {
    $id = $_GET['id'];

    $sql = "DELETE FROM sale WHERE id=:id";
    $stmt = $conn->prepare($sql);
    $stmt->execute(['id'=>$id]);

    if($stmt) {
        $_SESSION['message'] = "Product Deleted Successfully";
        header('location:sale.php');
        exit();
    } else {
        $_SESSION['message'] = "Product Deleted Failed";
        header('location:sale.php');
        exit();
    }
}
