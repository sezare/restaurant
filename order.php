<?php include('partials-front/menu.php'); ?>

    <?php 
        //Check if the id is selected or not
        if(isset($_GET['food_id']))
        {
            //Get the details of the foods selected
            $food_id = $_GET['food_id']; 

            //Get the details of the selcted
            $sql = "SELECT * FROM tbl_food WHERE id=$food_id";
            //Execute the Query
            $res = mysqli_query($conn, $sql);

            //Count the rows
            $count = mysqli_num_rows($res);
            //Check if the data is available or not
            if($count==1)
            {
                //We have data
                //Get the data from the database
                $row = mysqli_fetch_assoc($res);

                $title = $row['title'];
                $price = $row['price'];
                $image_name = $row['image_name'];

            }
            else
            {
                //Food not Available
                //Redirect to home page
                header('location:'.SITEURL);
            }
        }
        else
        {
            //Redirect to home page
            header('location:'.SITEURL);
        }



    ?>

    <!-- fOOD sEARCH Section Starts Here -->
    <section class="food-search">
        <div class="container">
            
            <h2 class="text-center text-white">Fill this form to confirm your order.</h2>

            <form action="" method="POST" class="order">
                <fieldset>
                    <legend>Selected Food</legend>

                    <div class="food-menu-img">
                        <?php 
                            //Check if image is available or not
                            if($image_name=="")
                            {
                                //image not Available
                                echo "<div class'error'>Image not available</div>";
                            }
                            else
                            {
                                //image is available
                                ?>
                                 <img src="<?php echo SITEURL; ?>images/food/<?php echo $image_name; ?>" alt="Chicke Hawain Pizza" class="img-responsive img-curve">
                                <?php
                            }
                        
                        ?>
                       
                    </div>
    
                    <div class="food-menu-desc">
                        <h3><?php echo $title; ?></h3>
                        <input type="hidden" name="food" value="<?php echo $title; ?>">
                        <p class="food-price">N$<?php echo $price; ?></p>
                        <input type="hidden" name="price" value="<?php echo $price; ?>">

                        <div class="order-label">Quantity</div>
                        <input type="number" name="qty" class="input-responsive" value="1" required>

                        <div>Total:</div>
                        <input type="number" name="total" class="input-responsive" value="<?php echo $total; ?>">
                        
                         <div>Sub Total:</div>
                        <input type="number" name="total" class="input-responsive" value=""> 
                    
                    </div>

                </fieldset>
                
                <fieldset>
                    <legend>Delivery Details</legend>
                    <div class="order-label">Full Name</div>
                    <input type="text" name="full_name" placeholder="E.g. Sezare Miguel" class="input-responsive" required>

                    <div class="order-label">Phone Number</div>
                    <input type="tel" name="contact" placeholder="E.g. 081xxxxxx" class="input-responsive" required>

                    <div class="order-label">Email</div>
                    <input type="email" name="email" placeholder="E.g. micheal@gmail.com" class="input-responsive" required>

                    <div class="order-label">Address</div>
                    <textarea name="address" rows="10" placeholder="E.g. Erf, Street, Building, Location," class="input-responsive" required></textarea>

                    <input type="submit" name="submit" value="Submit Order" class="btn btn-primary">
                </fieldset>

            </form>

            <?php

                //Check if the form is submited or not
                if(isset($_POST['submit']))
                {
                    //Get all the details from the form
                    $food = $_POST['food'];
                    $price = $_POST['price'];
                    $qty = $_POST['qty'];

                    $total = $price * $qty + (15.00);// total is equall price times quantity
                    // $taxrate = 0.15; //This will give you the 15% tax
                    // $sub_total = $total * (1+$taxrate); //this is the whole amount icluding the tax(total + tax = selling price(cost))

                    $order_date = date("Y-m-d h:i:sa"); // Order date

                    $status = "Ordered"; //Oerderd, On Delivery, Delivered, Cancelled.
                    
                    $customer_name = $_POST['full_name'];
                    $customer_contact = $_POST['contact'];
                    $customer_email = $_POST['email'];
                    $customer_address = $_POST['address'];

                    //Save the order details in the database
                    //
                    $sql2 = "INSERT INTO tbl_order SET
                        food = '$food',
                        price = $price,
                        qty = $qty,
                        total = $total,
                        order_date = '$order_date',
                        status = '$status',
                        customer_name = '$customer_name',
                        customer_contact = '$customer_contact',
                        customer_email = '$customer_email',
                        customer_address = '$customer_address'
                    ";

                        //echo $sql2; die();
                    //Execute the query
                    $res2 = mysqli_query($conn, $sql2);

                    //Check if the query executed successfully or not
                    if($res2==true)
                    {
                        //Query executed and saved order
                        $_SESSION['order'] = "<div class='success text-center'>Food Ordered Successfully!</div>";
                        //Redirect to home page
                        header('location:'.SITEURL);
                    }
                    else
                    {
                        //Failed to save order
                        $_SESSION['order'] = "<div class='error text-center'>Failed to order Food</div>";
                         //Redirect to home page
                         header('location:'.SITEURL.'order.php');
                    }

                }


            ?>

        </div>
    </section>
    <!-- fOOD sEARCH Section Ends Here -->

  <?php include('partials-front/footer.php'); ?>