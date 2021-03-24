<?php
namespace thipages\pca\middlewares;
class Upload {
    public static function customzation_beforeHandler ($table, $field, $filesPath) {
        return function ($operation, $tableName, $request, $environment) use($table, $field, $filesPath) {
            if ($tableName === $table) {
                $body = $request->getParsedBody();
                $value = $body->{$field};
                $uid = uniqid();
                // todo : manage fs errors
                file_put_contents($filesPath . DIRECTORY_SEPARATOR . $uid, base64_decode($value));
                $body->{$field} = $uid;
                return $request->withParsedBody($body);
            } else return $request;
        };
    }
}