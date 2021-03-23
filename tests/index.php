<?php
use thipages\pca\DBConfig;
use thipages\pca\Helper;
use thipages\pca\middlewares\custom\Customization_upload;
use thipages\pca\middlewares\custom\MultiTenancy_FK;
use thipages\quick\QDb;

require ('./../vendor/autoload.php');
require('./../thipages/pca/IConfig.php');
require ('./../thipages/pca/Output.php');
require('./../thipages/pca/Utils.php');
require('./../thipages/pca/middlewares/base/Middleware.php');
require('./../thipages/pca/middlewares/MultiTenancy_FK.php');
require('./../thipages/pca/Helper.php');
require('./../thipages/pca/DBConfig.php');

$db=new QDb();
$def=$db->create(
    [
        'user'=>[
            'username TEXT #UNIQUE',
            'password TEXT '
        ],
        'message'=>[
            'content TEXT',
            'userId INTEGER NOT NULL #FK_user'
        ]
    ]
);
$cli=new \thipages\sqlitecli\SqliteCli('./test.db');
$cli->execute($def);