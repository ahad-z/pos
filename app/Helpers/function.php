<?php

 function generateInvoiceNumber()
    {
        $number = uniqid();
        $varray = str_split($number);
        $len = sizeof($varray);
        $otp = array_slice($varray, $len-5, $len);
        $otp = implode(",", $otp);
        $otp = str_replace(',', '', $otp);
        return $otp;
    }

?>