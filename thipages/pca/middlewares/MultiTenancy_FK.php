<?php
namespace thipages\pca\middlewares\custom;
use thipages\pca\middlewares\Middleware;
use thipages\pca\Utils;

class MultiTenancy_FK extends Middleware {
    private $relations;
    private $user;
    public function __construct($relations, $user=['user','id','user_id']) {
        parent::__construct(Middleware::multiTenancy);
        $this->relations=$relations;
        $this->user=$user;
    }
    public function handler($operation,$tableName) {
        if (self::isAssociativeArray($this->relations)){
            if (isset($this->relations[$tableName])) {
                return [
                    $this->relations[$tableName] => Utils::session($this->user[0],$this->user[1])
                ];
            } else {
                return [];
            }
        } else if (in_array($tableName, $this->relations)){
            return [
                $this->user[2] => Utils::session($this->user[0],$this->user[1])
            ];
        } else {
            return [];
        }
    }
    private static function isAssociativeArray($array) {
        if (is_array($array))
            // check only is the first element has a key string
            foreach ($array as $k=>$v) return is_string($k);
        else
            return false;
    }
}