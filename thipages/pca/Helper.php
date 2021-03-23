<?php
namespace thipages\pca;
use thipages\pca\IConfig;
use thipages\pca\middlewares\Middleware;

class Helper implements IConfig {
    private $config;
    public function __construct(...$iConfigList) {
        $packedMiddlewares=[];
        $this->config=[];
        /**
         * 1. Merge in $this->config associative arrays left
         * 2. Group (IConfig)Middleware extending children objects in $packedMiddlewares by name
         * 3. Merge in $this->config all other IConfig objects
         */
        foreach ($iConfigList as $iConfig) {
            if (is_array($iConfig)) {
                $this->config=array_merge($this->config,$iConfig);
            } else if (class_implements($iConfig,IConfig::class)){
                if (is_subclass_of($iConfig, Middleware::class)) {
                    $middlewareName=$iConfig->getName();
                    if (array_key_exists($middlewareName,$packedMiddlewares)) {
                        $packedMiddlewares[$middlewareName][]=$iConfig;
                    } else {
                        $packedMiddlewares[$middlewareName]=[$iConfig];
                    }
                } else {
                    $this->config=array_merge($this->config,$iConfig->getConfig());
                }
            } else {
                // todo?
            }
        }
        /**
         * For all grouped middlewares
         * 1. Group in $packedFunctions identical functions for future reducing
         * 2. put in $propertyList middleware properties (non functions)
         */
        foreach ($packedMiddlewares as $middlewareName=>$middlewares) {
            $packedFunctions=[];
            $propertyList=[];
            foreach($middlewares as $middleware) {
                $config=$middleware->getConfig();
                if (count($config)!==0) {
                    foreach ($config as $k => $v) {
                        if (is_callable($v)) {
                            if (array_key_exists($k, $packedFunctions)) {
                                $packedFunctions[$k][] = $v;
                            } else {
                                $packedFunctions[$k] = [$v];
                            }
                        } else {
                            $propertyList[$k] = $v;
                        }
                    }
                    foreach ($packedFunctions as $fullConfigName => $functions) {
                        $functionName=explode(':',$fullConfigName)[1];
                        $reducer = Middleware::allFunctions()[$middlewareName][$functionName];
                        $propertyList[$k] = function (...$args) use ($functions, $reducer) {
                            return $reducer($functions, $args);
                        };
                    }
                }
            }
            $this->config=array_merge($this->config,$propertyList);
            $this->config['middlewares']=array_keys($packedMiddlewares);
        }
    }
    public function getConfig() {
        return $this->config;
    }
}