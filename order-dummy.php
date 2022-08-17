<?php
    require_once 'includes/connection.php';
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
</head>
<body>
   
<nav class="navbar navbar-expand-lg bg-info text-white">
            <div class="col">
                <h2 class="display-1"><i class="fa-solid fa-cart-shopping"></i> Order Page</h2>
            </div>
            <div class="col">
                <ul class="navbar-nav justify-content-end fs-lg">                    
                    <li class="nav-item">
                        <a href="#" class="nav-link text-white text-decoration-none">Home</a>
                    </li>
                    <li class="nav-item">
                        <a href="add-category.php" class="nav-link text-white text-decoration-none">Add Category</a>
                    </li>
                    <li class="nav-item">
                        <a href="view-products.php" class="nav-link text-white text-decoration-none">View Products</a>
                    </li>
                    <li class="nav-item">
                        <a href="login.php" class="nav-link text-white text-decoration-none">Logout</a>
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
                        <input placeholder="Type here to search for product" type="text" name="search_product" id="search-product" class="fs-2 text-center text-start form-control p-3">
                    </div>
                    <div class="col-2">
                        <input type="submit" name="btn_Forsearch" value="SEARCH" class="btn btn-outline-success fs-5 form-control p-4">
                    </div>

                    <?php
                        if (isset($_POST['btn_Forsearch'])) {
                            $p = $_POST['search_product'];
                            if(empty($p)){
                                echo "field is empty";
                            }else {
                                $conn = db_connect();
                    
                                $sql = "SELECT * FROM products WHERE product_name LIKE '%btn_search%' or product_description LIKE '%btn_search%'";
                                $sqlResult = $conn->query($sql);
                                if($sqlResult->num_rows > 0){
                                    while ($row = $sqlResult->fetch_assoc()) {
                                        $product_ID = $row['product_id'];
                                        $product_Category = $row['product_category'];
                                        $product_Name = $row['product_name'];
                                        $product_description = $row['product_description'];
                                        $product_Qty = $row['product_qty'];
                                        $product_price = $row['unit_price'];
                                    }
                                }
                            }
                            
                        }  
                    ?> 
                </form>
            </div>
                   
            <label for="product-category" class="form-label">Product Category</label>
            <input type="text" name="product_category" id="product-category" class="w-50 fs-2 fw-light form-control" value="" disabled>
            <br>
            <label for="product-name" class="form-label">Product Name</label>
            <input type="text" name="product_name" id="product-name" class="fs-2 fw-light form-control" value="">
            <!-- <label for="product-description" class="form-label">Description</label> -->
            <!-- <input type="text" name="product_description" id="" class="fs-2 text text-center form-control"> -->
            <div class="row">
            <div class="col">
            <label for="product-description" class="fw-lightform-label">Description</label>
            <textarea placeholder="Description" name="product_description" id="product-description" cols="20" rows="3" class="fw-light fs-2 form-control"></textarea>
                </div>
                <div class="col">
                    <div class="row">
                        <div class="col">
                            <label for="product-qty-stock">Qty Available (In-stock)</label>
                            <input type="number" name="product_qty_stock" id="product-qty-stock" class="form-control p-5 fs-3" disabled>
                        </div>
                        <div class="col">
                            <label for="product-unit-price">Unit Price</label>
                            <input type="number" name="product_unit_price" id="product-unit-price" class="form-control p-5 fs-3" disabled>
                        </div>
                    </div>
            </div> 
                <div class="col">   
                    <div class="row">
                    <label for="product-qty" class="form-label">Enter Qty:</label>
                    <input type="number" name="product_qty" id="product-qty" class="number fs-2 text text-center form-control">
                    </div>
                    <div class="row">
                    <label for="unit-price" class="form-label">Amount Tendered</label>
                    <input type="number" name="unit_price" id="unit-price" class="fs-2 text text-center form-control">
                    </div>
                    
                </div>    
            </div>
            <input type="submit" value="BUY" name="btn_save_product_details" class="btn btn-info fs-2 text-white form-control mt-2">
            <br>
            
        </form>
        
    </div>
        










<!-- JavaScript Bundle with Popper -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0-beta1/dist/js/bootstrap.bundle.min.js" integrity="sha384-pprn3073KE6tl6bjs2QrFaJGz5/SUsLqktiwsUTF55Jfv3qYSDhgCecCxMW52nD2" crossorigin="anonymous"></script>
</body>
</html>