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
    <title>Add Products</title>
    <!-- CSS only -->
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0-beta1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-0evHe/X+R7YkIZDRvuzKMRqM+OrBnVFBL6DOitfPri4tjfHxaWutUpFmBp4vmVor" crossorigin="anonymous">

<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css" integrity="sha512-KfkfwYDsLkIlwQp6LFnl8zNdLGxu9YAA1QvwINks4PhcElQSvqcyVLLD9aMhXd13uQjoXtEKNosOWaZqXgel0g==" crossorigin="anonymous" referrerpolicy="no-referrer" />
</head>
<body>
   
<nav class="navbar navbar-expand-lg bg-success text-white">
            <div class="col">
                <h2 class="display-1"><i class="fa-solid fa-square-plus"></i> Add Products</h2>
            </div>
            <div class="col">
                <ul class="navbar-nav justify-content-end fs-lg">                    
                    <li class="nav-item">
                        <a href="order-products.php" class="nav-link btn btn-success-outline p-3 fs-3 text-white text-decoration-none"><i class="fa-solid fa-house-user"></i> Home</a>
                    </li>
                    <li class="nav-item">
                        <a href="add-category.php" class="nav-link btn btn-success-outline p-3 fs-3 text-white text-decoration-none"><i class="fa-solid fa-folder-plus"></i> Add Category</a>
                    </li>
                    <li class="nav-item">
                        <a href="view-products.php" class="nav-link btn btn-success-outline p-3 fs-3 text-white text-decoration-none"><i class="fa-solid fa-eye"></i> View Products</a>
                    </li>
                    <li class="nav-item">
                        <a href="logout.php" class="nav-link btn btn-success-outline p-3 fs-3 text-white text-decoration-none">Logout <i class="fa-solid fa-right-from-bracket"></i></a>
                    </li>
                </ul>
            </div>
        </nav>

    <div class="container bg-light mt-5 p-2">
    <?php
               error_reporting(0);
                if (isset($_POST['btn_save_product_details'])) {
                    $prod_category = $_POST['product_category'];
                    if (empty($prod_category)) {
                        echo "<div class='alert alert-danger mt-1' role='alert'>
                                <h2 class='text-center'>Please select product category</h2>
                            </div>";
                    }else {
                        $conn = db_connect();
                        $prod_category = $_POST['product_category'];
                        $prod_name = $_POST['product_name'];
                        $prod_description = $_POST['product_description'];
                        $prod_quantity = $_POST['product_qty'];
                        $prod_unit_price = $_POST['unit_price'];

                        $sqlInsertProduct = "INSERT INTO products(product_category, product_name, product_description, product_qty, unit_price) VALUES('$prod_category', '$prod_name', '$prod_description', '$prod_quantity', '$prod_unit_price')";
                        

                        if($conn->query($sqlInsertProduct))
                        {
                            echo "<div class='alert alert-success mt-1' role='alert'>
                                <h2 class='text-center'>Product Details Saved</h2>
                            </div>";
                        }else {
                            echo "Error adding product details.";
                        }
                    }   
                }
            ?>
        <form class="form-contrl p-2" action="" method="post" autocomplete="off">
            <h2 class="text-center fw-light">Add Product Details</h2>
            <?php

                function displayAllProductCategories(){
                    $conn = db_connect();

                    $sqlSelectCat = "SELECT * FROM categories";
                    $sqlResult = $conn->query($sqlSelectCat);
                    if($sqlResult->num_rows > 0)
                    {
                        while ($row = $sqlResult->fetch_assoc()) {
                            echo "<option value='".$row['category_name']."'>".$row['category_name']."</option>";
                        }
                    }else {
                        echo "There is an error retreiveing product category";
                    }                
                }
            ?>
            <label for="product-category" class="form-label">Select Category</label>
            <select name="product_category" id="product-category" class="text-uppercase fs-2 text text-center form-select w-50">
                <option value="#" selected disabled>--Select Product Category--</option>
                <?php echo displayAllProductCategories();?>
            </select>
            <br>
            <label for="product-name" class="form-label">Product Name</label>
            <input type="text" name="product_name" id="product-name" class="fs-2 text text-center form-control" required autofocus>
            <label for="product-description" class="form-label">Description</label>
            <!-- <input type="text" name="product_description" id="" class="fs-2 text text-center form-control"> -->
            <div class="row">
                <div class="col">
                    <textarea placeholder="Description" name="product_description" id="product-description" cols="20" rows="3" class="fs-2 form-control"></textarea>
                </div>
                <div class="col">
                    <div class="row">
                    <label for="product-qty" class="form-label">Qty</label>
                    <input type="number" name="product_qty" id="product-qty" class="number fs-2 text text-center form-control">
                    </div>
                    <div class="row">
                    <label for="unit-price" class="form-label">Unit Price</label>
                    <input type="number" name="unit_price" id="unit-price" class="fs-2 text text-center form-control">
                    </div>
                    
                </div>    
            </div>
            <input type="submit" value="SAVE" name="btn_save_product_details" class="btn btn-success text-white form-control mt-2 fs-3">
            <br>
            
        </form>
        
    </div>
        









<?php include_once 'footer.php'; ?>
<!-- JavaScript Bundle with Popper -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0-beta1/dist/js/bootstrap.bundle.min.js" integrity="sha384-pprn3073KE6tl6bjs2QrFaJGz5/SUsLqktiwsUTF55Jfv3qYSDhgCecCxMW52nD2" crossorigin="anonymous"></script>
</body>
</html>