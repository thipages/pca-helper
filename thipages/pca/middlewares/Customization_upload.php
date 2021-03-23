<?php
namespace thipages\pca\middlewares\custom;
use thipages\pca\middlewares\Middleware;
class Customization_upload extends Middleware {
    private $tableName;
    private $fieldName;
    private $filesPath;
    public function __construct($tableName, $fieldName_file, $filesPath) {
        parent::__construct(Middleware::customization);
        $this->tableName=$tableName;
        $this->filesPath=$filesPath;
        $this->fieldName=$fieldName_file;
    }
    public function beforeHandler ($operation, $tableName, $request, $environment) {
        if ($tableName===$this->tableName) {
            $body = $request->getParsedBody();
            $value=$body->{$fieldName};
            $uid=uniqid();
            file_put_contents($this->filesPath.DIRECTORY_SEPARATOR.$uid, base64_decode($value));
            $body->{$fieldName} = $uid;
            return $request->withParsedBody($body);
        }
    }
    /*public function afterHandler ($operation, $tableName, $request, $environment) {
        
    }*/
}