<?php

function getCountryByPhone(string $phone)
{
    $phone = preg_replace("/[^0-9]/", '', $phone);

    $ch = curl_init("https://cdn.jsdelivr.net/gh/andr-04/inputmask-multi@master/data/phone-codes.json");
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
    curl_setopt($ch, CURLOPT_HEADER, false);
    $result = curl_exec($ch);
    curl_close($ch);
    $result = json_decode($result, JSON_UNESCAPED_UNICODE);
    if (count($result)) {
        foreach ($result as $arr) {
            $phone_code = preg_replace("/[^0-9]/", '', $arr['mask']);

            if ($phone_code == substr($phone, 0, strlen($phone_code))) {
                return $arr['name_ru'];
            }
        }
    }

    return 'Error - the country by phone number is not defined';
}

if (isset($_POST["phone"])) {
    $phone = $_POST["phone"];
    echo getCountryByPhone($phone);
} else {
    echo "Phone number field is empty!";
}
