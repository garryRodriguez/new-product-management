<?php
    session_start();
    require_once 'includes/connection.php';

    if(!isset($_SESSION['id']))
    {
        header("location:login.php");
    }
    
    function showSales(){
        $conn = db_connect();

        $sql = "SELECT * FROM product_order ORDER BY order_id DESC";
        $sqlResult = $conn->query($sql);
        if ($sqlResult->num_rows > 0) {
            while ($row = $sqlResult->fetch_assoc()) {
                $allSales[] = $row;
            }
            return $allSales;
        }else {
            return 0;
        }
    }
    $disp_sales = showSales();

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
                <h2 class="display-1"><i class="fa-solid fa-list"></i> Sales</h2>
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
        <div class="row">
            <div class="col" style="height: 600px; overflow-y: scroll;">
                <table class="table table-striped table-hover mt-5">
                    <br>
                    <thead class="bg-dark text-white text-center" style="position: sticky; top: 50px;">
                            <th>ID</th>
                            <th>Product Name</th>
                            <th>Quantity</th>
                            <th>Unit Price</th>
                            <th>Amount</th>
                            <th>Date</th>  
                    </thead>
                    <tbody>
                        <?php
                            if (empty($disp_sales)) {
                        ?>
                            <tr>
                                <td colspan="5" class="text-danger">No sales to display</td>
                            </tr>
                        <?php        
                            }else {
                                foreach ($disp_sales as $sales) {
                                    $eid = $sales['order_id'];
                                    $order_product = $sales['order_product_name'];
                                    $order_qty = $sales['order_qty'];
                                    $unit_price = $sales['order_unit_price'];
                                    $total_sales = $sales['order_total_amount'];
                                    $dateOfOrder = $sales['order_date'];

                        ?>
                            <tr class="text-center">
                                <td><?= $eid; ?></td>
                                <td class="text-uppercase"><?= $order_product;?></td>
                                <td><?= $order_qty; ?></td>
                                <td><?= $unit_price; ?></td>
                                <td><?= $total_sales; ?></td>
                                <td><?= $dateOfOrder;?></td> 
                            </tr>
                        <?php
                                }
                            }
                        ?>
                    </tbody>
                </table>
            </div>
            <div class="col">
                <br>
                <div class="row justify-content-center">
                            <div class="col-md-12">
                                <div class="card mt-5">
                                    <div class="card-header">
                                        <h4 class="text-center">Filter Sales By Date</h4>
                                    </div>
                                    <div class="card-body">
                                        <form action="" method="post">
                                            <div class="row">
                                                <div class="col-md-4">
                                                    <div class="form-group">
                                                        <label for="from-dadte">From Date</label>
                                                        <input type="date" name="from_date" id="from-date" class="form-control mb-2">
                                                    </div>
                                                </div>
                                                <div class="col-md-4">
                                                    <div class="form-group">
                                                        <label for="to-dadte">To Date</label>
                                                        <input type="date" name="to_date" id="to-date" class="form-control mb-2">
                                                    </div>
                                                </div>
                                                <div class="col-md-4">
                                                    <div class="form-group">
                                                        <label for="filter">Click To Filter</label>
                                                        <input type="submit" name="btn_filter" id="btn-filter" class="form-control btn btn-primary mb-2">
                                                    </div>
                                                </div>
                                            </div>
                                        </form>
                                    </div>
                                    <div class="card mt-3">
                                    <table class="table table-hover">
                                        <thead class="text-center">
                                                <!-- <th>Order ID</th> -->
                                                <th>Date Of Order</th>
                                                <th>Total Sales Amount</th>
                                        </thead>
                                        <tbody class="text-center">
                                            <div class="card-body p-2">
                                                <?php
                                                    if (isset($_POST['btn_filter'])) {
                                                        $from_order_date = $_POST['from_date'];
                                                        $to_ordate_date = $_POST['to_date'];
                                                        
                                                        function showSalesByDate($from_order_date, $to_ordate_date){
                                                            $conn = db_connect();
                                                            
                                                            $sql = "SELECT DISTINCT order_date AS DateOfOrder, SUM(order_total_amount) AS totalAmount FROM product_order WHERE order_date BETWEEN '$from_order_date' AND '$to_ordate_date'";
                                                            $sqlResult = $conn->query($sql);
                                                            if ($sqlResult->num_rows > 0) {
                                                                while ($row = $sqlResult->fetch_assoc()) {
                                                ?>
                                                                <tr>
                                                                    <td><?= $row['DateOfOrder'];?></td>
                                                                    <td><?= $row['totalAmount'];?></td>
                                                                    <td><a href="#" role="button" class="btn btn-secondary">View Details</a></td>
                                                                </tr>
                                                <?php
                                                                    // $allSalesByDate[] = $row;
                                                                    //echo $row['order_id'];
                                                                    //echo $row['order_product_name'];
                                                                    //echo $row['order_qty'];
                                                                   // echo $row['order_total_amount'];
                                                                    //echo $row['order_date'];
                                                                }
                    
                                                            }else {
                                                                echo "No records found";
                                                            }
                                                        }
                                                    
                                                        echo showSalesByDate($from_order_date, $to_ordate_date);
                                                        
                                                    }
                                                ?>
                                            </div>
                                        </tbody>
                                    </table>                
                                        
                                    </div>
                                </div>
                            </div>
                </div>
                
            </div>
        </div>
               
    </div>
</main>





<?php include_once 'footer.php';?>
<!-- JavaScript Bundle with Popper -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0-beta1/dist/js/bootstrap.bundle.min.js" integrity="sha384-pprn3073KE6tl6bjs2QrFaJGz5/SUsLqktiwsUTF55Jfv3qYSDhgCecCxMW52nD2" crossorigin="anonymous"></script>
</body>
</html>