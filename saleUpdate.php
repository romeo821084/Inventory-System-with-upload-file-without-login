<?php 
include('dbh.php');

if(isset($_POST['updateSaleBtn'])) {
    $customerName = $_POST['customerName'];
    $date = date($_POST['date']);
    $itemNumber = $_POST['itemNumber'];
    $itemName = $_POST['itemName'];
    $quantity = $_POST['quantity'];
    $price = $_POST['price'];
    $total = $_POST['total'];
    $stock = $_POST['stock'];
    $grand_total = $_POST['grand_total'];
    $id = $_POST['id'];

    $sql = "UPDATE sale SET customerName=:customerName, date=:date, itemNumber=:itemNumber, itemName=:itemName, quantity=:quantity, price=:price, total=:total, stock=:stock, grand_total=:grand_total WHERE id = :id";
    $stmt = $conn->prepare($sql);
    $stmt->execute([
        'customerName' => $customerName,
        'date' => $date,
        'itemNumber' => $itemNumber,
        'itemName' => $itemName,
        'quantity' => $quantity,
        'price' => $price,
        'total' => $total,
        'stock' => $stock,
        'grand_total' => $grand_total,
        'id' => $id
    ]);
    if($stmt) {
        $_SESSION['message'] = 'Sale updated successfully';
        header('location:sale.php');
        exit();
    } else {
        $_SESSION['message'] = 'Sale updated failed';
        header('location:sale.php');
        exit();
    }
}