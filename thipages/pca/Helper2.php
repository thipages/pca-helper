<?php


namespace thipages\pca;


use Tqdev\PhpCrudApi\Api;
use Tqdev\PhpCrudApi\Config;
use Tqdev\PhpCrudApi\RequestFactory;
use Tqdev\PhpCrudApi\ResponseUtils;

class Helper2 {
    const tables = 'tables';               // default: all
    const controllers = 'controllers';     // default: records,geojson,openapi,status
    const openApiBase = 'openApiBase';     // default: {"info":{"title":"PHP-CRUD-API","version":"1.0.0"}}
    const debug = 'debug';                 // default: false
    const basePath = 'basePath';           // default: determined using PATH_INFO    
    //
    private $config=[];
    public function __construct ($database, $username, $password, $driver='mysql', $port=null) {
        $args=get_defined_vars();
        if ($port===null) unset($args['port']);
        $this->merge($args);
    }
    private function merge($args) {
        $this->config=array_merge($this->config,$args);
    }
    public function add(...$args) {
        $this->merge($args);
        return $this;
    }
    public static function cache($cacheType='NoCache', $cacheTime=10, $cachePath=null) {
        $args=get_defined_vars();
        if ($cachePath===null) unset($args['cachePath']);
        return $args;
    }
    public static function dbAuth(
        $mode='required',
        $passwordLength='12',
        $usersTable='user',
        $usernameColumn='username',
        $passwordColumn='password',
        $sessionName='user_id',
        $registerUser='1',
        $returnedColumns=''
    ) { return get_defined_vars();}
    public static function customzation_upload ($table, $field, $filesPath) {
        return function ($operation, $tableName, $request, $environment) use($table, $field, $filesPath) {
            if ($tableName === $table) {
                $body = $request->getParsedBody();
                $value = $body->{$field};
                $uid = uniqid();
                file_put_contents($filesPath . DIRECTORY_SEPARATOR . $uid, base64_decode($value));
                $body->{$field} = $uid;
                return $request->withParsedBody($body);
            }
        };
    }
    public static function SQLite($filePath) {
        return new Helper2($filePath,'','','sqlite');
    }
    public function echo() {
        $request = RequestFactory::fromGlobals();
        $api = new Api(new Config($this->config));
        $response = $api->handle($request);
        ResponseUtils::output($response);
    }
}