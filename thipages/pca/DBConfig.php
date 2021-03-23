<?php
namespace thipages\pca;
use thipages\pca\Utils;

class DBConfig {
    const tables = 'tables';               // default: all
    const controllers = 'controllers';     // default: records,geojson,openapi,status
    const openApiBase = 'openApiBase';     // default: {"info":{"title":"PHP-CRUD-API","version":"1.0.0"}}
    const debug = 'debug';                 // default: false
    const basePath = 'basePath';           // default: determined using PATH_INFO    
    public static function connection($database, $username, $password, $driver='mysql', $port=null) {
        $args=get_defined_vars();
        if ($port===null) unset($args['port']);
        return $args;
    }
    public static function cache($cacheType='NoCache', $cacheTime=10, $cachePath=null) {
        $args=get_defined_vars();
        if ($cachePath===null) unset($args['cachePath']);
        return $args;       
    }
    public static function SQLite($filePath) {
        return self::connection($filePath,'','','sqlite');
    }
}