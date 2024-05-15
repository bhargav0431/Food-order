<!--start of php-->

<?php
// Establish a connection to the MySQL database
$host = "localhost";
$username = "root";
$password = "";
$database = "food-order";

$conn = new mysqli($host, $username, $password, $database);

// Check the connection
if ($conn->connect_error) 
{
    die("Connection failed: " . $conn->connect_error);
}

// Retrieve product data from the database
$sql = "SELECT * FROM products";
$result = $conn->query($sql);

if (isset($_POST['add_to_cart'])) 
{
    $product__id = $_POST['product__id'];
    $product__name= $_POST['product__name'];
    $product__price=$_POST['product__price'];
    $product__thumbnail= $_POST['product__thumbnail'];
    $product__quantity = $_POST['product__quantity'];

    $select_cart = mysqli_query($conn,"SELECT * FROM `cart` WHERE name= '$product__name'");
    
    if(mysqli_num_rows($select_cart) > 0)
    {
        $message[] = 'product already added to cart';
    }
    else
    {
        $insert_product = mysqli_query($conn, "INSERT INTO `cart`(id, name, price, image, quantity) VALUES('$product__id','$product__name', '$product__price', '$product__thumbnail', '$product__quantity')");
        $message[] = 'product added to cart succesfully';
    }
}
// Close the database connection
$conn->close();
?>


<!--start of html-->

<!DOCTYPE html>
<html lang="en">
<head>
    
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ECOMMERCE WEBSITE</title>
    
    
    

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.8.2/css/all.css" />
    <link rel="stylesheet" href="css\style.css">
    
<style>
    h1
    {
        text-align: center;
        color: sandybrown;
    }

    
    
    .table
    {
        border: 2px solid gold;
        border-radius: 5px;    
        border-width: 3px;
        padding: 5px;
    }

    .nav-link 
    {
        display: inline-block;
    }
    
    .product-list
    {
        display: flex;
        flex-wrap: wrap;
        justify-content: center;
        color: white;
        background-color: bisque;
    }

    .products 
    {
        padding: 35px;     
        background-color: #FA8BFF;
        background-color: #ff6b81;
        margin: 20px;
        width: 350px; /* Adjust the width as needed */
        height: 600px;
        flex-direction: row;
    }

    .products img
    {
        width: 350px;
        height: 300px;
    }
    
    footer 
    {
        font-size:20px;
        padding: 5px;
        display: flex;
        justify-content: space-around;
    }

    .footer-links ul 
    {
        list-style: none;
        display: flex;
    }

    .footer-links ul li 
    {
        margin-right: 20px;
    
    }
    .footer-links a
    {
        color: black;
    }

    .button-link {
        display: inline-block;
        padding: 10px 20px;
        background-color: #007bff; /* Blue background color */
        color: white; /* White text color */
        text-align: center;
        text-decoration: none; /* Remove underline from links */
        border: none; /* Remove border */
        border-radius: 10px; /* Rounded corners */
        cursor: pointer; /* Change cursor to pointer on hover */
    }   
</style>


</head>

<body style="background-image: url(./images/registration_background_1.jpeg);background-size: cover;background-repeat: no-repeat">
    
<section class="navbar">
    <div class="container">
        <div class="logo">
            <a href="#" title="Logo">
                <img src="images\final1logo.png" alt="Restaurant Logo" class="img-responsive">
            </a>
        </div>

       

        <div class="menu text-right">
            <ul>
                <li>
                    <a href="index.html">Home</a>
                </li>
                <li>
                    <a href="products.php">Shop</a>
                </li>
                
                <li>
                    <a href="cart.php">Cart</a>
                </li>
                <li>
                    <a href="login.html">Login</a>
                </li>
                
            </ul>
        </div>

        <div class="clearfix"></div>
    </div>
</section>


         
    <?php
        if(isset($message))
        {
            foreach($message as $message)
            {
                echo '<div class="message"><span>'.$message.'</span> <i class="fas fa-times" onclick="this.parentElement.style.display = `none`;"></i> </div>';
            };
        };
    ?>
    
    <h1>PRODUCTS</h1>
    <section class="product-list">
    
    <?php
    
        // Display product information from the database
        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                echo '<form method="post" action="">';
                echo '<div class="products">';
                
                    echo '<img src="' . $row['product__thumbnail'] . '" alt="' . $row['product__name'] . '">';
                    
                    //for rating 
                    echo '<div class="product-rating">';
                    // Calculate the number of full stars (integer part of the rating)
                        $full_stars = intval($row['product__rating']);

                    // Calculate whether there should be a half-filled star
                        $half_star = ($row['product__rating'] - $full_stars) >= 0.5;    
                        echo str_repeat('<i class="fa fa-star checked" style="color: black;font-size:20px"></i>', $full_stars) . ($half_star ? '<i class="fa fa-star-half-alt checked" style="color: black;font-size:20px"></i>' : '').' ';

                        echo '<span style="color: black; font-weight: bold;font-size:19px">' . $row['product__rating'] . ' out of 5 stars</span>';
                    echo '</div><br>';
                    
                    echo '<div style="display: inline-block; padding: 5px; background-color: #f00; color: #fff;">';
                        
                    echo '</div><br>';

                    echo  '<p style="font-size:23px;font-weight:bold;color:white">'.$row['product__name'].'<p>';
                    
                    echo '<span style="color: bisque; font-weight: bold; font-size: 17px;">' . $row['product__description'] . '</span><br><br>';
                    echo '<span style="font-weight:bold;font-size:20px"> PRICE : ' .'Rs.'.$row['product__price'] . '</span><br>';
                    
                    echo '<input type="hidden" name="product__id" value="' . $row['product__id'] . '">';
                    echo '<input type="hidden" name="product__name" value="' . $row['product__name'] . '">';
                    echo '<input type="hidden" name="product__price" value="' . $row['product__price'] . '">';
                    echo '<input type="hidden" name="product__thumbnail" value="' . $row['product__thumbnail'] . '">';

                    echo '<label for="product_quantity" style="font-size:15px;font-weight:bold">QUANTITY :</label>';
                    echo '<input type="number" id="product__quantity" name="product__quantity" value="' . max(1, $row['product__quantity']) . '" min="1">';


                    echo '<div style="text-align: center;">';
                        echo '<input type="submit" class="register-button" style="color: #ff4757; background-color: bisque; font-size: 16px;" name="add_to_cart" value="Add to Cart">';

                    echo '</div>';
                echo '</div>';
                echo '</form>';
            }
        } else {
            echo '<p>No products available</p>';
        }
        ?>
       
    </section>

    <footer>
        <div class="footer-links">
            <p>All rights reserved. Designed by Bhargav</p>
        </div>
    </footer>

</body>
</html>

