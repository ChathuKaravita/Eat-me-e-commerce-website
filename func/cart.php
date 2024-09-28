<?php
    session_start();

    $user_id = $_SESSION['userId'];
    require '../inc/db.inc.php';

    //Add item to cart
    if(isset($_POST['add_to_cart'])) {
       

        $item_id = $_POST['item_id'];
        
        if(empty($item_id)) {
            header("Location: ../index.php?carterror=emptyfields");
        }

        //Get product details
        $sql = "SELECT * FROM products WHERE id=?";
        $stmt = mysqli_stmt_init($conn);

        if(!mysqli_stmt_prepare($stmt, $sql)){
            header("Location: ../index.php?error=sqlerror");
            exit();
        }
        else{
            mysqli_stmt_bind_param($stmt, "s", $item_id);
            mysqli_stmt_execute($stmt);
            $result = mysqli_stmt_get_result($stmt);
            if($row = mysqli_fetch_assoc($result)){
                $product_id = $row['id'];
                $product_name = $row['name'];
                $product_price = $row['price'];
                $product_image = $row['image'];
                

                //Add item to cart

                $sql = "INSERT INTO cart (user_id, product_id, product_name, product_price, product_image) VALUES (?, ?, ?, ?, ?)";
                $stmt = mysqli_stmt_init($conn);

                if(!mysqli_stmt_prepare($stmt, $sql)){
                    header("Location: ../index.php?error=sqlerror");
                    exit();
                }
                else{
                    mysqli_stmt_bind_param($stmt, "sssss", $user_id, $product_id, $product_name, $product_price, $product_image);
                    mysqli_stmt_execute($stmt);
                    header("Location: ../index.php?addtocart=success");
                    exit();
                }
            }
            else{
                header("Location: ../index.php?error=sqlerror");
                exit();
            }
        }

      
    }

    //Remove item from cart
    if(isset($_POST['remove_from_cart'])) {

        $item_id = $_POST['item_id'];
        
        if(empty($item_id)) {
            header("Location: ../index.php?carterror=emptyfields");
        }

        $sql = "DELETE FROM cart WHERE product_id=? AND user_id=?";
        $stmt = mysqli_stmt_init($conn);

        if(!mysqli_stmt_prepare($stmt, $sql)){
            header("Location: ../index.php?error=sqlerror");
            exit();
        }
        else{
            mysqli_stmt_bind_param($stmt, "ss", $item_id, $user_id);
            mysqli_stmt_execute($stmt);
            header("Location: ../index.php?removefromcart=success");
            exit();
        }

      
    }