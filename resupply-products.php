<?php
    session_start();
    require_once 'includes/connection.php';
    if(!isset($_SESSION['id']))
    {
        header("location:login.php");
    }
?>
<?php
    function reOrderProducts()
    {
        $conn = db_connect();
        $sqlReOrder = "SELECT * FROM products WHERE (product_qty - Sold_quantity) <= 5 ";
        $sqlReOrderResult = $conn->query($sqlReOrder);
        if ($sqlReOrderResult->num_rows > 0) {
            while ($rows = $sqlReOrderResult->fetch_assoc()) {
                $productsForReOrder[] = $rows;
            }
            return $productsForReOrder;
        }else {
            return 0;
        }
    }
    $dispProductsForReOrder = reOrderProducts();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Re-Order Products</title>
    <!-- CSS only -->
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0-beta1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-0evHe/X+R7YkIZDRvuzKMRqM+OrBnVFBL6DOitfPri4tjfHxaWutUpFmBp4vmVor" crossorigin="anonymous">

<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css" integrity="sha512-KfkfwYDsLkIlwQp6LFnl8zNdLGxu9YAA1QvwINks4PhcElQSvqcyVLLD9aMhXd13uQjoXtEKNosOWaZqXgel0g==" crossorigin="anonymous" referrerpolicy="no-referrer" />
</head>
<body>
<nav class="navbar navbar-expand-lg bg-danger text-white">
            
            <div class="container-fluid">
                    <div class="col">
                        <h2 class="display-1"><i class="fa-solid fa-truck-droplet"></i> Resupply</h2>
                    </div>
                    <div class="col">
                        <ul class="navbar-nav justify-content-end fs-lg">
                            
                        <li class="nav-item">
                            <a href="view-products.php" class="nav-link btn btn-success-outline p-3 fs-3 text-white text-decoration-none"><i class="fa-solid fa-house-user"></i> Home</a>
                        </li>
                        <li class="nav-item">
                            <a href="add-products.php" class="nav-link btn btn-success-outline p-3 fs-3 text-white text-decoration-none"><i class="fa-solid fa-file-circle-plus"></i> Add Product</a>
                        </li>
                        <li class="nav-item">
                            <a href="view-products.php" class="nav-link btn btn-success-outline p-3 fs-3 text-white text-decoration-none"><i class="fa-solid fa-eye"></i> View Products</a>
                        </li>
                        <li class="nav-item">
                            <a href="logout.php" class="nav-link btn btn-success-outline p-3 fs-3 text-white text-decoration-none">Logout <i class="fa-solid fa-right-from-bracket"></i></a>
                        </li>
                        </ul>
                    </div>
            </div>
    </nav>
    <div class="container bg-light mt-5 p-5">
        <p class="text-start">IMPORTANT: The remaining balance of the following products are below 5. Please consider re-order.</p>
            <table class="table table-striped table-hover w-100">
                <thead class="bg-dark text-white text-center">
                    <th>ID</th>
                    <th>Category</th>
                    <th>Name</th>
                    <th>Description</th>
                    <th>Balance</th>
                    <th>Unit Price</th>
                    <th>Qty Sold</th>
                    <th></th>
                </thead>
                <tbody>
                    <?php
                        if (empty($dispProductsForReOrder)) {
                    ?>
                        <tr>
                            <td colspan="8" class="text-danger">No products to display</td>
                        </tr>
                    <?php      
                        }else {
                            foreach ($dispProductsForReOrder as $prd) {
                                $forOrderNow = $prd['product_qty'] - $prd['Sold_quantity'];
                    ?>
                        <tr class="text-center">
                            <td><?=$prd['product_id']?></td>
                            <td><?=$prd['product_category']?></td>
                            <td><?=$prd['product_name']?></td>
                            <td><?=$prd['product_description']?></td>
                            <td><?=$forOrderNow; ?></td>
                            <td><?=$prd['unit_price']?></td>
                            <td><?=$prd['Sold_quantity']?></td>  
                        </tr>  
                    <?php
                            }
                        }
                    ?>
                </tbody>
            </table>
    </div>
    

<?php include_once 'footer.php';?>
<!-- JavaScript Bundle with Popper -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0-beta1/dist/js/bootstrap.bundle.min.js" integrity="sha384-pprn3073KE6tl6bjs2QrFaJGz5/SUsLqktiwsUTF55Jfv3qYSDhgCecCxMW52nD2" crossorigin="anonymous"></script>
</body>
</html>