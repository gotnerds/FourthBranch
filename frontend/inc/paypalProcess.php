<?php
session_start();
include_once("paypalConfig.php");
include_once("paypal.class.php");

$paypalmode = ($PayPalMode=='sandbox') ? '.sandbox' : '';

if($_POST) //Post Data received from product list page.
{
    //Other important variables like tax, shipping cost
    $TotalTaxAmount     = 0;  //Sum of tax for all items in this order. 
    $HandalingCost      = 0;  //Handling cost for this order.
    $InsuranceCost      = 0;  //shipping insurance cost for this order.
    $ShippinDiscount    = 0; //Shipping discount for this order. Specify this as negative number.
    $ShippinCost        = 0; //Although you may change the value later, try to pass in a shipping amount that is reasonably accurate.

    //we need 4 variables from an item, Item Name, Item Price, Item Number and Item Quantity.
    $paypal_data = '';
    $ItemTotalPrice = 0;

    //loop through POST array
    foreach($_POST['item_name'] as $key=>$itmname)
    {
        //get actual product price from database using product code
       $product_code    = filter_var($_POST['item_code'][$key], FILTER_SANITIZE_STRING); 
        
        #$results = $mysqli->query("SELECT price FROM products WHERE product_code='$product_code' LIMIT 1");
        #$obj = $results->fetch_object();

        $paypal_data .= '&L_PAYMENTREQUEST_0_NAME'.$key.'='.urlencode($_POST['item_name'][$key]);
        $paypal_data .= '&L_PAYMENTREQUEST_0_NUMBER'.$key.'='.urlencode($_POST['item_code'][$key]);
#        $paypal_data .= '&L_PAYMENTREQUEST_0_AMT'.$key.'='.urlencode($obj->price);      
        $paypal_data .= '&L_PAYMENTREQUEST_0_AMT'.$key.'='.urlencode($_POST['item_price'][$key]);      
        $paypal_data .= '&L_PAYMENTREQUEST_0_QTY'.$key.'='. urlencode($_POST['item_qty'][$key]);
        
        // item price X quantity
        #$subtotal = ($obj->price*$_POST['item_qty'][$key]);
        $subtotal = ($_POST['item_price'][$key]*$_POST['item_qty'][$key]);
        
        //total price
        $ItemTotalPrice = ($ItemTotalPrice + $subtotal);
    }

    //parameters for SetExpressCheckout
    $padata =   '&METHOD=SetExpressCheckout'.
                '&RETURNURL='.urlencode($PayPalReturnURL ).
                '&CANCELURL='.urlencode($PayPalCancelURL).
                '&PAYMENTREQUEST_0_PAYMENTACTION='.urlencode("SALE").
                $paypal_data.               
                '&NOSHIPPING=0'. //set 1 to hide buyer's shipping address
                '&PAYMENTREQUEST_0_ITEMAMT='.urlencode($ItemTotalPrice).
                '&PAYMENTREQUEST_0_TAXAMT='.urlencode($TotalTaxAmount).
                '&PAYMENTREQUEST_0_SHIPPINGAMT='.urlencode($ShippinCost).
                '&PAYMENTREQUEST_0_HANDLINGAMT='.urlencode($HandalingCost).
                '&PAYMENTREQUEST_0_SHIPDISCAMT='.urlencode($ShippinDiscount).
                '&PAYMENTREQUEST_0_INSURANCEAMT='.urlencode($InsuranceCost).
                '&PAYMENTREQUEST_0_AMT='.urlencode($ItemTotalPrice).
                '&PAYMENTREQUEST_0_CURRENCYCODE='.urlencode($PayPalCurrencyCode).
                '&LOCALECODE=GB'. //PayPal pages to match the language on your website.
                '&LOGOIMG=http://thefourthbranch.gotnerds.com/images/logo.png'. //site logo
                '&CARTBORDERCOLOR=FFFFFF'. //border color of cart
                '&ALLOWNOTE=1';
                
                ############# set session variable we need later for "DoExpressCheckoutPayment" #######
                $_SESSION['ItemName']           =  $ItemName; //Item Name
                $_SESSION['ItemPrice']          =  $ItemPrice; //Item Price
                $_SESSION['ItemNumber']         =  $ItemNumber; //Item Number
                $_SESSION['ItemDesc']           =  $ItemDesc; //Item description
                $_SESSION['ItemQty']            =  $ItemQty; // Item Quantity
                $_SESSION['ItemTotalPrice']     =  $ItemTotalPrice; //total amount of product; 
                $_SESSION['TotalTaxAmount']     =  $TotalTaxAmount;  //Sum of tax for all items in this order. 
                $_SESSION['HandalingCost']      =  $HandalingCost;  //Handling cost for this order.
                $_SESSION['InsuranceCost']      =  $InsuranceCost;  //shipping insurance cost for this order.
                $_SESSION['ShippinDiscount']    =  $ShippinDiscount; //Shipping discount for this order. Specify this as negative number.
                $_SESSION['ShippinCost']        =   $ShippinCost; //Although you may change the value later, try to pass in a shipping amount that is reasonably accurate.
                $_SESSION['GrandTotal']         =  $GrandTotal;


        //We need to execute the "SetExpressCheckOut" method to obtain paypal token
        $paypal= new MyPayPal();
        $httpParsedResponseAr = $paypal->PPHttpPost('SetExpressCheckout', $padata, $PayPalApiUsername, $PayPalApiPassword, $PayPalApiSignature, $PayPalMode);
        
        //Respond according to message we receive from Paypal
        if("SUCCESS" == strtoupper($httpParsedResponseAr["ACK"]) || "SUCCESSWITHWARNING" == strtoupper($httpParsedResponseAr["ACK"]))
        {

                //Redirect user to PayPal store with Token received.
                $paypalurl ='https://www'.$paypalmode.'.paypal.com/cgi-bin/webscr?cmd=_express-checkout&token='.$httpParsedResponseAr["TOKEN"].'';
                header('Location: '.$paypalurl);
             
        }else{
            //Show error message
            echo '<div style="color:red"><b>Error : </b>'.urldecode($httpParsedResponseAr["L_LONGMESSAGE0"]).'</div>';
            echo '<pre>';
            print_r($httpParsedResponseAr);
            echo '</pre>';
        }

}

//Paypal redirects back to this page using ReturnURL, We should receive TOKEN and Payer ID
if(isset($_GET["token"]) && isset($_GET["PayerID"]))
{
    //we will be using these two variables to execute the "DoExpressCheckoutPayment"
    //Note: we haven't received any payment yet.
    
    $token = $_GET["token"];
    $payer_id = $_GET["PayerID"];
    
    //get session variables
    $ItemName           = $_SESSION['ItemName']; //Item Name
    $ItemPrice          = $_SESSION['ItemPrice'] ; //Item Price
    $ItemNumber         = $_SESSION['ItemNumber']; //Item Number
    $ItemDesc           = $_SESSION['ItemDesc']; //Item Number
    $ItemQty            = $_SESSION['ItemQty']; // Item Quantity
    $ItemTotalPrice     = $_SESSION['ItemTotalPrice']; //total amount of product; 
    $TotalTaxAmount     = $_SESSION['TotalTaxAmount'] ;  //Sum of tax for all items in this order. 
    $HandalingCost      = $_SESSION['HandalingCost'];  //Handling cost for this order.
    $InsuranceCost      = $_SESSION['InsuranceCost'];  //shipping insurance cost for this order.
    $ShippinDiscount    = $_SESSION['ShippinDiscount']; //Shipping discount for this order. Specify this as negative number.
    $ShippinCost        = $_SESSION['ShippinCost']; //Although you may change the value later, try to pass in a shipping amount that is reasonably accurate.
    $GrandTotal         = $_SESSION['GrandTotal'];

    $padata =   '&TOKEN='.urlencode($token).
                '&PAYERID='.urlencode($payer_id).
                '&PAYMENTREQUEST_0_PAYMENTACTION='.urlencode("SALE").
                
                //set item info here, otherwise we won't see product details later  
                '&L_PAYMENTREQUEST_0_NAME0='.urlencode($ItemName).
                '&L_PAYMENTREQUEST_0_NUMBER0='.urlencode($ItemNumber).
                '&L_PAYMENTREQUEST_0_DESC0='.urlencode($ItemDesc).
                '&L_PAYMENTREQUEST_0_AMT0='.urlencode($ItemPrice).
                '&L_PAYMENTREQUEST_0_QTY0='. urlencode($ItemQty).

                /* 
                //Additional products (L_PAYMENTREQUEST_0_NAME0 becomes L_PAYMENTREQUEST_0_NAME1 and so on)
                '&L_PAYMENTREQUEST_0_NAME1='.urlencode($ItemName2).
                '&L_PAYMENTREQUEST_0_NUMBER1='.urlencode($ItemNumber2).
                '&L_PAYMENTREQUEST_0_DESC1=Description text'.
                '&L_PAYMENTREQUEST_0_AMT1='.urlencode($ItemPrice2).
                '&L_PAYMENTREQUEST_0_QTY1='. urlencode($ItemQty2).
                */

                '&PAYMENTREQUEST_0_ITEMAMT='.urlencode($ItemTotalPrice).
                '&PAYMENTREQUEST_0_TAXAMT='.urlencode($TotalTaxAmount).
                '&PAYMENTREQUEST_0_SHIPPINGAMT='.urlencode($ShippinCost).
                '&PAYMENTREQUEST_0_HANDLINGAMT='.urlencode($HandalingCost).
                '&PAYMENTREQUEST_0_SHIPDISCAMT='.urlencode($ShippinDiscount).
                '&PAYMENTREQUEST_0_INSURANCEAMT='.urlencode($InsuranceCost).
                '&PAYMENTREQUEST_0_AMT='.urlencode($GrandTotal).
                '&PAYMENTREQUEST_0_CURRENCYCODE='.urlencode($PayPalCurrencyCode);
    
    //We need to execute the "DoExpressCheckoutPayment" at this point to Receive payment from user.
    $paypal= new MyPayPal();
    $httpParsedResponseAr = $paypal->PPHttpPost('DoExpressCheckoutPayment', $padata, $PayPalApiUsername, $PayPalApiPassword, $PayPalApiSignature, $PayPalMode);
    
    //Check if everything went ok..
    if("SUCCESS" == strtoupper($httpParsedResponseAr["ACK"]) || "SUCCESSWITHWARNING" == strtoupper($httpParsedResponseAr["ACK"])) 
    {

            echo '<h2>Success</h2>';
            echo 'Your Transaction ID : '.urldecode($httpParsedResponseAr["PAYMENTINFO_0_TRANSACTIONID"]);
            
                /*
                //Sometimes Payment are kept pending even when transaction is complete. 
                //hence we need to notify user about it and ask him manually approve the transiction
                */
                
                if('Completed' == $httpParsedResponseAr["PAYMENTINFO_0_PAYMENTSTATUS"])
                {
                    echo '<div style="color:green">Payment Received! Your product will be sent to you very soon!</div>';
                }
                elseif('Pending' == $httpParsedResponseAr["PAYMENTINFO_0_PAYMENTSTATUS"])
                {
                    echo '<div style="color:red">Transaction Complete, but payment is still pending! '.
                    'You need to manually authorize this payment in your <a target="_new" href="http://www.paypal.com">Paypal Account</a></div>';
                }

                // we can retrive transection details using either GetTransactionDetails or GetExpressCheckoutDetails
                // GetTransactionDetails requires a Transaction ID, and GetExpressCheckoutDetails requires Token returned by SetExpressCheckOut
                $padata =   '&TOKEN='.urlencode($token);
                $paypal= new MyPayPal();
                $httpParsedResponseAr = $paypal->PPHttpPost('GetExpressCheckoutDetails', $padata, $PayPalApiUsername, $PayPalApiPassword, $PayPalApiSignature, $PayPalMode);

                if("SUCCESS" == strtoupper($httpParsedResponseAr["ACK"]) || "SUCCESSWITHWARNING" == strtoupper($httpParsedResponseAr["ACK"])) 
                {
                    
                    echo '<br /><b>Stuff to store in database :</b><br /><pre>';
                    /*
                    #### SAVE BUYER INFORMATION IN DATABASE ###
                    //see (http://www.sanwebe.com/2013/03/basic-php-mysqli-usage) for mysqli usage
                    
                    $buyerName = $httpParsedResponseAr["FIRSTNAME"].' '.$httpParsedResponseAr["LASTNAME"];
                    $buyerEmail = $httpParsedResponseAr["EMAIL"];
                    
                    //Open a new connection to the MySQL server
                    $mysqli = new mysqli('host','username','password','database_name');
                    
                    //Output any connection error
                    if ($mysqli->connect_error) {
                        die('Error : ('. $mysqli->connect_errno .') '. $mysqli->connect_error);
                    }       
                    
                    $insert_row = $mysqli->query("INSERT INTO BuyerTable 
                    (BuyerName,BuyerEmail,TransactionID,ItemName,ItemNumber, ItemAmount,ItemQTY)
                    VALUES ('$buyerName','$buyerEmail','$transactionID','$ItemName',$ItemNumber, $ItemTotalPrice,$ItemQTY)");
                    
                    if($insert_row){
                        print 'Success! ID of last inserted record is : ' .$mysqli->insert_id .'<br />'; 
                    }else{
                        die('Error : ('. $mysqli->errno .') '. $mysqli->error);
                    }
                    
                    */
                    
                    echo '<pre>';
                    print_r($httpParsedResponseAr);
                    echo '</pre>';
                } else  {
                    echo '<div style="color:red"><b>GetTransactionDetails failed:</b>'.urldecode($httpParsedResponseAr["L_LONGMESSAGE0"]).'</div>';
                    echo '<pre>';
                    print_r($httpParsedResponseAr);
                    echo '</pre>';

                }
    
    }else{
            echo '<div style="color:red"><b>Error : </b>'.urldecode($httpParsedResponseAr["L_LONGMESSAGE0"]).'</div>';
            echo '<pre>';
            print_r($httpParsedResponseAr);
            echo '</pre>';
    }
}
?>