<?php


namespace App\Libraries\Goyeer;
class GoVerify
{
    private static $instance = null;
    private function __construct(){}
    private function __clone(){}
    public static function getInstance()
    {
        if (self::$instance == null) {
            self::$instance = new self();
        }
        return self::$instance;
    }

    public  function validator($value,$rule='default',$rule_pattern=''){
        $pattern='';
        switch ($rule)
        {
            case 'char':
                $pattern='/^[A-Za-z0-9.\s]+$/';
                break;
            case 'number':
                $pattern='/^[0-9]*$/';
                break;
            case 'email':
                $pattern='/^([a-zA-Z0-9]+[_|\_|\.]?)*[a-zA-Z0-9]+@([a-zA-Z0-9]+[_|\_|\.]?)*[a-zA-Z0-9]+\.[a-zA-Z]{2,3}$/';
                break;
            case 'idcard':
                $pattern='/^\d{15}|\d{}18$/';
                break;
            case 'digit':
                $pattern='/^[1-9]\d*|0$/';
                break;
            case 'rule':
                $pattern=$rule_pattern;
                break;
            case 'password':
                $pattern='/^(?=.*\d)(?=.*[a-zA-Z])(?=.*[^a-zA-Z0-9]).{8,30}+$/';
                break;
            default:
                $pattern='/^[ ]+$/';
                break;
        }
        $return =preg_match($pattern,$value,$retval);
        return $return;
    }
}
