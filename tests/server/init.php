<?php
require('./../../vendor/autoload.php');
require('./InitDB.php');

$init = new InitDB(
    'test.db',
    [
        'user' => [
            'username TEXT',
            'password TEXT'
        ],
        'note' => [
            'document TEXT',
            'user_id INTEGER NOT NULL #FK_user'
        ]
    ]
);
$init->execute();