<?php
include('dbh.php');
session_start();

if(isset($_POST['productBtn'])) {
    $itemNumber = $_POST['itemNumber'];
    $itemName = $_POST['itemName'];
    $stock = $_POST['stock'];
    $price = $_POST['price'];
    $totalStock = $_POST['totalStock'];
    $photo = $_FILES['image']['name'];
    $upload = "upload/".$photo;


    if(!empty($itemNumber) && isset($itemName) && isset($stock) && isset($price) && isset($totalStock)){
        $itemNumber = filter_var($itemNumber, FILTER_SANITIZE_STRING);

        if(filter_var($stock, FILTER_VALIDATE_INT) === 0 || filter_var($stock, FILTER_VALIDATE_INT)) {
            // Stock validated
        } else {
            echo '<div class="alert alert-danger"><button class="close float-end" data-bs-dismiss="alert">&times;</button>validate stock</div>';
            exit();
        }

        if(filter_var($price, FILTER_VALIDATE_FLOAT) === 0.0 || filter_var($price, FILTER_VALIDATE_FLOAT)) {
            // Stock validated
        } else {
            echo '<div class="alert alert-danger"><button class="close float-end" data-bs-dismiss="alert">&times;</button>validate price</div>';
            exit();
        }

        if(filter_var($totalStock, FILTER_VALIDATE_INT) === 0 || filter_var($totalStock, FILTER_VALIDATE_INT)) {
            // Stock validated
        } else {
            echo '<div class="alert alert-danger"><button class="close float-end" data-bs-dismiss="alert">&times;</button>validate total stock</div>';
            exit();
        }

        if(empty($itemNumber)) {
            echo '<div class="alert alert-danger"><button class="close float-end" data-bs-dismiss="alert">&times;</button>Enter item number field</div>';
            exit();
        }

        if(empty($itemName)) {
            echo '<div class="alert alert-danger"><button class="close float-end" data-bs-dismiss="alert">&times;</button>Enter item name field</div>';
            exit();
        }

        if(empty($stock)) {
            echo '<div class="alert alert-danger"><button class="close float-end" data-bs-dismiss="alert">&times;</button>Enter stock field</div>';
            exit();
        }

        if(empty($price)) {
            echo '<div class="alert alert-danger"><button class="close float-end" data-bs-dismiss="alert">&times;</button>Enter item number field</div>';
            exit(0);
        }

        $sql = "INSERT INTO product(itemNumber, itemName, stock, price, totalStock, photo) VALUES(:itemNumber, :itemName, :stock, :price, :totalStock, :photo)";
        $stmt = $conn->prepare($sql);
        $stmt->execute([
            'itemNumber' => $itemNumber,
            'itemName' => $itemName,
            'stock' => $stock,
            'price' => $price,
            'totalStock' => $totalStock,
            'photo' => $upload
        ]);
        move_uploaded_file($_FILES['image']['tmp_name'], $upload);

        if($stmt) {
            $_SESSION['message'] = "Product added successfully";
            header("location:index.php");
            exit();
        } else {
            $_SESSION['message'] = "Product added failed";
            header("location:index.php");
            exit();
        }

        
    } else {
        echo '<div class="alert alert-danger"><button class="close float-end" data-bs-dismiss="alert">&times;</button>Enter all fields</div>';
        exit();
    }
}

if(isset($_GET['id'])) {
    $id = $_GET['id'];

    $sql = "SELECT * FROM product WHERE id = :id";
    $stmt = $conn->prepare($sql);
    $stmt->execute(['id'=>$id]);
    if($stmt->rowCount() > 0) {
        $row = $stmt->fetch(PDO::FETCH_ASSOC);
        $imagePath = $row['photo'];
        unlink($imagePath);
    }

    $sql = "DELETE FROM product WHERE id=:id";
    $stmt = $conn->prepare($sql);
    $stmt->execute(['id'=>$id]);

    if($stmt) {
        $_SESSION['message'] = "Product Deleted Successfully";
        header('location:index.php');
        exit();
    } else {
        $_SESSION['message'] = "Product Deleted Failed";
        header('location:index.php');
        exit();
    }
}



if(isset($_POST['updateBtn'])) {
    $itemNumber = $_POST['itemNumber'];
    $itemName = $_POST['itemName'];
    $stock = $_POST['stock'];
    $price = $_POST['price'];
    $totalStock = $_POST['totalStock'];
    $photo = $_POST['photo'];
    $oldimage = $_POST['oldimage'];
    $id = $_POST['id'];

    if(isset($_FILES['image']['name']) && ($_FILES['image']['name'] !=="" )){
        $newimage = 'upload/'.$_FILES['image']['name'];
        unlink($oldimage);
        move_uploaded_file($_FILES['image']['tmp_name'], $newimage);
    } else {
        $newimage = $oldimage;
    }

    $sql = "UPDATE product SET itemNumber = :itemNumber, itemName = :itemName, stock = :stock, price = :price, totalStock = :totalStock, photo = :photo WHERE id = :id";
    $stmt = $conn->prepare($sql);
    $stmt->execute([
        'itemNumber' => $itemNumber,
        'itemName' => $itemName,
        'stock' => $stock,
        'price' => $price,
        'totalStock' => $totalStock,
        'photo' => $newimage,
        'id' => $id
    ]);

    if($stmt) {
        $_SESSION['message'] = "Product updated successfully";
        header('location:index.php');
        exit();
    } else {
        $_SESSION['message'] = "Product updated failed";
        header('location:index.php');
        exit();
    }
}



// INSERT SALE
if(isset($_POST['saleBtn'])) {

    for($i=0;$i<count($_POST['itemNumber']);$i++) {
        $customerName = $_POST['customerName'];
        $date = date($_POST['date']);
        $itemNumber = $_POST['itemNumber'][$i];
        $itemName = $_POST['itemName'][$i];
        $quantity = $_POST['quantity'][$i];
        $price = $_POST['price'][$i];
        $total = $_POST['total'][$i];
        $stock = $_POST['stock'][$i];
        $grand_total = $_POST['grand_total'];

        // CHECK IF FILED IS NOT EMPTY
        if(!empty($customerName) && isset($date) && isset($itemNumber) && isset($itemName) && isset($quantity) && isset($price) && isset($total) && isset($stock)&& isset($grand_total)) {
            $itemNumber = filter_var($itemNumber, FILTER_SANITIZE_STRING);

            if(filter_var($quantity, FILTER_VALIDATE_INT) === 0 || filter_var($quantity, FILTER_VALIDATE_INT)) {
                // quantity validate
            } else {
                echo '<div class="alert alert-danger"><button class="close float-end" data-bs-dismiss="alert">&times;</button>Quantity not validated</div>';
                exit();
            }

            if(filter_var($stock, FILTER_VALIDATE_INT) === 0 || filter_var($stock, FILTER_VALIDATE_INT)) {
                // Stock validate
            } else {
                echo '<div class="alert alert-danger"><button class="close float-end" data-bs-dismiss="alert">&times;</button>Stock not validated</div>';
                exit();
            }

            if(filter_var($price, FILTER_VALIDATE_FLOAT) === 0.0 || filter_var($price, FILTER_VALIDATE_FLOAT)) {
                // Price Float
            } else {
                echo '<div class="alert alert-danger"><button class="close float-end" data-bs-dismiss="alert">&times;</button>Price not validated</div>';
                exit();
            }

            if(filter_var($total, FILTER_VALIDATE_FLOAT) === 0.0 || filter_var($total, FILTER_VALIDATE_FLOAT)) {
                // Total Float
            } else {
                echo '<div class="alert alert-danger"><button class="close float-end" data-bs-dismiss="alert">&times;</button>Total not validated</div>';
                exit();
            }
            if(filter_var($grand_total, FILTER_VALIDATE_FLOAT) === 0.0 || filter_var($grand_total, FILTER_VALIDATE_FLOAT)) {
                // Price Float
            } else {
                echo '<div class="alert alert-danger"><button class="close float-end" data-bs-dismiss="alert">&times;</button>Grand total not validated</div>';
                exit();
            }

            if($date == '') {
                echo '<div class="alert alert-danger"><button class="close float-end" data-bs-dismiss="alert">&times;</button>Enter date field</div>';
                exit();
            }

            if($customerName == '') {
                echo '<div class="alert alert-danger"><button class="close float-end" data-bs-dismiss="alert">&times;</button>Enter Customer name field</div>';
                exit();
            }

            if($itemNumber == '') {
                echo '<div class="alert alert-danger"><button class="close float-end" data-bs-dismiss="alert">&times;</button>Enter item number field</div>';
                exit();
            }

            if($itemName == '') {
                echo '<div class="alert alert-danger"><button class="close float-end" data-bs-dismiss="alert">&times;</button>Enter item name field</div>';
                exit();
            }

            if($date == '') {
                echo '<div class="alert alert-danger"><button class="close float-end" data-bs-dismiss="alert">&times;</button>Enter date field</div>';
                exit();
            }

            if($quantity == '') {
                echo '<div class="alert alert-danger"><button class="close float-end" data-bs-dismiss="alert">&times;</button>Enter quantity field</div>';
                exit();
            }

            $stockSql = "SELECT stock FROM product WHERE itemNumber = :itemNumber";
            $stockStmt = $conn->prepare($stockSql);
            $stockStmt->execute(['itemNumber' => $itemNumber]);
            if($stockStmt->rowCount() > 0) {
                $row = $stockStmt->fetch(PDO::FETCH_ASSOC);
                $currentStockInTable = $row['stock'];

                if($currentStockInTable <= 0) {
                    echo '<div class="alert alert-danger"><button class="close float-end" data-bs-dismiss="alert">&times;</button>No stock available, therefore cant make sale, try different product</div>';
                    exit();

                } elseif($currentStockInTable < $quantity) {
                    echo '<div class="alert alert-danger"><button class="close float-end" data-bs-dismiss="alert">&times;</button>Not enough stock, therefore cant make sale, try different product</div>';
                    exit();

                }else {
                    $newStock = $currentStockInTable-$quantity;
                    $updateSql = "UPDATE product SET stock = :stock WHERE itemNumber = :itemNumber";
                    $updateStmt = $conn->prepare($updateSql);
                    $updateStmt->execute(['stock' => $newStock, 'itemNumber' => $itemNumber]);

                    $sql = "INSERT INTO sale(customerName, date, itemNumber, itemName, quantity, price, total, stock, grand_total) VALUES(:customerName, :date, :itemNumber, :itemName, :quantity, :price, :total, :stock, :grand_total)";
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
                        'grand_total' => $grand_total
                    ]);
                    header('location:sale.php');

                    // if($stmt) {
                    //     $_SESSION['message'] = "Sale added successfully";
                    //     header("location:sale.php");
                    //     exit();
                    // } else {
                    //     $_SESSION['message'] = "Sale added failed";
                    //     header("location:sale.php");
                    //     exit();
                    // }
                }
            }


        } else {
                echo '<div class="alert alert-danger"><button class="close float-end" data-bs-dismiss="alert">&times;</button>Enter all fields</div>';
                exit();

        }
    }
}