<?php
    session_start();
    require_once 'includes/connection.php';

    if(!isset($_SESSION['id']))
    {
        header("location:login.php");
    }

        $conn =  db_connect();
        $selectedID = $_GET['id'];

        $sql = "SELECT * FROM products WHERE product_id='$selectedID'";
        $sqlResult = $conn->query($sql);
        if ($sqlResult->num_rows > 0) {
            while($row = $sqlResult->fetch_assoc()) {
                $eid = $row['product_id'];
                $cat = $row['product_category'];
                $prod_name = $row['product_name'];
                $prod_desc = $row['product_description'];
                $prod_qty = $row['product_qty'];
                $prod_price = $row['unit_price'];
                $total_Sold = $row['Sold_quantity'];

                $bal = $prod_qty - $total_Sold;

            }
        }
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Update Products Details</title>
    <!-- CSS only -->
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0-beta1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-0evHe/X+R7YkIZDRvuzKMRqM+OrBnVFBL6DOitfPri4tjfHxaWutUpFmBp4vmVor" crossorigin="anonymous">

<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css" integrity="sha512-KfkfwYDsLkIlwQp6LFnl8zNdLGxu9YAA1QvwINks4PhcElQSvqcyVLLD9aMhXd13uQjoXtEKNosOWaZqXgel0g==" crossorigin="anonymous" referrerpolicy="no-referrer" />
</head>
<body>
   
    <?php
        require_once 'includes/add-products-nav-bar.php';
    ?>
    <div class="container bg-light mt-5 p-2">

        <form class="form-contrl p-2" action="" method="post" autocomplete="off">
            <?php
                if (isset($_POST['btn_save_product_details'])) {

                    insertNewProductDetails();
                }
            ?>
            <h2 class="text-center fw-light">Update Product Details</h2>
            <label for="current-cat-name" class="form-label">Current Category Name</label>
            <input type="text" name="current_cat_name" id="current_cat_name" value="<?php echo $cat; ?>" class="fs-1 text text-center form-control" disabled>
            <?php

                function displayAllProductCategories(){
                    $conn = db_connect();

                    $sqlSelectCat = "SELECT DISTINCT category_name FROM categories ORDER BY category_name ASC";
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
            <label for="product-category" class="form-label">Select New Category</label>
            <select name="product_category" id="product-category" class="fs-2 text text-center text-uppercase form-select w-50">
                <option value="#" selected disabled>--Select New Product Category--</option>
                <?php echo displayAllProductCategories();?>
            </select>
            <br>
            <label for="product-name" class="form-label">Product Name</label>
            <input type="text" name="product_name" id="product-name" value="<?php echo $prod_name; ?>" class="fs-2 text text-center form-control">
            <label for="product-description" class="form-label">Description</label>
            <!-- <input type="text" name="product_description" id="" class="fs-2 text text-center form-control"> -->
            <div class="row">
                <div class="col">
                    <textarea placeholder="Description" name="product_description" id="product-description" cols="20" rows="3" class="fs-2 form-control"><?php echo $prod_desc; ?></textarea>
                </div>
                <div class="col">
                    <div class="row">
                    <label for="product-qty" class="form-label">Qty</label>
                    <input type="number" name="product_qty" id="product-qty" class="number fs-2 text text-center form-control" autofocus>
                    </div>
                    <div class="row">
                    <label for="unit-price" class="form-label">Unit Price</label>
                    <input type="number" name="unit_price" id="unit-price" value="<?php echo $prod_price; ?>" class="fs-2 text text-center form-control">
                    </div>
                    
                </div>    
            </div>
            <input type="submit" value="SAVE" name="btn_save_product_details" class="btn btn-info text-white form-control mt-2 fs-2">
            <input type="submit" value="CANCEL" name="btn_cancel" class="btn btn-secondary text-white form-control mt-2 fs-2">
            <br>
        </form>
    </div>

    <?php
        function insertNewProductDetails(){
            $selectedID = $_GET['id'];
            if (empty($_POST['product_category'])) {
                echo "<div class='alert alert-danger mt-1' role='alert'>
                            <h2 class='text-center'>ERROR: Please select new category name.</h2>
                        </div>";    
            }else {

                $conn = db_connect();
                $sqlQryForCurrBalQty = "SELECT product_qty FROM products WHERE product_id='$selectedID'";
                $sqlRs = $conn->query($sqlQryForCurrBalQty);
                if($sqlRs->num_rows > 0)
                {
                    while ($rowRs = $sqlRs->fetch_assoc()) {
                        $qtyCurrent = $rowRs['product_qty'];
                    }
                }                
                
                $new_categoryName = $_POST['product_category'];
                $new_productName = $_POST['product_name'];
                $new_productDesc = $_POST['product_description'];
                $new_productQty = $_POST['product_qty'];
                $new_unitPrice = $_POST['unit_price'];
                $conn = db_connect();
                $sql = "UPDATE products SET product_category='$new_categoryName', product_name='$new_productName', product_description='$new_productDesc', product_qty='$new_productQty' + '$qtyCurrent', unit_price='$new_unitPrice' WHERE product_id='$selectedID'";
                $sqlUpdateResult = $conn->query($sql);
                if ($sqlUpdateResult) {
                    echo "<div class='alert alert-success mt-1' role='alert'>
                            <h2 class='text-center'>Product Details Successfully Updated</h2>
                        </div>";
                }else {
                    echo "Error in updating producte records.";
                }
            }
        }
    ?>
        

        <?php include_once 'footer.php';?>
<!-- JavaScript Bundle with Popper -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0-beta1/dist/js/bootstrap.bundle.min.js" integrity="sha384-pprn3073KE6tl6bjs2QrFaJGz5/SUsLqktiwsUTF55Jfv3qYSDhgCecCxMW52nD2" crossorigin="anonymous"></script>
</body>
</html>