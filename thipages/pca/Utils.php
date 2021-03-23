<?php
namespace thipages\pca;
use Exception;
class Utils {
    public static function session(...$keys) {
        $s=$_SESSION;
        foreach ($keys as $key) {
            if (isset($s[$key])) {
                $s=$s[$key];
            } else {
                throw new Exception("Non Valid session key  : ".$key);
            }
        }
        return $s;
    }
    public static function flattenAssocArrays($a) {
        $res = [];
        foreach ($a as $k => $v) {
            if (is_array($v)) {
                $res = array_merge($res, self::flattenAssocArrays($v));
            } else if(!is_int($k)) {
                $res[$k] = $v;
            }
        }
        return $res;
    }
}