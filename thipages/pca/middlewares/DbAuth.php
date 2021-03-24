<?php
namespace thipages\pca\middlewares;
class DbAuth {
    public static function setup(
        $sessionName,
        $passwordLength=12,
        $mode='required',
        $usersTable='user',
        $usernameColumn='username',
        $passwordColumn='password',
        $registerUser='1') {
        return self::addPrefix('dbAuth',get_defined_vars());
    }
    private static function addPrefix ($prefix, $array) {
        $res = [];
        foreach ($array as $k=>$v) $res[$prefix.'.'.$k]=$v;
        return $res;
    }
}