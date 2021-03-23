<?php

namespace thipages\pca\middlewares\custom;
use thipages\pca\middlewares\Middleware;

class DbAuth extends Middleware {
    public const mode=           'mode';
    public const usersTable=     'usersTable';
    public const usernameColumn= 'usernameColumn';
    public const passwordColumn= 'passwordColumn';
    public const sessionName=    'sessionName';
    public const registerUser=   'registerUser';
    public const passwordLength= 'passwordLength|';
    public const returnedColumns='returnedColumns';
    private $config;
    public function __construct($config=[]) {
        parent::__construct(Middleware::dbAuth);
        $this->config=$config;
    }
    public function getConfig() {
        return $this->config;
    }
    public static function standard() {
        return [
            self::mode=>'required',
            self::usersTable=>'user',
            self::usernameColumn=>'username',
            self::passwordColumn=>'password',
            self::sessionName=>'user_id',
            self::registerUser=>'1',
            self::passwordLength=>'8',
            self::returnedColumns=>''
        ];
    }
}

