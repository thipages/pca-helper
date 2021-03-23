<?php
namespace thipages\pca;
use Tqdev\PhpCrudApi\Api;
use Tqdev\PhpCrudApi\Config;
use Tqdev\PhpCrudApi\RequestFactory;
use Tqdev\PhpCrudApi\ResponseUtils;

class Output {
    public static function echo($config) {
        $request = RequestFactory::fromGlobals();
        $api = new Api(new Config($config));
        $response = $api->handle($request);
        ResponseUtils::output($response);
    }
}