<?php
namespace thipages\pca;
class Helper {
    public static function  mergeAll(...$config) {
        $all= self::flatenAssociativeArrays($config);
        $middlewareList=[];
        foreach ($all as $k=>$v) {
            if (strpos($k,'.')!==FALSE) $middlewareList[]=explode('.',$k)[0];            
        }
        if (count($middlewareList)!==0) $all['middlewares']=join(',',array_unique($middlewareList));
        return $all;
    }
    private static function flatenAssociativeArrays($a) {
        $res = [];
        foreach ($a as $k => $v) {
            if (is_array($v)) {
                $res = array_merge($res, self::flatenAssociativeArrays($v));
            } else if(!is_int($k)) {
                $res[$k] = $v;
            }
        }
        return $res;
    }
    public static function echo(...$config) {
        Output::echo(self::mergeAll($config));
    }
}