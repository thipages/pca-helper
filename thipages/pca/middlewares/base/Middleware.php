<?php
namespace thipages\pca\middlewares;
use Nyholm\Psr7\Request;
use Nyholm\Psr7\Response;
use thipages\pca\IConfig;
use Tqdev\PhpCrudApi\ResponseFactory;

abstract class Middleware implements IConfig {
    const multiTenancy='multiTenancy';
    const customization='customization';
    const authorization='authorization';
    const dbAuth='dbAuth';
    private static $middlewares_functions=null;
    protected $name;
    public function __construct($name) {
        $this->name = $name;
    }
    // todo : manage properties in addition to functions
    public function getConfig() {
        $c=[];
        $params=self::allFunctions()[$this->name];
        foreach ($params as $functionName=>$function) {
            if (method_exists($this,$functionName)) $c[$this->name.':'.$functionName]= array($this,$functionName); // method reference           
        }
        return $c;
    }
    public function getName() {
        return $this->name;
    }
    public static function allFunctions() {
        if (self::$middlewares_functions===null) {
            self::$middlewares_functions=[
                self::multiTenancy=> [
                    'handler'=> function ($fs,$args) {
                        $m=[];
                        foreach($fs as $f) $m=array_merge($m,$f(...$args));
                        return $m;
                    }
                ],
                self::customization=> [
                    'beforeHandler'=> self::customization_beforeHandler(),
                    'afterHandler'=> self::customization_afterHandler()
                ]
            ];
        }
        return self::$middlewares_functions;
    }
    private static function customization_afterHandler() {
        return function ($fs,$args) {
            $i=0;
            foreach($fs as $f) {
                $i++;
                $res=$f(...$args);
                // if no return value or returns null, continue iterating
                if ($res!==null) {
                    if (is_bool($res)) {
                        // Continue iterating if returns a boolean, unless false
                        if (!$res) return ResponseFactory::fromObject(409, ['code' => 10000, 'message' => "afterHandler failed at stage $i/" . count($fs)]);
                    } else if (is_a($res, Response::class)) {
                        // stops iterating if returning a response
                        return $res;
                    }
                }
            }
        };
    }
    private static function customization_beforeHandler() {
        return function ($fs,$args) {
            $i=0;
            foreach($fs as $f) {
                $i++;
                $res=$f(...$args);
                // if no return value or returns null, continue iterating
                if ($res!==null) {
                    if (is_bool($res)) {
                        // Continue iterating if returns a boolean, unless false
                        if (!$res) return ResponseFactory::fromObject(409, ['code' => 10000, 'message' => "beforeHandler failed at stage $i/" . count($fs)]);
                    } else if (is_a($res, Request::class)) {
                        // stops iterating if returning a response
                        return $res;
                    }
                }
            }
        };
    }
    
}