<?php
error_reporting(~0); ini_set('display_errors', 1);
include "db_conx.php";
include_once 'db_connect.php';
include_once 'functions.php';
sec_session_start();

if (login_check($mysqli) == true) {
    $logged = 'in';
    //empty cart by distroying current session
    if(isset($_GET["emptycart"]) && $_GET["emptycart"]==1)
    {
        $returnUrl = base64_decode($_GET["returnUrl"]); //return url
        unset($_SESSION['products']);
        header('Location:'.$returnUrl);
    }

    //add item in shopping cart
    if(isset($_POST["type"]) && $_POST["type"]=='add')
    {   
        print_r($_POST);
        $productCode   = filter_var($_POST["productCode"], FILTER_SANITIZE_STRING); //product code
        $productName   = filter_var($_POST["productName"], FILTER_SANITIZE_STRING); //product name
        $productQty    = 1; //product amt
        $price         = filter_var($_POST["price"], FILTER_SANITIZE_NUMBER_INT); // product price
        $returnUrl     = base64_decode($_POST["returnUrl"]); //return url
        
        //limit quantity for single product
        if($productQty > 10){
           // die('<div align="center">This demo does not allowed more than 10 quantity!<br /><a href="http://sanwebe.com/assets/paypal-shopping-cart-integration/">Back To Products</a>.</div>');
        }

        //prepare array for the session variable
        $newProduct = array(array('name'=>$productName, 'code'=>$productCode, 'qty'=>$productQty, 'price'=>$price));
        
        if(isset($_SESSION["products"])) //if we have the session
        {
            $found = false; //set found item to false
            
            foreach ($_SESSION["products"] as $cartItm) //loop through session array
            {
                if($cartItm["code"] == $productCode){ //the item exist in array
                    $productQty++;
                    $product[] = array('name'=>$cartItm["name"], 'code'=>$cartItm["code"], 'qty'=>$productQty, 'price'=>$cartItm["price"]);
                    $found = true;
                }else{
                    //item doesn't exist in the list, just retrive old info and prepare array for session var
                    $product[] = array('name'=>$cartItm["name"], 'code'=>$cartItm["code"], 'qty'=>1, 'price'=>$cartItm["price"]);
                }
            }
            
            if($found == false) //we didn't find item in array
            {
                //add new user item in array
                $_SESSION["products"] = array_merge($product, $newProduct);
                print_r($product);
                print_r($_SESSION);
            return $_SESSION['products'];
            }else{
                //found user item in array list, and increased the quantity
                $_SESSION["products"] = $product;
                print_r($product);
                print_r($_SESSION);
            return $_SESSION['products'];
            }
            
        }else{
            //create a new session var if does not exist
            $_SESSION["products"] = $newProduct;
            print_r($_SESSION['products']);
            return $_SESSION['products'];
        }
        
        //redirect back to original page
        //header('Location:'.$returnUrl);
        die();
    }

    //remove item from shopping cart
    if(isset($_GET["removep"]) && isset($_GET["returnUrl"]) && isset($_SESSION["products"]))
    {
        $productCode   = $_GET["removep"]; //get the product code to remove
        $returnUrl     = base64_decode($_GET["returnUrl"]); //get return url

        
        foreach ($_SESSION["products"] as $key => $cartItm) //loop through session array var
        {
            if($cartItm["code"]!=$productCode){ //item does't exist in the list
                $product[] = array('name'=>$cartItm["name"], 'code'=>$cartItm["code"], 'qty'=>$cartItm["qty"], 'price'=>$cartItm["price"]);
            } else {
                echo $key;
                unset ($_SESSION["products"][$key]);
                array_filter($_SESSION["products"]);
                if (empty($_SESSION["products"])) {
                    unset ($_SESSION["products"]);
                    array_filter($_SESSION);
                }
            }
            
            //create a new product list for cart
            //$_SESSION["products"] = $product;
        }
        
        //redirect back to original page
        header('Location:'.$returnUrl);
    }
} else {
    $logged = 'out';
    //echo $logged;
}