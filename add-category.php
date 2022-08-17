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
    <title>Add Category</title>
    <!-- CSS only -->
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0-beta1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-0evHe/X+R7YkIZDRvuzKMRqM+OrBnVFBL6DOitfPri4tjfHxaWutUpFmBp4vmVor" crossorigin="anonymous">

<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css" integrity="sha512-KfkfwYDsLkIlwQp6LFnl8zNdLGxu9YAA1QvwINks4PhcElQSvqcyVLLD9aMhXd13uQjoXtEKNosOWaZqXgel0g==" crossorigin="anonymous" referrerpolicy="no-referrer" />
</head>
<body>
<nav class="navbar navbar-expand-lg bg-danger text-white">
            
            <div class="container-fluid">
                    <div class="col">
                        <h2 class="display-1"><i class="fa-solid fa-folder-open"></i> Category</h2>
                    </div>
                    <div class="col">
                        <ul class="navbar-nav justify-content-end fs-lg">
                            
                        <li class="nav-item">
                            <a href="order-products.php" class="nav-link btn btn-success-outline p-3 fs-3 text-white text-decoration-none"><i class="fa-solid fa-house-user"></i> Home</a>
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
        <form class="form-control p-2" action="" method="post" autocomplete="off">
            <h2 class="text-center fw-light">Add Category</h2>
            <input type="text" name="category_name" id="category-name" class="fs-2 text text-center form-control" required autofocus>
            <input type="submit" name="btn_addCategory" value="ADD" class="btn btn-danger text-white mt-3 fs-3 border form-control">
            <?php
                if(isset($_POST['btn_addCategory']))
                {
                    $conn = db_connect();
                    $cat_name = $_POST['category_name'];
                    
                    $SqlCategoriesTbl = "INSERT INTO categories(category_name) VALUES('$cat_name')";

                    if ($conn->query($SqlCategoriesTbl)) {
                        echo "<div class='alert alert-success mt-1' role='alert'>
                                <h2 class='text-center'>Added Successfully</h2>
                            </div>
                            ";
                    }else {
                        echo "Error adding new category";
                    }
                }
            ?>
        </form>
    </div>
    
    <?php

        $conn = db_connect();
        $sql_select_cat = "SELECT * FROM categories";
        $result = $conn->query($sql_select_cat);
        
        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                
            }
        }
    ?>













<?php include_once 'footer.php';?>
<!-- JavaScript Bundle with Popper -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0-beta1/dist/js/bootstrap.bundle.min.js" integrity="sha384-pprn3073KE6tl6bjs2QrFaJGz5/SUsLqktiwsUTF55Jfv3qYSDhgCecCxMW52nD2" crossorigin="anonymous"></script>
</body>
</html>