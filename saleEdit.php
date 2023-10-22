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
            <li class="nav-item me-3"><a href="index.php" class="nav-link">Product</a></li>
            <li class="nav-item me-3"><a href="#" class="nav-link">Sale</a></li>
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
        <div class="col-md-5">
            <div class="card card-outline-secondary">
                <div class="card-body">
                    <h3 class="mb-4">Update Sale details</h3>

                    <?php
                    if(isset($_GET['id'])) {
                        $id = $_GET['id'];

                        $sql = "SELECT * FROM sale WHERE id = :id";
                        $stmt = $conn->prepare($sql);
                        $stmt->execute(['id'=>$id]);
                        $result = $stmt->fetch(PDO::FETCH_ASSOC);
                    } 
                    ?>

                    <form action="saleUpdate.php" method="post" enctype="multipart/form-data">
                        <div class="row">
                            <div class="col-md-10">
                                <input type="hidden" name="id" value="<?=$result['id']?>">
                                <div class="group-form row mx-auto mb-2">
                                    <label class="col-md-6" align="right">Customer Name</label>
                                    <div class="col-md-6">
                                        <input type="text" name="customerName" class="form-control form-control-sm" placeholder="Enter cus name" id="customerName" value="<?=$result['customerName'];?>">
                                    </div>
                                </div>
                                <div class="group-form row mx-auto mb-2">
                                    <label class="col-md-6" align="right">Date</label>
                                    <div class="col-md-6">
                                        <input type="date" name="date" class="form-control form-control-sm" id="date" value="<?=$result['date'];?>">
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="card">
                            <div class="card-body" style="box-shadow: 0 1px 5px rgba(104, 104, 104, 0.8);">
                                <div class="container">
                                    <table class="table table-sm">
                                    <thead>
                                        <tr>
                                            <th>Item No</th>
                                            <th>Name</th>
                                            <th>Qty</th>
                                            <th>Price</th>
                                            <th>Total</th>
                                            <th>Tot Stock</th>
                                            <th>Action</th>
                                        </tr>
                                    </thead>
                                    <tbody id="tableRow">
                                        <tr>
                                            <td><input type="text" name="itemNumber" class="form-control form-control-sm itemNumber" id="itemNumber" value="<?=$result['itemNumber'];?>"></td>
                                            
                                            <td><input type="text" name="itemName" class="form-control form-control-sm itemName" id="itemName" value="<?=$result['itemName'];?>"></td>

                                            <td><input type="text" name="quantity" class="form-control form-control-sm quantity" id="quantity" value="<?=$result['quantity'];?>"></td>

                                            <td><input type="text" name="price" class="form-control form-control-sm price" id="price" value="<?=$result['price'];?>"></td>

                                            <td><input type="text" name="total" class="form-control form-control-sm total" id="total" value="<?=$result['total'];?>"></td>

                                            <td><input type="text" name="stock" class="form-control form-control-sm stock" id="stock" value="<?=$result['stock'];?>"></td>

                                            <td><button type="button" class="btn btn-primary btn-sm" id="addRow"><i class="fa fa-plus fa-sm"></i></button></td>
                                        </tr>
                                    </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                            <center style="padding: 10px;">
                                <div class="group-form row">
                                    <label class="col-md-4" align="right"><b>Grand Total</b></label>
                                    <div class="col-md-5">
                                        <input type="text" class="form-control form-control-sm" name="grand_total" id="grand_total" value="<?=$result['grand_total'];?>">
                                    </div>
                                </div>
                            </center>
                            <input type="submit" name="updateSaleBtn" class="btn btn-success btn-sm mt-2" value="Update Invoice" style="width: 150px;">
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
    
<script>
    $(document).ready(function(){
        $('#tableRow').on('keyup', '.quantity', function(e){
            e.preventDefault();
            var quantity = Number($(this).val());
            var price = Number($(this).closest('tr').find('.price').val());
            $(this).closest('tr').find('.total').val(quantity*price);
            grand_total()
        })

        $('#tableRow').on('keyup', '.price', function(e){
            e.preventDefault();
            var price = Number($(this).val());
            var quantity = Number($(this).closest('tr').find('.quantity').val());
            $(this).closest('tr').find('.total').val(price*quantity);
            grand_total()
        })

        function grand_total() {
            var tot=0;
            $(".total").each(function(){
                tot+=Number($(this).val());
            })
            $('#grand_total').val(tot);
        }
        
    })

    function autofill(id) {
        var itemNumber = $(id).val();
        $.ajax({
            url: 'autofill.php',
            data: "itemNumber="+itemNumber,
            success: function(response) {
                data = JSON.parse(response);
                $(id).parent().parent().children().children('.itemName').val(data.itemName);
                $(id).parent().parent().children().children('.price').val(data.price);
                $(id).parent().parent().children().children('.stock').val(data.stock);
            }
        })
    }
</script>
</body>
</html>