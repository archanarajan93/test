<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');
abstract class Encode
{
    const IT=1;
    const=2;
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
   
   
}
?>