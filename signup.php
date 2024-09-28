<?php
   //Sign up post request
    if(isset($_POST['submit'])){
        require 'inc/db.inc.php';
        $fname = $_POST['fname'];
        $lname = $_POST['lname'];
        $email = $_POST['email'];
        $username = $_POST['username'];
        $password = $_POST['password'];
        $password_conf = $_POST['password_conf'];

        //Error handlers
        //Check for empty fields
        if(empty($fname) || empty($lname) || empty($email) || empty($username) || empty($password) || empty($password_conf)){
            header("Location: signup.php?error=emptyfields&fname=".$fname."&lname=".$lname."&email=".$email."&username=".$username);
            exit();
        }
        //Check for invalid email
        else if(!filter_var($email, FILTER_VALIDATE_EMAIL)){
            header("Location: signup.php?error=invalidemail&fname=".$fname."&lname=".$lname."&username=".$username);
            exit();
        }
        //Check for invalid username
        else if(!preg_match("/^[a-zA-Z0-9]*$/", $username)){
            header("Location: signup.php?error=invalidusername&fname=".$fname."&lname=".$lname."&email=".$email);
            exit();
        }
        //Check if passwords match
        else if($password !== $password_conf){
            header("Location: signup.php?error=passwordcheck&fname=".$fname."&lname=".$lname."&email=".$email."&username=".$username);
            exit();
        }
        else{
            //Check if username already exists
            $sql = "SELECT username FROM users WHERE username=?";
            $stmt = mysqli_stmt_init($conn);
            if(!mysqli_stmt_prepare($stmt, $sql)){
                header("Location: signup.php?error=sqlerror");
                exit();
            }
            else{
                mysqli_stmt_bind_param($stmt, "s", $username);
                mysqli_stmt_execute($stmt);
                mysqli_stmt_store_result($stmt);
                $resultCheck = mysqli_stmt_num_rows($stmt);
                if($resultCheck > 0){
                    header("Location: signup.php?error=usernametaken&fname=".$fname."&lname=".$lname."&email=".$email);
                    exit();
                }
                else{
                    //Insert user into database
                    $sql = "INSERT INTO users (fname, lname, email, username, password) VALUES (?, ?, ?, ?, ?)";
                    $stmt = mysqli_stmt_init($conn);
                    if(!mysqli_stmt_prepare($stmt, $sql)){
                        header("Location: signup.php?error=sqlerror");
                        exit();
                    }
                    else{
                        $hashedPwd = password_hash($password, PASSWORD_DEFAULT);
                        mysqli_stmt_bind_param($stmt, "sssss", $fname, $lname, $email, $username, $hashedPwd);
                        mysqli_stmt_execute($stmt);
                        header("Location: signup.php?signup=success");
                        exit();
                    }
                }
            }

        }
        mysqli_stmt_close($stmt);
        mysqli_close($conn);

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
    <link rel="stylesheet" href="css/signupstyle.css">

<style>
    .error{
        margin-top: 10px;
        background-color: gray;
        color: white;
        padding: 10px;
    }
    .success{
        margin-top: 10px;
        background-color: gray;
        color: green;
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
    <!-- Error handle -->
    <div>
        
    </div>
    <div>
        <div class="login-page">
        <h1>Sign Up</h1>
            <?php
                if(isset($_GET['error'])){
                    if($_GET['error'] == "emptyfields"){
                        echo '<p class="error">Fill in all fields!</p>';
                    }
                    else if($_GET['error'] == "invalidemail"){
                        echo '<p class="error">Invalid email!</p>';
                    }
                    else if($_GET['error'] == "invalidusername"){
                        echo '<p class="error">Invalid username!</p>';
                    }
                    else if($_GET['error'] == "passwordcheck"){
                        echo '<p class="error">Passwords do not match!</p>';
                    }
                    else if($_GET['error'] == "usernametaken"){
                        echo '<p class="error">Username already taken!</p>';
                    }
                }
                else if(isset($_GET['signup'])){
                    if($_GET['signup'] == "success"){
                        echo '<p class="success">Signup successful!</p>';
                    }
                }
            ?>

        
        <form action="signup.php" method="POST">
            <input type="text" name="fname" placeholder="First Name" class="login-input">
            <input type="text" name="lname" placeholder="Last Name" class="login-input">
            <input type="text" name="email" placeholder="Email" class="login-input">
            <input type="text" name="username" placeholder="Username" class="login-input">
            <input type="password" name="password" placeholder="Password" class="login-input">
            <input type="password" name="password_conf" placeholder="Confirm Password" class="login-input">
            <button class="btn" type="submit" name="submit">Sign Up</button><br>
            <h2>Already have an account? <a href="login.php">Log In </a>here</h2>
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
