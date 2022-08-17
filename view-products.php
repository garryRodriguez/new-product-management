<?php
    session_start();
    require_once 'includes/connection.php';

    if(!isset($_SESSION['id']))
    {
        header("location:login.php");
    }
    
    function displayAllProducts(){
        $conn = db_connect();

        $sql = "SELECT * FROM products";
        $sqlResult = $conn->query($sql);
        if ($sqlResult->num_rows > 0) {
            while ($row = $sqlResult->fetch_assoc()) {
                $allProducts[] = $row;
            }
            return $allProducts;
        }else {
            return 0;
        }
    }
    $disp = displayAllProducts();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>View Products</title>
    <!-- CSS only -->
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0-beta1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-0evHe/X+R7YkIZDRvuzKMRqM+OrBnVFBL6DOitfPri4tjfHxaWutUpFmBp4vmVor" crossorigin="anonymous">

<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css" integrity="sha512-KfkfwYDsLkIlwQp6LFnl8zNdLGxu9YAA1QvwINks4PhcElQSvqcyVLLD9aMhXd13uQjoXtEKNosOWaZqXgel0g==" crossorigin="anonymous" referrerpolicy="no-referrer" />
<style>
    #test{
        position: relative;
    }
    #child-div{
        position: absolute;
        top: 140px
    }
</style>
</head>
<body>
    <div class="container-fluid" id="test">
        <nav class="navbar navbar-expand-lg bg-info text-white">
            <div class="col">
                <h2 class="display-1"><i class="fa-solid fa-list"></i> Product Lists</h2>
            </div>
            <div class="col mx-2">
                <ul class="navbar-nav justify-content-end fs-lg">                    
                    <li class="nav-item">
                        <a href="order-products.php" class="nav-link btn btn-success-outline p-3 fs-3 text-white text-decoration-none"><i class="fa-solid fa-house-user"></i> Home</a>
                    </li>
                    <li class="nav-item">
                        <a href="sales.php" class="nav-link btn btn-success-outline p-3 fs-3 text-white text-decoration-none"><i class="fa-solid fa-coins"></i> Sales</a>
                    </li>
                    <li class="nav-item">
                        <a href="#" class="nav-link btn btn-success-outline p-3 fs-3 text-white text-decoration-none"><i class="fa-solid fa-chart-line"></i> Reports</a>
                    </li>
                    <li class="nav-item">
                        <a href="#" class="nav-link btn btn-success-outline p-3 fs-3 text-white text-decoration-none"><i class="fa-solid fa-truck-field"></i> Suppliers</a>
                    </li>
                    <li class="nav-item">
                        <a href="logout.php" class="nav-link btn btn-success-outline p-3 fs-3 text-white text-decoration-none">Logout <i class="fa-solid fa-right-from-bracket"></i></a>
                    </li>
                </ul>
            </div>
        </nav>
    
        <div class="container-fluid bg-light" id="child-div">
            <div class="row mx-2">
                <div class="col p-2">
                    <a href="add-products.php" class="btn btn-primary fs-1 w-100"><i class="fa-solid fa-plus"></i> Add Products</a>
                </div>
                <div class="col p-2">
                    <a href="add-category.php" class="btn btn-success fs-1 w-100"><i class="fa-solid fa-plus"></i> Add Categories</a>
                </div>
                <div class="col p-2">
                    <a href="order-products.php" class="btn btn-secondary fs-1 w-100"><i class="fa-solid fa-cart-shopping"></i> Buy Product</a>
                </div>
                <div class="col p-2">
                    <a href="resupply-products.php" class="btn btn-warning fs-1 w-100"><i class="fa-solid fa-truck-droplet"></i> Re-order Products</a>
                </div>
            </div>
        </div>
    </div>
<main>
    <div class="container-fluid mt-5 p-2 fs-5" style="height: 800px; overflow-y: scroll; overflow-x: hidden;">
        <!-- <caption>Lists of Products</caption> -->
        <br>
            <table class="table table-striped table-hover mt-3 w-100">
                <br>
                <thead class="bg-dark text-white text-center" style="position: sticky; top: 50px;">
                        <th>ID</th>
                        <th>Category</th>
                        <th>Product Name</th>
                        <th>Description</th>
                        <th>Balance(Qty)</th>
                        <th>U/Price</th>
                        <th>Sold(Qty)</th>
                        <!-- <th>Balance(Qty)</th> -->
                        <th>Update</th>
                        <th>Delete</th>
                </thead>
                <tbody>
                    <?php
                        if (empty($disp)) {
                    ?>
                        <tr>
                            <td colspan="8" class="text-danger">No products to display</td>
                        </tr>
                    <?php        
                        }else {
                            foreach ($disp as $prod) {

                                $eid = $prod['product_id'];
                                $stocksAvailable = $prod['product_qty'] - $prod['Sold_quantity'];

                    ?>
                        <tr class="text-center">
                            <td><?= $eid; ?></td>
                            <td class="text-uppercase"><?= $prod['product_category']?></td>
                            <td><?= $prod['product_name']?></td>
                            <td><?= $prod['product_description']?></td>
                            <td><?= $stocksAvailable;?></td>
                            <td><?= $prod['unit_price']?></td>
                            <td><?= $prod['Sold_quantity']?></td>
                            
                            <td><a href="update-products.php?id=<?= $eid;?>" class="btn btn-warning" role="button">UPDATE</a></td>
                            <td><a href="" class="btn btn-danger" role="button">DELETE</a></td>
                            <!-- <td><a href="update-products.php?=" class="btn btn-warning" role="button" data-bs-toggle="modal" data-bs-target="#updateModal">UPDATE</a></td> -->
                            <!-- <td><button type="button" class="btn btn-warning" data-bs-toggle="modal" data-bs-target="#updateModal">UPDATE</button></td> -->
                            
                        </tr>
                    <?php
                            }
                        }
                     ?>
                </tbody>
            </table>   
    </div>
</main>





<?php include_once 'footer.php';?>
<!-- JavaScript Bundle with Popper -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0-beta1/dist/js/bootstrap.bundle.min.js" integrity="sha384-pprn3073KE6tl6bjs2QrFaJGz5/SUsLqktiwsUTF55Jfv3qYSDhgCecCxMW52nD2" crossorigin="anonymous"></script>
</body>
</html>