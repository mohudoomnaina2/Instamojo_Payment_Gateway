
<?php

/*
Basic PHP script to handle Instamojo RAP webhook.
*/

$data = $_POST;
$mac_provided = $data['mac'];  // Get the MAC from the POST data
unset($data['mac']);  // Remove the MAC key from the data.
$ver = explode('.', phpversion());
$major = (int) $ver[0];
$minor = (int) $ver[1];
if($major >= 5 and $minor >= 4){
     ksort($data, SORT_STRING | SORT_FLAG_CASE);
}
else{
     uksort($data, 'strcasecmp');
}
// You can get the 'salt' from Instamojo's developers page(make sure to log in first): https://www.instamojo.com/developers
// Pass the 'salt' without <>
$mac_calculated = hash_hmac("sha1", implode("|", $data), "<YOUR_SALT>");
if($mac_provided == $mac_calculated){
    if($data['status'] == "Credit"){
        // Payment was successful, mark it as successful in your database.
        // You can acess payment_request_id, purpose etc here. 
      echo (
           $buyer_name = $data['buyer_name']
        .'<br>'.$email = $data['buyer']
        .'<br>'.$amt = $data['amount']
        .'<br>'.$purpose = $data['purpose']
        .'<br>'.$status = $data['status']
        .'<br>'.$pay_id = $data['payment_id']
        .'<br>'.$pay_req_id = $data['payment_request_id']
     );
    }
    else{
        // Payment was unsuccessful, mark it as failed in your database.
        // You can acess payment_request_id, purpose etc here.
        header('location: failed.php');
    }
}
else{
    echo "MAC mismatch";
}

?>