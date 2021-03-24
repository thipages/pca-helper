# PCA-HELPER

PCA-HELPER tries to help to setup the configuration file used in [PHP-CRUD-API](https://github.com/mevdschee/php-crud-api) through the three PHP-CRUD-API installation contexts
- composer installation
- usage of api.include.php
- usage of api.php

by
- simplifying the database configuration through `setup_connection` and `setup_cache` methods
- simplifying the dbAuth configuration through `setup` method
- providing some middlewares tools (`upload`, `autoFK`),
- writing automatically `middlewares` configuration property


> **Drawback** : it adds some workload on the server compared to the native/original single file `api.php`.  May be a cli tool may be a good comprise one day...

## Installation
_composer require thipages/pca-helper_

## Usage

**Simple static call**
`Helper::echo($config);`

`$config` being a list of
- either regular associative arrays (as defined in PHP-CRUD-API)
```php
[
    'debug'=>true,
    'authorization.tableHandler' => function ($operation, $tableName) {
            return $tableName != 'user';
     }
]
```
- or static methods of predefined class (returning an associative array...)
```php
    Base::setup_connection(
        $database, $username, $password,
        $driver = 'mysql',$address='localhost',
        $port = null
    )
```
```php
    Base::setup_SQLite($filePath)
```
```php
    Base::setup_cache($cacheType = 'NoCache', $cacheTime = 10, $cachePath = null)
```
```php
    BdAuth::setup(
        $sessionName,
        $passwordLength=12, $mode='required',
        $usersTable='user',$usernameColumn='username',$passwordColumn='password', 
        $registerUser='1')
    // Note that dbAuth has a strong default setup
```
- or static handlers whose name method match the configuration key (by convention)
```php
[
    'multiTenancy.handler'=>AutoFK::multiTenancy_handler(
        $relations,
        $user=['user','id','user_id']
     )     
]
```
```php
[
    'customzation.beforeHandler'=>Upload::customzation_beforeHandler (
        $table, $field, $filesPath
    )     
]
```


## Example

```php
Helper::echo(
[
    Base::setup_SQLite($dbPath),
    Base::setup_cache(),
    DbAuth::setup('pca_helper',8),
    [
        'authorization.tableHandler' => function ($operation, $tableName) {
            return $tableName != 'user';
        },
        'multiTenancy.handler' => AutoFK::multiTenancy_handler(['note'=>'user_id']),
        'customzation.beforeHandler'=>function($operation, $tableName, $request, $environment) {
            $request= Upload::customzation_beforeHandler ($table, $field, $filesPath)(func_get_args());
            // ...
            return $request;
        },
        Base::debug=>true
    ]
]);
```










