<!--start of php-->

<?php
// Declare the global variable outside of any PHP block
global $counter;

?>

<?php
session_start();

// Establish a connection to the MySQL database
$host = "localhost";
$username = "admin";
$password = "bhargav";
$database = "food-order";

$conn = new mysqli($host, $username, $password, $database);
if (!isset($_SESSION['cart'])) 
{
    $_SESSION['cart'] = array();
}
if ($conn->connect_error) 
{
    die("Connection failed: " . $conn->connect_error);
}

$sql = "SELECT * FROM cart";
$result = $conn->query($sql);


if (isset($_GET['action']) && $_GET['action'] == 'remove_item') 
{
    if (isset($_GET['id']))
    {
         $id = $_GET['id']; // Get the ID of the item to remove from the cart
        
        // Prepare SQL statement to delete the product from the database
        $delete_cart = "DELETE FROM cart WHERE id = $id";

        
        if ($conn->query($delete_cart) === TRUE) 
        {
            // Remove the item from the session cart
            echo "<script>alert('Product has been Removed from Shopping Cart')</script>";
            echo "<script>window.location = 'cart.php'</script>";
        } 
        else 
        {
            echo "Error deleting record: " . $conn->error;
        }
    }
}

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['update_button'])) 
{
    $id = $_POST['update_quantity_id'];
    $new_quantity = $_POST['update_quantity'];

    // Update the quantity in the database
    $sql = "UPDATE cart SET quantity = $new_quantity WHERE id = $id";
    if ($conn->query($sql) === TRUE) 
    {
        echo "<script>alert('Product quantity updated successfully.')</script>";
        echo "<script>window.location = 'cart.php'</script>";
    } 
    else 
    {
        echo "Error updating record: " . $conn->error;
    }
}


// Close the database connection
$conn->close();
?>


<!doctype html>

<html lang="en">


<head>


    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Cart</title>

    <!-- Font Awesome -->
    

    <!-- Bootstrap CDN -->
    

    


    <link rel="stylesheet" href="./css/style.css">

    
    
<style>




.product-info 
{
    display: flex;
    align-items: center;
}

.product-details {
    margin-right: 10px; /* Adjust as needed to create space between the image and details */
}

.product-details ul {
    list-style: none; /* Remove default list styles */
    padding: 5px;
    margin-left: 10px;
}

.product-details ul li {
    margin-bottom: 5px; /* Adjust as needed to create space between list items */
}

.product-price {
    margin-left: auto; /* Push the price to the right */
}

.button-link {
    display: inline-block;
    padding: 10px 10px;
    background-color: #ff6b81;
    color: white; /* White text color */
    text-align: center;
    text-decoration: none; /* Remove underline from links */
    border: none; /* Remove border */
    border-radius: 10px; /* Rounded corners */
    cursor: pointer; /* Change cursor to pointer on hover */
} 

.new-one{
    
    width: 10%;
    float: left;
    list-style-type: none;
    display: inline;
    padding: 0%;
    font-weight: bold;
    align-items: right;
}
</style>
</head>

<body style="background-color: ">

<script>
    function showAlert() {
    alert("Button clicked!");
}
</script>


    
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
                    <a href="cart.html">Cart</a>
                </li>
                <li>
                    <a href="login.html">Login</a>
                </li>
                
            </ul>
        </div>

        <div class="clearfix"></div>
    </div>
</section>

<br>
<br>

<div style="background-color: bisque;" class="container-fluid">
    <div class="row px-5 container">
        <div class="col-md-7 col-lg-6">
            <div class="shopping-cart">
                <h2>My Shopping Cart</h2>
                <hr>

                <?php

                    $total = 0;
                    
                    // Check if there are any rows returned
                    if ($result->num_rows > 0) 
                    {
                        // Loop through each row
                        $_SESSION['counter']=0;
                        while ($row = $result->fetch_assoc()) 
                        {
                            
                            // Increment the global variable
                            
                            $id = $row['id'];
                            $name = $row['name'];
                            $price = $row['price'];
                            $image = $row['image'];
                            $quantity = $row['quantity'];
                            $_SESSION['counter']+=$quantity;
                            $total += ($row['price']) * $quantity;    
                            // Now you can use these variables as needed
                            echo '<div class="product-info">';
                            echo '<img src="' . $image . '" alt="' . $name . '" width="190px" height="140px">';
                            echo '<div class="product-details">';
                            echo '<ul>';
                            echo '<li>In stock</li>';
                            echo '<li>Eligible for FREE Shipping</li>';
                            
                            echo '<form action="" method="post">';
                            echo '<label for="quantity" class="quantity">Quantity : </label>';
                            echo '<input type="hidden" name="update_quantity_id" value="' . $row['id'] . '">';
                            echo '&nbsp;';echo '&nbsp;';echo '&nbsp;';
                            echo '<input type="number" id="quantity" name="update_quantity" class="input-box" min="1" value="' . $row['quantity'] . '" style="width:70px;height:20px">';
                            echo '&nbsp;';echo '&nbsp;';echo '&nbsp;';
                            echo '<input type="submit" class="update-button" name="update_button" value="Update" style="color: blue; background-color: orange; font-size: 16px;">';
                            echo '</form>';


                        
                            echo '<form action="cart.php?action=remove_item&id=' . $id . '" method="POST">';
                            echo '<div>';
                                echo '<input type="submit" class="register-button" style="color: blue; background-color: orange; font-size: 16px;" name="remove_item" value="Remove">';
                            echo '</div>';
                            echo '</form>';
                            
                            echo '</div>';
                            

                            

                            echo'<div style=" font-family: Arial, Helvetica, sans-serif;font-size: 20px;">';
                            echo'<span>'.'Rs.'.$price.'</span>';
                            echo'</div>';

                           


                            echo'</div>';

                            echo  '<p style="font-size:16px;font-weight:bold;color:black">'.$row['name'].'<p>';
                            
                        }
                    } 
                    else 
                    {
                        echo "No items in the cart";
                    }
                    
                ?>

            </div>
        </div>

        <br>
<br>
        
        
        <div style="font-size: 30px;" class="ord-sum  col-lg-6">
        
            <div class="pt-4">
                <h5>Order Summary</h5>
                <hr>
                <div class="row price-details">
                    <div class="col-md-6">
                        <?php
                                                   
                            echo "<h6>Items : {$_SESSION['counter']}</h6>";    
                        ?>
                        
                        <h6>Delivery Charges: Free</h6>
                        <hr>
                        <h6>Amount Payable : Rs. <?php echo number_format($total, 2)?> </h6>

                        <div style="text-align: center;">
                            <form action="ord-conf.php" method="post">
                            <input type="submit" class="register-button" style="color: white; background-color: black; font-size: 18px;border-radius:10px;" value="Place Order">
                            </form>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </div>
</div>



<script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>
</body>
</html>
