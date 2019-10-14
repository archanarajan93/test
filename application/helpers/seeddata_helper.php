<?php
if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class SeedData
{
    public static $ProductFinalizeMode = array( 
           "0" => "Auto",
           "1" => "Manual");
    public static $DcrWorkType = array(
            "0" => "Agency Work",
            "1" => "Other Income",
            "2" => "Copy+");
    public static $Groups = array(
            "5"  => "Field Promoter",
            "6"  => "ACM",
            "7"  => "Bureau",
            "8"  => "Union",
            "9"  => "Shakha",
            "10" => "Edition",
            "11" => "Route",
            "12" => "Dropping Point");
}
?>
