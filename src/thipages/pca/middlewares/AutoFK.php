<?php
namespace thipages\pca\middlewares\custom;
use Exception;

class AutoFK {
    public static function multiTenancy_handler($relations,$user=['user','id','user_id']) {
        return function  ($operation,$tableName) use($relations,$user) {
            if (self::isAssociativeArray($relations)) {
                if (isset($relations[$tableName])) {
                    return [
                        $relations[$tableName] => self::session($user[0], $user[1])
                    ];
                } else {
                    return [];
                }
            } else if (in_array($tableName, $relations)) {
                $s=self::session($user[0], $user[1]);
                return $s===null?[]: [
                    $user[2] => self::session($user[0], $user[1])
                ];
            } else {
                return [];
            }
        };
    }
    private static function isAssociativeArray($array) {
        if (is_array($array))
            // check only is the first element has a key string
            foreach ($array as $k=>$v) return is_string($k);
        else
            return false;
    }
    public static function session(...$keys) {
        $s=$_SESSION;
        foreach ($keys as $key) {
            if (isset($s[$key])) {
                $s=$s[$key];
            } else {
                return null;
            }
        }
        return $s;
    }
}