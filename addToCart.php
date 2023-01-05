
<?php
session_start();

mysql_connect ('localhost', 'Akram', '') or die (mysql_error());
mysql_select_db('cart'); 
$page=("index.php");

if (isset($_GET['add'])){
    $quantity = mysql_query('SELECT id, quantity FROM products WHERE id='. mysql_real_escape_string((int)$_GET['add']));
    while ($quantity_row = mysql_fetch_assoc($quantity)){
                if ($quantity_row['quantity']!=$_SESSION['cart_'.$_GET['add']]){
                    $_SESSION['cart_'.$_GET['add']]+='1';
        }   
    }
}

function products (){
    $get = mysql_query('SELECT * FROM products');
            while ($row = mysql_fetch_assoc($get)){
                    echo '<p>' .$row ['name']. '</br>'.$row['price'].'</br>'.$row['quantity'].'<br/>'.$row['description']. '<br/>'.'<a href="cart.php?add='.$row['id'].'">'.'Add to cart'.'</a>'.'</p>';
    }
}

//Corection on the function
// function cart () {
//     $total = 0;

//     if ($total==0) { //getting error Undefined variable
//         echo "your cart is empty!";
//     }
//End of the function cart correction

function cart ()    {
    foreach($_SESSION as $name => $value)   {
        if ($value>0)   {
            if (substr($name, 0,5)=='cart_')    {
                $id = substr($name, 5, (strlen ($name)-5));
                $get = mysql_query('SELECT id, name, price FROM products WHERE id='.mysql_real_escape_string((int)$id));
                while ($get_row = mysql_fetch_assoc($get))  {
                    $sub = $get_row ['price']*$value;
                    echo $get_row['name']  .  ' X ' . $value . ' @ &pound;' . number_format($get_row['price'], 2) . ' = ' . '&pound'.number_format($sub, 2). '<a href="cart.php?remove='.$id.'">'.'[REMOVE]'.'</a>'. '<a href="cart.php?add='.$id.'">'.'[ADD]'.'</a>'. '<a href="cart.php?delete='.$id.'">'.'[DELETE]'.'</a>';
                }       
            }
                $total += $sub; //getting error Undefined variable
        }
    }
if ($total==0) { //getting error Undefined variable
echo "your cart is empty!";
}
else {
echo 'Total: &pound;'. number_format($total, 2);
//PayPal Button here
}
}

if(isset($_GET['add'])){
    $_SESSION['cart_' .(int)$_GET['add']]+='1';
    header('Location: ' .$page);
}

if (isset($_GET['remove'])){
    $_SESSION['cart_' . (int)$_GET['remove']]--;
    header('Location: ' .$page);
}

if (isset($_GET['delete'])){
    $_SESSION['cart_' .(int)$_GET['delete']]='0';
    header('Location: ' .$page);
}

////The answer fromt the stackflow guru

while ($get_row = mysql_fetch_assoc($get))  {
    $sub = $get_row ['price']*$value;
    echo $get_row['name']  .  ' X ' . $value . ' @ &pound;' . number_format($get_row['price'], 2) . ' = ' . '&pound'.number_format($sub, 2). '<a href="cart.php?remove='.$id.'">'.'[REMOVE]'.'</a>'. '<a href="cart.php?add='.$id.'">'.'[ADD]'.'</a>'. '<a href="cart.php?delete='.$id.'">'.'[DELETE]'.'</a>';
    $total += $sub; //added it here

  
}

?>