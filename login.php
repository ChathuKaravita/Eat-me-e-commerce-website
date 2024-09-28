<?php
    //Login function
    if(isset($_POST['submit'])){
        require 'inc/db.inc.php';

        $username = $_POST['username'];
        $password = $_POST['password'];

        //Check if inputs are empty
        if(empty($username) || empty($password)){
            header("Location: login.php?error=emptyfields");
            exit();
        }
        else{
            //Check if username exists in database
            $sql = "SELECT * FROM users WHERE username=?";
            $stmt = mysqli_stmt_init($conn);
            if(!mysqli_stmt_prepare($stmt, $sql)){
                header("Location: login.php?error=sqlerror");
                exit();
            }
            else{
                mysqli_stmt_bind_param($stmt, "s", $username);
                mysqli_stmt_execute($stmt);
                $result = mysqli_stmt_get_result($stmt);
                if($row = mysqli_fetch_assoc($result)){
                    //Check if password matches
                    $pwdCheck = password_verify($password, $row['password']);
                    if($pwdCheck == false){
                        header("Location: login.php?error=wrongpwd");
                        exit();
                    }
                    else if($pwdCheck == true){
                        session_start();
                        $_SESSION['userId'] = $row['id'];
                        $_SESSION['username'] = $row['username'];
                        $_SESSION['fname'] = $row['fname'];
                        $_SESSION['lname'] = $row['lname'];
                        $_SESSION['email'] = $row['email'];
                        header("Location: index.php?login=success");
                        exit();
                    }
                    else{
                        header("Location: login.php?error=wrongpwd");
                        exit();
                    }
                }
                else{
                    header("Location: login.php?error=nouser");
                    exit();
                }
            }
        }
    }
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Responsive Bakery Website</title>
    <link rel="stylesheet" href="https://unpkg.com/swiper/swiper-bundle.min.css" />

    <!-- font awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/lightgallery-js/1.4.0/css/lightgallery.min.css">
<link rel="stylesheet" href="css/loginstyle.css">

<style>
    .error{
        margin-top: 10px;
        background-color: gray;
        color: white;
        padding: 10px;
    }
</style>

</head>

<body>

    <!-- header -->

    <header class="header">

        <a href="#" class="logo"> <i class="fa fa-birthday-cake"></i> Eat Me </a>

        <nav class="navbar">
            <a href="index.php">home</a>
            <a href="#popup1">Privacy policy</a>
        </nav>
    </header>

    <body>
    <div>
        <div class="login-page">
        <h1>Login</h1>
       
        <?php
            
            if(isset($_GET['error'])){
                
                if($_GET['error'] == "emptyfields"){
                    echo '<p class="error">Fill in all fields!</p>';
                }
                else if($_GET['error'] == "wrongpwd"){
                    echo '<p class="error">Wrong password!</p>';
                }
                else if($_GET['error'] == "nouser"){
                    echo '<p class="error">User does not exist!</p>';
                }

            
            }
        ?>
        <form action="login.php" method="POST">
            <input type="text" name="username" placeholder="Username" class="login-input">
            <input type="password" name="password" placeholder="Password" class="login-input">
            <button class="btn" name="submit" name="submit">Login</button><br>
            <h2>Don't have an account? <a href="signup.php">Sign up </a>here</h2>
        </form>
    </div>

    <div id="popup1" class="popup-container">
        <div class="popup-content">
            <a href="#" class="close">&times;</a>
            <h1 class="heading">Privacy <span>Policy</span></h1>
            <p>
                Welcome to Eat Us, We value your privacy and want you to understand how we handle your information.
                When you use our website or order our baked goods, we collect personal information (like your name, email, address,
                phone number, and payment info), usage data (via cookies to improve our website), and communication information
                (for customer support). We use this data to fulfill orders, provide customer support, send promotions (with your
                consent), and enhance our services. We won't sell your info but may share it with service providers and as required
                by law. We take security seriously, but please remember that no system is entirely foolproof. You can access, edit,
                opt out of promotions, or request data deletion, and we'll notify you of policy changes on our website. For questions,
                reach out to us at eatme4@gmail.com. Your trust is important to us as you enjoy our delicious treats,
                and we're committed to safeguarding your privacy!
            </p>
        </div>
    </div>
        <!-- footer -->

        <section class="footer" id="footer">

            <div class="box-container">
    
                <div class="box">
                    <h3>address</h3>
                    <p>597, 13 Jayanthi Road,Athurugiriya</p>
                    <div class="share">
                        <a href="#" class="fab fa-facebook-f"></a>
                        <a href="#" class="fab fa-twitter"></a>
                        <a href="#" class="fab fa-instagram"></a>
                        <a href="#" class="fab fa-linkedin"></a>
                    </div>
                </div>
    
                <div class="box">
                    <h3>E-mail</h3>
                    <a href="#" class="link">eatme4@gmail.com</a>
                </div>
    
                <div class="box">
                    <h3>call us</h3>
                    <p>+94 723444567</p>
                </div>
    
                <div class="box">
                    <h3> opening hours</h3>
                    <p>Monday - Friday: 9:00am - 11:00pm <br> Saturday: 8:00am - 12:00pm </p>
                </div>
    
            </div>
    
        </section>
    
        <!-- footer ends -->
</body>
</html>
