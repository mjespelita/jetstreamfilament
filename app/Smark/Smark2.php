<?php

namespace App\Smark;

use DateInterval;
use DatePeriod;
use DateTime;
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

    public static function toCamelCase($string) {
        $result = strtolower($string);
        preg_match_all('/[a-zA-Z0-9]+/', $result, $matches);
        $result = '';
        foreach ($matches[0] as $match) {
            $result .= ucfirst($match);
        }
        return lcfirst($result);
    }

    public static function truncateString($string, $length) {
        if (strlen($string) > $length) {
            return substr($string, 0, $length) . '...';
        }
        return $string;
    }

    public static function flattenArray($array) {
        $result = [];
        array_walk_recursive($array, function($a) use (&$result) { $result[] = $a; });
        return $result;
    }

    public static function uniqueMultidimensionalArray($array, $key) {
        $temp_array = [];
        $i = 0;
        $key_array = [];

        foreach ($array as $val) {
            if (!in_array($val[$key], $key_array)) {
                $key_array[$i] = $val[$key];
                $temp_array[$i] = $val;
            }
            $i++;
        }
        return $temp_array;
    }

    public static function calculateAge($dob) {
        $birthDate = new DateTime($dob);
        $currentDate = new DateTime();
        return $currentDate->diff($birthDate)->y;
    }

    public static function humanReadableDate($date) {
        return date('F j, Y (l) g:i a', strtotime($date));
    }

    public static function sanitizeInput($input) {
        return htmlspecialchars(strip_tags($input));
    }

    public static function factorial($number) {
        if ($number < 2) {
            return 1;
        } else {
            return ($number * self::factorial($number - 1));
        }
    }

    public static function fibonacci($n) {
        if ($n <= 1) return $n;
        return self::fibonacci($n - 1) + self::fibonacci($n - 2);
    }

    public static function generateSlug($string) {
        return strtolower(trim(preg_replace('/[^A-Za-z0-9-]+/', '-', $string)));
    }

    public static function getWeekdays($startDate, $endDate) {
        $period = new DatePeriod(
            new DateTime($startDate),
            new DateInterval('P1D'),
            new DateTime($endDate)
        );

        $weekdays = [];
        foreach ($period as $date) {
            if (!in_array($date->format('N'), [6, 7])) {
                $weekdays[] = $date->format('Y-m-d');
            }
        }
        return $weekdays;
    }
}
