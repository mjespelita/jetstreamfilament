<?php

namespace App\Smark;

use GuzzleHttp\Client;

class Smark2
{
    // payments

    public static function paymongoCreatePaymentLink($paymentDetails)
    {

        /**
         *  let data = {
         *       "data":{
         *           "attributes": {
         *               "amount":10000,
         *               "description":"Sample Course",
         *               "remarks":"Your Paragraph text goes Lorem ipsum dolor sit amet, consectetur adipisicing elit. Autem dolore, alias, numquam enim ab voluptate id quam harum ducimus cupiditate similique quisquam et deserunt, recusandae. here"
         *           }
         *       }
         *   };
         *
         *   Api Link: https://api.mydomain.com/
         */

        $data = $paymentDetails;
        $client = new Client();

        // Check if 'amount' is numeric and convert to integer if it is
        if (isset($data['attributes']['amount']) && is_numeric($data['attributes']['amount'])) {
            $data['attributes']['amount'] = (int) $data['attributes']['amount'];
        }

        // Convert the data structure to a JSON string
        $jsonString = json_encode(["data" => $data], JSON_PRETTY_PRINT);

        $response = $client->request('POST', 'https://api.paymongo.com/v1/links', [
            'body' => $jsonString,
            'headers' => [
                'accept' => 'application/json',
                'authorization' => 'Basic c2tfbGl2ZV9EM2JMblZMVXlFQ01Wc0pHUWVrc2VGWjE6',
                'content-type' => 'application/json',
            ],
        ]);

        return $response->getBody();
    }

    public static function generateReceiptNumber() {
        $prefix = "REC"; // Prefix for the receipt number
        $date = date("Ymd"); // Current date in YYYYMMDD format
        $uniqueId = uniqid(); // Generate a unique identifier

        // Combine the prefix, date, and unique identifier to form the receipt number
        $receiptNumber = $prefix . $date . strtoupper($uniqueId);

        return $receiptNumber; // REC20240731A1B2C3D4E5F6
    }

    // Encrypter and Decrypter

    public static function encrypter($data, $key) {
        $cipher = "aes-256-cbc"; // Encryption method
        $iv = openssl_random_pseudo_bytes(openssl_cipher_iv_length($cipher)); // Generate a random initialization vector (IV)

        // Encrypt the data
        $encrypted = openssl_encrypt($data, $cipher, $key, 0, $iv);

        // Combine the IV and encrypted data for storage
        $encrypted = base64_encode($iv . $encrypted);

        return $encrypted;
    }

    public static function decrypter($data, $key) {
        $cipher = "aes-256-cbc"; // Encryption method

        // Base64 decode the encrypted data
        $data = base64_decode($data);

        // Extract the IV and encrypted data
        $iv_length = openssl_cipher_iv_length($cipher);
        $iv = substr($data, 0, $iv_length);
        $encrypted = substr($data, $iv_length);

        // Decrypt the data
        $decrypted = openssl_decrypt($encrypted, $cipher, $key, 0, $iv);

        return $decrypted;
    }
}
