<?php
    session_start();
    require_once 'includes/connection.php';

    function userLogin($user_name, $user_pass){
        $conn = db_connect();

        $sql = "SELECT * FROM users WHERE username='$user_name' && password='$user_pass'";
        $sqlResult = $conn->query($sql);
        
        if ($sqlResult->num_rows == 1) {
            $userCredentials = $sqlResult->fetch_assoc();
            $_SESSION['username'] = $userCredentials['username'];
            $_SESSION['id'] = $userCredentials['id'];
                                    
            // header("location:view-products.php");
            header("location:order-products.php");
        }else {
                
            echo "<div class='alert alert-danger mt-3' role='alert'>
                        <h2 class='text-center'>ERROR: Username or Password is incorrect.</h2>
                  </div>";
            }
        }
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login Page</title>
    <!-- CSS only -->
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0-beta1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-0evHe/X+R7YkIZDRvuzKMRqM+OrBnVFBL6DOitfPri4tjfHxaWutUpFmBp4vmVor" crossorigin="anonymous">

<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css" integrity="sha512-KfkfwYDsLkIlwQp6LFnl8zNdLGxu9YAA1QvwINks4PhcElQSvqcyVLLD9aMhXd13uQjoXtEKNosOWaZqXgel0g==" crossorigin="anonymous" referrerpolicy="no-referrer" />

<!-- <style> 
    .my-animation {
    width: 60px;
    height: 60px;
    background: green;
    border-radius: 10px;
    transition: width 5s;
    }
    .my-animation:hover{
        width: 700px
    }
</style> -->

</head>
<body>
   
<nav class="navbar navbar-expand-lg bg-success text-white">
            <div class="col">
                <h2 class="display-5 text-start mx-5">Product Inventory Management System (PIMS)</h2>
            </div>
            
</nav>
<br>
<br>
<br>
<br>
<br>
<br>
<br>
    <div class="my-animation" style="position: absolute; left: 700px"></div>
<br>
    <div class="container W-25 mt-5">
                <form action="" method="post" class="w-50" style="margin: 0 auto;" autocomplete="off">
                    <h2 class="text-center fw-light mb-5">Please Login with your username and password</h2>
                        <div class="form-floating mb-3">
                            <input type="text" name="user_name" id="user-name" class="fs-1 p-4 text-center fw-5 form-control" placeholder="USERNAME" autofocus>
                            <label for="user-name" class="form-label">Username</label>
                        </div>
                        <div class="form-floating mb-3">
                            <input type="password" name="password" id="password" class="fs-1 p-4 text-center form-control" placeholder="PASSWORD">
                            <label for="password" class="form-label">Password</label>
                        </div>
                    <input type="submit" name="btn_login" value="LOGIN" class="fs-1 btn btn-success form-control">

                    <?php
                        if (isset($_POST['btn_login'])) {

                            $user_name = $_POST['user_name'];
                            $user_pass = $_POST['password'];
                            
                            if (empty($user_name)) {
                                echo "<div class='alert alert-danger mt-3' role='alert'>
                                        <h2 class='text-center'>Username is required</h2>
                                     </div>";
                            }elseif (empty($user_pass)) {
                                echo "<div class='alert alert-danger mt-3' role='alert'>
                                        <h2 class='text-center'>Password is required</h2>
                                    </div>";
                            }else {
                                userLogin($user_name, $user_pass);
                            }
                        }
                    ?>
                </form>
    </div>
    <?php
        include 'footer.php';
    ?>
    
        










<!-- JavaScript Bundle with Popper -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0-beta1/dist/js/bootstrap.bundle.min.js" integrity="sha384-pprn3073KE6tl6bjs2QrFaJGz5/SUsLqktiwsUTF55Jfv3qYSDhgCecCxMW52nD2" crossorigin="anonymous"></script>
</body>
</html>