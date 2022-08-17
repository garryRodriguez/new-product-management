<?php
    session_start();
    require_once 'includes/connection.php';
    if(!isset($_SESSION['id']))
    {
        header("location:login.php");
    }

        $selected_product_id = $_GET['id'];
        $conn = db_connect();
        $sql = "SELECT product_name, product_description, unit_price FROM products WHERE product_id='$selected_product_id'";
        $sqlResult = $conn->query($sql);
        if ($sqlResult->num_rows > 0) {
           while ($row = $sqlResult->fetch_assoc()) {
               $product_name = $row['product_name'];
               $product_description = $row['product_description'];
               $product_price = $row['unit_price'];
           }
        }
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Payment Details</title>
    <!-- CSS only -->
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0-beta1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-0evHe/X+R7YkIZDRvuzKMRqM+OrBnVFBL6DOitfPri4tjfHxaWutUpFmBp4vmVor" crossorigin="anonymous">

<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css" integrity="sha512-KfkfwYDsLkIlwQp6LFnl8zNdLGxu9YAA1QvwINks4PhcElQSvqcyVLLD9aMhXd13uQjoXtEKNosOWaZqXgel0g==" crossorigin="anonymous" referrerpolicy="no-referrer" />
</head>
<body>
   
<nav class="navbar navbar-expand-lg bg-info text-white">
            <div class="col">
                <h2 class="display-1 mx-3"><i class="fa-solid fa-cash-register"></i> Payment Details</h2>
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
                        if (isset($_POST['btn_paymentDetails'])) {
                            $order_Qty = $_POST['order_product_qty'];
                            if (empty($order_Qty)) {
                                echo "<div class='alert alert-danger mt-1' role='alert'>
                                        <h2 class='text-center'>ERROR : Please enter order quantity</h2>
                                      </div>";
                            }else {
                                $conn = db_connect();
                                $order_Product_name = $product_name;
                                $order_Product_description = $product_description;
                                $order_Qty = $_POST['order_product_qty'];
                                $order_Product_unitPrice = $product_price;
                                $selected_product_id = $_GET['id'];

                                $sql = "INSERT INTO product_order(order_product_name, order_desc, order_qty, order_unit_price, order_total_amount, order_amount_tendered, order_money_change, order_notes, order_product_id) VALUES('$order_Product_name', '$order_Product_description', '$order_Qty', '$order_Product_unitPrice', null, null, null, null, '$selected_product_id')";
                                
                                $sqlResultInsertOrder = $conn->query($sql);
                                if ($sqlResultInsertOrder) {
                                    
                                    //Note: you need to query the products table and get the Sold_quantity value
                                    //and then add the value of $order_Qty to the current value in the db before updating table


                                    $sqQuerySoldQty = "SELECT * FROM products WHERE product_id='$selected_product_id'";
                                    $sqlQueryTheSoldQty = $conn->query($sqQuerySoldQty);
                                    if ($sqlQueryTheSoldQty->num_rows > 0) {
                                        while ($rows = $sqlQueryTheSoldQty->fetch_assoc()) {
                                            $qty_sold = $rows['Sold_quantity'];
                                        }
                                        $total_Sold = $qty_sold + $order_Qty;
                                    }

                                    $SqlForInsertOrderQtyToProducts = "UPDATE products SET Sold_quantity='$total_Sold' WHERE product_id='$selected_product_id' ";
                                    $ssss = $conn->query($SqlForInsertOrderQtyToProducts);
                                    if ($ssss) {
                                        // echo "<div class='alert alert-success mt-1' role='alert'>
                                        //          <h2 class='text-center'>Order successfully saved into database.</h2>
                                        //       </div>";
                                        $conn = db_connect();
                                        $total_amount =  $order_Qty * $order_Product_unitPrice;
                                        $Insert_total_amount = "UPDATE product_order SET order_total_amount ='$total_amount' WHERE order_product_id='$selected_product_id' ";
                                        $insert_the_amount = $conn->query($Insert_total_amount);
                                        if ($insert_the_amount) {
                                            header("Refresh:2;url=view-products.php");
                                            echo "<div class='alert alert-success mt-1' role='alert'>
                                                    <h2 class='text-center'>Order successfully saved into database.</h2>
                                                  </div>";
                                        }else {
                                            echo "An error occured inserting data.";
                                        }
                                        

                                    }else {
                                        echo "error";
                                    }

                                    // echo "<div class='alert alert-success mt-1' role='alert'>
                                    //         <h2 class='text-center'>Order successfully saved into database.</h2>
                                    //       </div>";
                                }else {
                                    echo "<div class='alert alert-danger mt-1' role='alert'>
                                            <h2 class='text-center'>ERROR saving order.</h2>
                                          </div>";
                                }   
                            }
                        }

                        
                    ?>
             <form action="" method="post">
                 <div class="form-floating mb-3">
                     <input type="text" class="form-control fs-2" name="order_name" id="order-product-name" placeholder="Name of Product" value="<?php echo $product_name;?>" disabled>
                    <label for="order-product-name"id="order-product-name">Name of Product</label>
                 </div>
                 <div class="form-floating mb-3">
                 <textarea class="form-control fs-2" name="order_product_description" placeholder="Product Description" id="floatingTextarea" style="height: 100px" disabled><?php echo $product_description;?></textarea>
                    <label for="order-product-desc"id="order-product-desc">Product Description</label>
                 </div>
                 <div class="form-floating mb-3">
                    <input type="number" name="order_product_unit_price" id="order-product-unit-price" class="form-control fs-2 w-25 text-center" value="<?php echo $product_price;?>" disabled>
                    <label for="order-product-unit-price"id="order-product-unit-price">Unit Price</label> 
                 </div>
                 <div class="form-floating mb-3">
                    <input type="number" name="order_product_qty" id="order-product-desc" class="form-control fs-2 w-25 text-center">
                    <label for="order-product-qty"id="order-product-qty">Order Qty</label>
                 </div>
                 <div class="form-floating mb-3">
                     <input type="number" name="order_product_total_amount" id="order_product_total_amount" class="form-control fs-2 w-25 text-center" disabled>
                    <label for="order-product-total-amount"id="order-product-total-amount">Total Amount To Pay</label>
                 </div>
                 <br>
                 <input type="submit" name="btn_paymentDetails" value="SAVE" class="btn btn-info form-control fs-2 text-white">
             </form>
    </div>









<?php include_once 'footer.php'; ?>
<!-- JavaScript Bundle with Popper -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0-beta1/dist/js/bootstrap.bundle.min.js" integrity="sha384-pprn3073KE6tl6bjs2QrFaJGz5/SUsLqktiwsUTF55Jfv3qYSDhgCecCxMW52nD2" crossorigin="anonymous"></script>
</body>
</html>