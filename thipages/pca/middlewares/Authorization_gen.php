<?php
namespace thipages\pca\middlewares\custom;
use thipages\pca\middlewares\Middleware;

class Authorization_gen extends Middleware {
    
    public function __construct() {
        parent::__construct(Middleware::authorization);
    }

    public function tableHandler($operation, $tableName) {
        return $tableName != 'license_keys';
    }

    public function columnHandler($operation, $tableName, $columnName) {
        return !($tableName == 'users' && $columnName == 'password');
    }

    public function recordHandler($operation, $tableName) {
        return ($tableName == 'users') ? 'filter=username,neq,admin' : '';
    }

    public function pathHandler($path) {
        return $path === 'openapi' ? false : true;
    }
}