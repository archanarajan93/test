<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');
abstract class Encode
{
    const Encrypt=1;
    const Decrypt=2;
}
abstract class MenuVisibility
{
    const Visible = 0;
    const Hide    = 1;
}
abstract class UserStatus
{
    const Active  = 0;
    const Disable = 1;
}
abstract class ResidenceStatus
{
    const Active  = 0;
    const Disable = 1;
}
abstract class Status
{
    const Active  = 0;
    const Disable = 1;
}
abstract class WorkType
{
    const Promoter  = 1;
    const Bureau = 2;
    const Internal_Work = 3;
}
abstract class GDNews
{
    const Yes  = 1;
    const No = 2;
}
abstract class AccountHeads
{
    const Credit = 0;
    const Debit  = 1;    
}
abstract class KeyboardPreference
{
    const Inscript = 0;
    const Verifone = 1;
}
abstract class PreferenceLanguage
{
    const Malayalam=0;
    const English=1;
}
abstract class ReportMode
{
    const Compact=0;
    const Detailed=1;
}
abstract class CanvassedBy
{
    const Agent=17;
    const Promoter=5;
    const ACM=6;
    const Staff=1;
    const Others=0;
}
abstract class ServicedBy
{
    const Agent=17;
    const Staff=1;
}
abstract class Wellwisher
{
    const Shakha=9;
    const ResAssociation=26;
    const Wellwisher=27;
}
abstract class EnrollType
{
    const Fresh=1;
    const Retain=2;
}
abstract class EnrollStatus
{
    const NotContacted=0;
    const Pending=1;
    const Approved=2;
    const Billed=3;
    const Rejected=4;
    const Started=5;
}
abstract class FinalizeType
{
    const Amendment="AMEND";
    const Bill="BILL";
    const Journal="JOUR";
    const Receipt="RCPT";
    const InitiateAmendments="INITAMEND";
}
abstract class BillType
{
    const OpeningBalance ="OPBAL";
    const Bill="BILL";
    const Journal="JOUR";
    const Receipt="RCPT";
    const SecurityContribution="SC";
    const Bonus="BONUS";
}
abstract class SCType
{
    const SecurityContribution="SC";
    const SecurityReceipts="SRCPT";
    const SecurityInterest="SINT";
}
abstract class BillTypeCode
{
    const OPBal=0;
    const Bill=1;
    const Journal=2;
    const Receipt=3;
    const SecurityContribution=5;
    const Bonus=6;
}
abstract class PayType
{
    const Cash=1;
    const Cheque=2;
    const Card=3;
    const DD=4;
}
abstract class PaymentMode
{
    const Direct=1;
    const Promoter=2;
    const Device=3;
}
abstract class ChequeType
{
    const Local=1;
    const OutStation=2;
}
abstract class OtherReceipts
{
    const Scheme="SCH";
    const Sponsor="SPO";
    const EK="EK";
}
abstract class CopyStatus
{
    const Started=0;
    const Paused=1;
    const Stopped=2;
}
class Enum
{
    public static function getConstant($class,$value)
    {
        $class = new ReflectionClass($class);
        $constants = array_flip($class->getConstants());
        return $constants[$value];
    }
    public static function getAllConstants($class) {
        $class = new ReflectionClass($class);
        return array_flip($class->getConstants());
    }
    public static function getAllValues($class) {
        $class = new ReflectionClass($class);
        return $class->getConstants();
    }
    public static function getValue($class,$property) {
        $class = new ReflectionClass($class);
        return $class->getStaticPropertyValue($property);
    }
    public static function getTZDateTime($date_time=null, $format=null){
        //$_COOKIE["USERTZ"]
        $tz = new DateTimeZone("Asia/Calcutta");
        $date = new DateTime($date_time ? $date_time : "now");
        $date->setTimezone($tz);
        return $date->format($format ? $format : "D, d-M-Y h:i A");
    }
    public static function encrypt_decrypt($action, $string, $secret_key, $secret_iv="SKY IS LIMIT") {
        $output = false;
        $encrypt_method = "AES-256-CBC";
        $key = hash('sha256', $secret_key);
        // iv - encrypt method AES-256-CBC expects 16 bytes - else you will get a warning
        $iv = substr(hash('sha256', $secret_iv), 0, 16);
        if ( $action == Encode::Encrypt ) {
            $output = openssl_encrypt($string, $encrypt_method, $key, 0, $iv);
            $output = base64_encode($output);
        } else if( $action == Encode::Decrypt ) {
            $output = openssl_decrypt(base64_decode($string), $encrypt_method, $key, 0, $iv);
        }
        return $output;
    }
    public static function numberFormat($num) {
        @setlocale(LC_MONETARY, 'en_IN');
        $number = function_exists('money_format') ? money_format('%!i', $num) : number_format($num);
        return explode(".",$number)[0];
    }
}
?>