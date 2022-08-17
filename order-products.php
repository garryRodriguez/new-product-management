<?php
    session_start();
    require_once 'includes/connection.php';
    if(!isset($_SESSION['id']))
    {
        header("location:login.php");
    }
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Order Page</title>
    <!-- CSS only -->
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0-beta1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-0evHe/X+R7YkIZDRvuzKMRqM+OrBnVFBL6DOitfPri4tjfHxaWutUpFmBp4vmVor" crossorigin="anonymous">

<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css" integrity="sha512-KfkfwYDsLkIlwQp6LFnl8zNdLGxu9YAA1QvwINks4PhcElQSvqcyVLLD9aMhXd13uQjoXtEKNosOWaZqXgel0g==" crossorigin="anonymous" referrerpolicy="no-referrer" />
<!-- <style>
    *{
        margin:0;
        padding:0;
        box-sizing: border-box;
    }
</style> -->
</head>
<body>
   
<nav class="navbar navbar-expand-lg bg-info text-white">
            <div class="col">
                <h2 class="display-1"><i class="fa-solid fa-cart-shopping"></i> Order Page</h2>
            </div>
            <div class="col mx-2">
                <ul class="navbar-nav justify-content-end fs-lg">                    
                    <li class="nav-item">
                        <a href="#" class="nav-link btn btn-success-outline p-3 fs-3 text-white text-decoration-none"><i class="fa-solid fa-house-user"></i> Home</a>
                    </li>
                    <li class="nav-item">
                        <a href="add-category.php" class="nav-link btn btn-success-outline p-3 fs-3 text-white text-decoration-none"><i class="fa-solid fa-folder-plus"></i> Add Category</a>
                    </li>
                    <li class="nav-item">
                        <a href="view-products.php" class="nav-link btn btn-success-outline p-3 fs-3 text-white text-decoration-none"><i class="fa-solid fa-eye"></i> View Products</a>
                    </li>
                    <li class="nav-item">
                        <a href="sales.php" class="nav-link btn btn-success-outline p-3 fs-3 text-white text-decoration-none"><i class="fa-solid fa-coins"></i> Sales</a>
                    </li>
                    <li class="nav-item">
                        <a href="login.php" class="nav-link btn btn-success-outline p-3 fs-3 text-white text-decoration-none">Logout  <i class="fa-solid fa-right-from-bracket"></i></a>
                    </li>
                </ul>
            </div>
</nav>

    <div class="container bg-light mt-4">
        <form class="form-contrl p-2" action="" method="post" autocomplete="off">
            <h2 class="text-center fw-light">Order Details</h2>
            <div class="row">
                <form action="" method="post">
                    <div class="col-10">
                        <input placeholder="Type to search product" type="text" name="search_product" id="search-product" class="fs-2 text-center text-start form-control p-3" autofocus>
                    </div>
                    <div class="col-2">
                        <input type="submit" name="btn_Forsearch" value="SEARCH" class="btn btn-outline-success fs-5 form-control p-4">
                    </div>

                    <?php
                        if (isset($_POST['btn_Forsearch'])) {
                            $p = $_POST['search_product'];
                            if(empty($p)){
                                echo "<div class='alert alert-danger mt-3' role='alert'>
                                        <h2 class='text-center'>Please supply product name to search</h2>
                                      </div>";
                            }else {
                                function searchProduct()
                                {
                                    $p = $_POST['search_product'];
                                    $conn = db_connect();
                            
                                    $sql = "SELECT * FROM products WHERE product_category LIKE '%$p%' or product_name LIKE '%$p%' or product_description LIKE '%$p%'";
                                    $sqlResult = $conn->query($sql);
                                    if($sqlResult->num_rows > 0){
                                        while ($row = $sqlResult->fetch_assoc()) {                            
                                            $searchResult[] = $row;
                                        }
                                        return $searchResult;
                                    }else {
                                        return 0;
                                        // echo "<div class='alert alert-danger mt-3' role='alert'>
                                        //         <h2 class='text-center'>No Products available</h2>
                                        //     </div>";
                                    }
                                }
                            
                                $searchResults = searchProduct();

                            } 
                        }  
                    ?> 
                </form>
        </form>
    </div>
    <div class="container mt-3">
        <table class="table table-striped table-hover w-100">
            <thead class="bg-dark text-white text-center">
                <th>ID</th>
                <th>Category</th>
                <th>Name</th>
                <th>Description</th>
                <th>Balance Qty</th>
                <th>Unit Price</th>
                <th></th>
                <th></th>
            </thead>
            <tbody>
                <?php
                     if (empty($searchResults)) {
                ?>
                    <tr>
                        <td colspan="8" class="text-center text-danger">No products to display</td>
                    </tr>
                <?php
                    }else {
                        foreach ($searchResults as $searchRow) {
                        $productIdForSearch = $searchRow['product_id'];
                        $QtyBalance = $searchRow['product_qty'] - $searchRow['Sold_quantity'];
                        
                ?>
                    <tr class="text-center">   
                    <td><?= $productIdForSearch; ?></td>
                    <td><?=$searchRow['product_category'] ?></td>
                    <td><?=$searchRow['product_name'] ?></td>
                    <td><?=$searchRow['product_description'] ?></td>
                    <!-- <td><?=$searchRow['product_qty'] ?></td> -->
                    <td><?=$QtyBalance;?></td>
                    <td><?=$searchRow['unit_price'] ?></td>
                    <td><a class="btn btn-success form-control" role="button" href="payment-details.php?id=<?= $productIdForSearch; ?>">SELECT</a></td>
                    <!-- <td><a class="btn btn-success form-control" data-bs-toggle="modal" data-bs-target="#staticBackdrop" role="button" href="payment-details.php?id=<?= $productIdForSearch; ?>">SELECT</a></td> -->
                    </tr>
                <?php
                     }
                    }
                ?>
            </tbody>
        </table>
        <p class="fs-4 text-center">--End of search--</p>
    </div>
<!-- <div class="container bg-dark text-center text-white p-3" style="position: absolute; bottom: 0;">
    <footer>
        Copyright &copy; RodzTech 2022 | Contact Us at +63 926 940 0689
    </footer>
</div> -->
<!-- JavaScript Bundle with Popper -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0-beta1/dist/js/bootstrap.bundle.min.js" integrity="sha384-pprn3073KE6tl6bjs2QrFaJGz5/SUsLqktiwsUTF55Jfv3qYSDhgCecCxMW52nD2" crossorigin="anonymous"></script>
</body>
</html>