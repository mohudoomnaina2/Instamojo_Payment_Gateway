<?php
    if(isset($_POST["pay"])) {
        
        $name = $_POST['name'];
        $email = $_POST['email'];
        $phone = $_POST['phone'];
        $purpose = $_POST['purpose'];
        $amount = $_POST['amount'];

        include 'src/instamojo.php';


        $api = new Instamojo\Instamojo('Your_Api_key', 'Your_AuthToken', 'https://test.instamojo.com/api/1.1/');


        try {
            $response = $api->paymentRequestCreate(array(
                "purpose" => $purpose,
                "amount" => $amount,
                "send_email" => true,
                "email" => $email,
                "send_sms" => true,
                "phone" => $phone,
                "buyer_name" => $name,
                "allow_repeated_payments" => false,
                "redirect_url" => "http://localhost/payment_gateway/success.php",
                "webhook" => "http://localhost/payment_gateway/webhook.php"
                ));
            // print_r($response);
            $pay_ulr = $response['longurl'];
            header("Location: $pay_ulr");
            exit();
        }
        catch (Exception $e) {
            print('Error: ' . $e->getMessage());
        }
    }

?>

