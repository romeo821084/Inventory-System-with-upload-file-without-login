<?php
include('dbh.php');
session_start(); 
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Products</title>
    <link rel="stylesheet" href="assets/bootstrap-dis/css/bootstrap.css">
    <script src="assets/bootstrap-dis/js/bootstrap.js"></script>
    <link rel="stylesheet" href="assets/fontawesome-icons/css/all.css">
    <script src="assets/jquery/jquery-3.6.3.js"></script>
    <link rel="stylesheet" href="assets/datatable/datatables.css">
    <script src="assets/datatable/datatables.js"></script>
</head>
<body>

<nav class="navbar navbar-expand-md navbar-dark bg-dark px-4">
    <a href="" class="navbar-brand">Rose Tech Multimedia</a>
    <button class="navbar-toggler" data-bs-toggle="collapse" data-bs-target="#navbarCollapse">
        <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="navbarCollapse">
        <ul class="navbar-nav">
            <li class="nav-item me-3"><a href="" class="nav-link">Product</a></li>
            <li class="nav-item me-3"><a href="" class="nav-link">Sale</a></li>
        </ul>
    </div>
</nav>

<?php if(isset($_SESSION['message'])):?>
    <h5 class="alert alert-success"><?= $_SESSION['message']?> <button class="close float-end" data-bs-dismiss="alert">&times;</button> 
    </h5>
<?php endif;
unset($_SESSION['message']); 
?>

<div class="container mt-4">
    <?php
    if(isset($_GET['id'])) {
        $id = $_GET['id'];

        $sql = "SELECT * FROM product WHERE id = :id";
        $stmt = $conn->prepare($sql);
        $stmt->execute(['id'=>$id]);
        $result = $stmt->fetch(PDO::FETCH_ASSOC);
    }
    ?>
    <div class="row">
        <div class="col-md-4">
            <div class="card card-outline-secondary">
                <div class="card-body">
                    <h3 class="mb-4">Enter product fields</h3>
                    <form action="action.php" method="post" enctype="multipart/form-data">
                        <input type="hidden" name="id" value="<?= $result['id']?>">
                        <div class="group-form mb-3">
                            <input type="text" name="itemNumber" id="itemNumber" class="form-control form-control-sm" value="<?=$result['itemNumber']?>" placeholder="Item number">
                        </div>
                        <div class="group-form mb-3">
                            <input type="text" name="itemName" class="form-control form-control-sm" placeholder="Item name" id="itemName" value="<?=$result['itemName']?>">
                        </div>
                        <div class="group-form mb-3">
                            <input type="text" name="stock" class="form-control form-control-sm stock" placeholder="Stock" id="stock" value="<?=$result['stock']?>">
                        </div>
                        <div class="group-form mb-3">
                            <input type="text" name="price" class="form-control form-control-sm" placeholder="price" id="price" value="<?=$result['price']?>">
                        </div>
                        <div class="group-form mb-3">
                            <input type="text" name="totalStock" class="form-control form-control-sm totalStock" placeholder="Total stock" id="totalStock" value="<?=$result['totalStock']?>">
                        </div>
                        <div class="group-form mb-3">
                            <input type="hidden" name="oldimage" id="oldimage" value="<?=$result['photo']?>">
                           <input type="file" name="image" class="custom-image">
                           <img src="<?= $result['photo']?>" alt="" width="120px" class="img-thumbnail">
                        </div>
                        <input type="submit" name="updateBtn" value="Update product" class="btn btn-success btn-sm" style="width: 150px;">
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
    
</body>
</html>