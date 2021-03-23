<?php
use thipages\pca\DBConfig;
use thipages\pca\Helper;
use thipages\pca\middlewares\custom\Customization_upload;
use thipages\pca\middlewares\custom\MultiTenancy_FK;
require ('./../vendor/autoload.php');
require('./../thipages/pca/IConfig.php');
require ('./../thipages/pca/Output.php');
require('./../thipages/pca/Utils.php');
require('./../thipages/pca/middlewares/base/Middleware.php');
require('./../thipages/pca/middlewares/MultiTenancy_FK.php');
require('./../thipages/pca/Helper.php');
require('./../thipages/pca/DBConfig.php');
$_SESSION['user']['id'] = 'todt';
$base64_tit='dGl0';
//
function test_multitenancy() {
    $fk1 = new MultiTenancy_FK([
        'user' => 'id_user'
    ]);
    $fk2 = new MultiTenancy_FK(['user']);

    $res1 = $fk1->getConfig()['multiTenancy:handler']('', 'user');
    $res2 = $fk2->getConfig()['multiTenancy:handler']('', 'user');
    print_r($res1);
    print_r($res2);
}
function test_multitenancy2() {
    $helper=new Helper([
        DBConfig::SQLite('./test.db'),
        DBConfig::cache(),
        new MultiTenancy_FK(['table1','table2'])
    ]);
    $config=$helper->getConfig();
    //print_r($config);
    if (isset($config['multiTenancy:handler'])) {
        print_r($config['multiTenancy:handler']('','table2'));
    } else {
        echo('nok');
    }
}
function test_customization() {
    $helper=new Helper(
        new MultiTenancy_FK(['table1','table2'])
    );
    $config=$helper->getConfig();
    if (isset($config['multiTenancy:handler'])) {
        print_r($config['multiTenancy:handler']('','table2'));
    } else {
        echo('nok');
    }
}
function test_upload() {
    $helper=new Helper([
        new Customization_upload('upload','image','./')
    ]);
    $config=$helper->getConfig();
    //print_r($config);
    if (isset($config['customization:beforeHandler'])) {
        print_r($config['customization:beforeHandler']('','upload'));
    } else {
        echo('nok');
    }
}
function test_dbConfig (){
    $helper=new Helper(
        DBConfig::SQLite('./test.db'),
        ['cache'=>'tit']
    );
    print_r($helper);    
}
test_dbConfig();
test_multitenancy();
test_multitenancy2();
//test_customization();
