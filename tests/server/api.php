<?php

use thipages\pca\Base;
use thipages\pca\Helper;
use thipages\pca\middlewares\custom\AutoFK;
use thipages\pca\middlewares\DbAuth;
use thipages\pca\middlewares\Upload;

require('./../../vendor/autoload.php');
require('./../../thipages/pca/Output.php');
require('./../../thipages/pca/middlewares/AutoFK.php');
require('./../../thipages/pca/middlewares/DbAuth.php');
require('./../../thipages/pca/middlewares/Upload.php');
require('./../../thipages/pca/Helper.php');
require('./../../thipages/pca/Base.php');
require ('./InitDB.php');

$dbPath='./test.db';
$config=[
    Base::setup_SQLite($dbPath),
    Base::setup_cache(),
    DbAuth::setup('pca_helper',6),
    [
        'customization.beforeHandler'=>Upload::customzation_beforeHandler('note','document','./files'),
        'authorization.tableHandler' => function ($operation, $tableName) {
            return $tableName != 'user';
        },
        // todo : test with ['note'] only
        'multiTenancy.handler' => AutoFK::multiTenancy_handler(['note'=>'user_id']),
        Base::debug=>true
    ]
];
if (isset($_GET['reset_db'])) {
    // clean files directory
    array_map( 'unlink', array_filter((array) glob("./files/*") ) );
    $valid=InitDB::resetDb($dbPath);
    echo($valid?'ok':'nok');
} else {
    Helper::echo($config);
}

