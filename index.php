<?php
    //Session
    session_start();
    //Database connection
    require 'inc/db.inc.php';
    
    
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

    <link rel="stylesheet" href="css/style.css">
</head>
<style>
    .hname{
        color: black;
        font-size: 15px;
       
    }
    .cart-item-image {
        width: 100px;
        height: 100px;
        object-fit: cover;
        border-radius: 10px;
        margin-right: 20px;
    }
    .total {
        font-size: 20px;
        font-weight: 600;
        margin-top: 20px;
    }
</style>
<body>

    <!-- header -->

    <header class="header">

        <a href="#" class="logo"> <i class="fa fa-birthday-cake"></i> Eat Me </a>

        <nav class="navbar">
            <a href="#home">home</a>
            <a href="#about">about</a>
            <a href="#product">product</a>
            <a href="#gallery">gallery</a>
            <a href="#promotion">promotion</a>
            <a href="#customize">customized</a>
            <a href="#footer">contact us</a>
            <a href="#popup1">Privacy policy</a>        
        </nav>
            <div class="nav-buttons">
                <div class="icons">
                    
                    <div id="cart-btn" class="fas fa-shopping-cart"></div>
                    <?php 
                        if (isset($_SESSION["userId"])) {
                           //show Name
                            echo "<a class='hname'>Welcome, ".$_SESSION['fname']."</a>";
                            echo "<a href='func/logout.php' class='btn'> Logout </a>";
                        }
                        else{
                            echo "<a href='login.php' class='btn'> Login </a>";
                            echo "<a href='signup.php' class='btn'> Sign up </a>";
                        }
                    ?>
                    
                </div>
            </div>
    </header>

    <!-- header end -->
    <!-- shopping cart -->

    <div class="cart-items-container">

        <div id="close-form" class="fas fa-times"></div>
        <h3 class="title">checkout</h3>

        <?php 

            if(isset($_SESSION['userId'])){

                $user_id = $_SESSION['userId'];
                $sql = "SELECT * FROM cart WHERE user_id = $user_id";
                $result = mysqli_query($conn, $sql);
                $resultCheck = mysqli_num_rows($result);

                if($resultCheck > 0){
                    $total = 0;
                    while($row = mysqli_fetch_assoc($result)){
                        echo "<div class='cart-item'>";
                        echo "<form action='func/cart.php' method='POST'>";
                        echo "<input type='hidden' name='item_id' value='".$row['product_id']."'>";
                        echo "<button type='submit' name='remove_from_cart' class='fas fa-times'></button>";
                        echo "</form>";
                        echo "<img class='cart-item-image' src='images/".$row['product_image']."' alt=''>";
                        echo "<div class='content'>";
                        echo "<h3>".$row['product_name']."</h3>";
                        echo "<div class='price'>Rs.".$row['product_price'].".00/-</div>";
                        echo "</div>";
                        echo "</div>";

                        $total = $total + $row['product_price'];
                        
                    }
                    echo "<div class='total'>Total: Rs.".$total.".00/-</div>";
                    echo "<a href='#' class='btn'> checkout </a>";
  

                } else {
                    echo "<h3 class='title'>Your cart is empty</h3>";
                    echo "<a href='#product' class='btn'> View Products </a>";
                }
            } else {
                echo "<h3 class='title'>Please login to view cart</h3>";
                echo "<a href='login.php' class='btn'> Login </a>";
            }
        ?>


       

    </div>

    <!-- shopping cart end-->
    <!-- home -->

    <section class="home" id="home">

        <div class="swiper home-slider">

            <div class="swiper-wrapper">

                <div class="swiper-slide slide" style="background: url(images/slider1.jpg) no-repeat;">
                    <div class="content">
                        <h3>we bake the world a better place</h3>
                        <a href="#" class="btn"> get started </a>
                    </div>
                </div>
            </div>
        </div>

    </section>

    <!-- home section ends -->

    <!-- about us -->

    <section class="about" id="about">

        <h1 class="heading"> <span>about</span> us </h1>

        <div class="row">

            <div class="image">
                <img src="images/about.png" alt="">
            </div>

            <div class="content">
                <h3>good things come to those <span>who bake </span> for others</h3>
                <p>Welcome to Eat Me, where every bite is a sweet journey into bliss. We are not just a cake shop; we're a cozy haven for cake lovers seeking delectable treats and unforgettable moments.</p>
                <p>Quality is the heart of our cakes. We use only the finest, freshest ingredients in every recipe. From luscious chocolate to seasonal fruits, our dedication to quality guarantees that every bite is a burst of deliciousness.</p>
                <a href="#" class="btn">read more</a>
            </div>

        </div>

    </section>


    <!-- about us end-->
    <!-- product -->

    <section class="product" id="product">

        <h1 class="heading">our <span> products</span></h1>

        <div class="box-container">

        <?php 
            $sql = "SELECT * FROM products";
            $result = mysqli_query($conn, $sql);
            $resultCheck = mysqli_num_rows($result);

            if($resultCheck > 0){
                while($row = mysqli_fetch_assoc($result)){
                    echo "<div class='box'>";
                    echo "<div class='image'>";
                    echo "<img src='images/".$row['image']."' alt=''>";
                    echo "</div>";
                    echo "<div class='content'>";
                    echo "<h3>".$row['name']."</h3>";
                    echo "<div class='stars'>";
                    echo "<i class='fas fa-star'></i>";
                    echo "<i class='fas fa-star'></i>";
                    echo "<i class='fas fa-star'></i>";
                    echo "<i class='fas fa-star'></i>";
                    echo "<i class='fas fa-star'></i>";
                    echo "</div>";
                    echo "<span class='price'>Rs.".$row['price'].".00</span>";
                    echo "<form action='func/cart.php' method='POST'>";
                    echo "<input type='hidden' name='item_id' value='".$row['id']."'>";

                    if (isset($_SESSION["userId"])) {
                        echo "<button type='submit' name='add_to_cart' class='btn'>add to cart</button>";
                    }
                    else{
                        echo "<a href='login.php' class='btn'> Login to order </a>";
                    }
                    echo "</form>";
                    echo "</div>";
                    echo "</div>";

                }
            }
        ?>


            

        </div>

    </section>


    <!-- product end-->
    <!-- gallery -->

    <section class="gallery" id="gallery">

        <h1 class="heading">our <span> gallery</span></h1>

        <div class="gallery-container">

            <a href="images/gallery1.jpg" class="box">
                <img src="images/gallery1.jpg" alt="">
                <div class="icons"><i class="fas fa-plus"></i></div>
            </a>

            <a href="images/gallery2.jpg" class="box">
                <img src="images/gallery2.jpg" alt="">
                <div class="icons"><i class="fas fa-plus"></i></div>
            </a>

            <a href="images/gallery3.jpg" class="box">
                <img src="images/gallery3.jpg" alt="">
                <div class="icons"><i class="fas fa-plus"></i></div>
            </a>

            <a href="images/gallery4.jpg" class="box">
                <img src="images/gallery4.jpg" alt="">
                <div class="icons"><i class="fas fa-plus"></i></div>
            </a>

            <a href="images/gallery5.jpg" class="box">
                <img src="images/gallery5.jpg" alt="">
                <div class="icons"><i class="fas fa-plus"></i></div>
            </a>

            <a href="images/gallery6.jpg" class="box">
                <img src="images/gallery6.jpg" alt="">
                <div class="icons"><i class="fas fa-plus"></i></div>
            </a>
        </div>

    </section>

    <!-- gallery end -->
    <!-- weekly promotions -->

    <section class="promotion" id="promotion">

        <h1 class="heading">weekly <span>promotions</span></h1>

        <div class="box-container">

            <div class="box">
                <div class="content">
                    <h3>chocolat cake</h3>
                    <p>Lorem, ipsum dolor sit amet consectetur adipisicing elit. Laborum earum tempore rerum totam necessitatibus ipsum.</p>
                </div>

                <img src="images/promotion1.png" alt="">
            </div>

            <div class="box">
                <img src="images/promotion2.png" alt="">
                <div class="content">
                    <h3>nut cake</h3>
                    <p>Lorem, ipsum dolor sit amet consectetur adipisicing elit. Laborum earum tempore rerum totam necessitatibus ipsum.</p>
                </div>

            </div>

        </div>

    </section>

    <!-- weekly promotions ends -->
    <!-- customized -->

    <section id="customize">

        <h1 class="heading">Customize <span>Order</span> </h1>
        <div class="customize">
            <form>
                <label for="cake_flavor">Cake Flavor:</label><br />
                <div class="customize-checkbox-container">
                    <div class="customize-checkbox-group">
                        <div class="customize-checkbox">
                            <input type="radio" name="myCheckbox">
                            <label>Chocolate</label>
                        </div>
                        <div class="customize-checkbox">
                            <input type="radio" name="myCheckbox">
                            <label>Strawberry</label>
                        </div>
                    </div>

                    <div class="customize-checkbox-group">
                        <div class="customize-checkbox">
                            <input type="radio" name="myCheckbox">
                            <label>Vanilla</label>
                        </div>
                        <div class="customize-checkbox">
                            <input type="radio" name="myCheckbox">
                            <label>Coffee</label>
                        </div>
                    </div>
                </div>

                <label for="cake_size">Cake Size:</label>
                <select id="cake_size" name="cake_size">
                    <option value="6-inch">6-inch</option>
                    <option value="8-inch">8-inch</option>
                    <option value="10-inch">10-inch</option>
                    <option value="12-inch">12-inch</option>
                </select><br><br>

                <label for="cake_decorations">Cake Decorations:</label>
                <textarea id="cake_decorations" name="cake_decorations" rows="4" cols="50"></textarea><br><br>

                <label for="special_requests">Special Requests:</label>
                <textarea id="special_requests" name="special_requests" rows="4" cols="50"></textarea><br><br>

                <button id="custom-submit-btn" class="btn" type="submit">Submit Order</button>
            </form>
            <div class="image">
                <img src="images/Customize.jpg" alt="">
            </div>
        </div>
    </section>

    <!-- customized end-->

    <!-- parallax -->

    <section class="parallax">

        <h1 class="heading">range of <span>products</span></h1>

        <div class="box-container">

            <div class="box">
                <div class="image">
                    <img src="images/parallax-1.png" alt="">
                </div>
                <div class="content">
                    <h3>waffles</h3>
                    <p>A waffle is a dish made from leavened batter or dough that is cooked between two plates that are patterned to give a characteristic size, shape, and surface impression.</p>
                </div>
            </div>

            <div class="box">
                <div class="image">
                    <img src="images/parallax-2.png" alt="">
                </div>
                <div class="content">
                    <h3>cakes</h3>
                    <p>We have Cupcakes, Sheet Cakes, Round or Square Cakes, Tiered Cakes, Custom Cakes, Special Occasion Cakes, Wedding Cakes.</p>
                </div>
            </div>

            <div class="box">
                <div class="image">
                    <img src="images/parallax-3.png" alt="">
                </div>
                <div class="content">
                    <h3>donuts</h3>
                    <p>We have Classic Donuts, Filled Donuts, Specialty Donuts, Mini Donuts, Gourmet Donuts, Vegan or Gluten-Free Donuts, Donut Holes.</p>
                </div>
            </div>

        </div>

    </section>

    <!-- parallax -->
    <!-- order -->

    <section class="order" id="order">

        <h1 class="heading"><span>order</span> now </h1>

        <div class="row">

            <div class="image">
                <img src="images/order.gif" alt="">
            </div>

            <form action="">

                <div class="inputBox">
                    <input type="text" placeholder="first name">
                    <input type="text" placeholder="last name">
                </div>

                <div class="inputBox">
                    <input type="email" placeholder="email address">
                    <input type="number" placeholder="phone number">
                </div>

                <div class="inputBox">
                    <input type="text" placeholder="food name">
                    <input type="number" placeholder="how much">
                </div>

                <textarea placeholder="your address" name="" id="" cols="30" rows="10"></textarea>
                <input type="submit" value="order now" class="btn">
            </form>

        </div>

    </section>

    <!-- order end -->

    <!-- privacy policy popup -->
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
    <!-- privacy policy popup end -->

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

    <script src="https://unpkg.com/swiper/swiper-bundle.min.js"></script>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/lightgallery-js/1.4.0/js/lightgallery.min.js"></script>

    <script src="js/script.js"></script>

</body>
</html>