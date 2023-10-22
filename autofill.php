<?php 
include('dbh.php');

$itemNumber = $_GET['itemNumber'];
$sql = "SELECT * FROM product WHERE itemNumber = :itemNumber";
$stmt = $conn->prepare($sql);
$stmt->execute(['itemNumber' => $itemNumber]);
while($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
    $data = array(
        'itemName' => $row['itemName'],
        'price' => $row['price'],
        'stock' => $row['stock']
    );
    echo json_encode($data);
}