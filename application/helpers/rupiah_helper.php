<?php
if (!defined('BASEPATH')) exit('No direct script access allowed');

if (!function_exists('clean_rupiah')) {
    function clean_rupiah($value)
    {
        return preg_replace("/[^0-9]/", "", $value);
    }
}
