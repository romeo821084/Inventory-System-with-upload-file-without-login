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
            <li class="nav-item me-3"><a href="#" class="nav-link">Product</a></li>
            <li class="nav-item me-3"><a href="sale.php" class="nav-link">Sale</a></li>
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
    <div class="row">
        <div class="col-md-4">
            <div class="card card-outline-secondary">
                <div class="card-body">
                    <h3 class="mb-4">Enter product fields</h3>
                    <form action="action.php" method="post" enctype="multipart/form-data">
                        <div class="group-form mb-3">
                            <input type="text" name="itemNumber" class="form-control form-control-sm" placeholder="Item number">
                        </div>
                        <div class="group-form mb-3">
                            <input type="text" name="itemName" class="form-control form-control-sm" placeholder="Item name">
                        </div>
                        <div class="group-form mb-3">
                            <input type="text" name="stock" class="form-control form-control-sm" placeholder="Stock">
                        </div>
                        <div class="group-form mb-3">
                            <input type="text" name="price" class="form-control form-control-sm" placeholder="price">
                        </div>
                        <div class="group-form mb-3">
                            <input type="text" name="totalStock" class="form-control form-control-sm" placeholder="Total stock">
                        </div>
                        <div class="group-form mb-3">
                           <input type="file" name="image" class="custom-image">
                        </div>
                        <input type="submit" name="productBtn" value="Add product" class="btn btn-success btn-sm" style="width: 150px;">
                    </form>
                </div>
            </div>
        </div>
        <div class="col-md-8">
            <div class="card card-outline-secondary">
                <div class="card-body">
                    <h3 class="mb-4">Product database</h3>
                    <table align="center" class="table table-striped table-sm table-responsive table-bordered align-middle" id="myTable">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>Item Number</th>
                                <th>Item Name</th>
                                <th>Stock</th>
                                <th>Price</th>
                                <th>Total Stock</th>
                                <th>Photo</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            $sql = "SELECT * FROM product";
                            $stmt = $conn->prepare($sql);
                            $stmt->execute();
                            $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
                            if($result) {
                                foreach($result as $row) {
                                    ?>
                                    <tr>
                                        <td><?= $row['id'];?></td>
                                        <td><?= $row['itemNumber'];?></td>
                                        <td><?= $row['itemName'];?></td>
                                        <td><?= $row['stock'];?></td>
                                        <td><?= $row['price'];?></td>
                                        <td><?= $row['totalStock'];?></td>
                                        <td><img src="<?=$row['photo']?>" alt="" width="50"></td>
                                        <td>
                                            <a href="" title="View product details" class="text-success"><i class="fa fa-info-circle fa-lg"></i></a>&nbsp;&nbsp;

                                            <a href="edit.php?id=<?= $row['id']?>" title="Edit product details" class="text-primary"><i class="fa fa-edit fa-lg"></i></a>&nbsp;&nbsp;

                                            <a href="action.php?id=<?= $row['id'];?>" title="Delete product details" onclick="return confirm('are you sure? deleted cant be revert')" class="text-danger"><i class="fa fa-trash-alt fa-lg"></i></a>&nbsp;&nbsp;
                                        </td>
                                    </tr>
                                    <?php
                                }
                            } 
                            ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
    
<script>
    $(document).ready(function(){
        $("#myTable").DataTable();
    })
</script>
</body>
</html>