<?php

return [
    "job1"=>[
        "cron"=> Cron\CronExpression::factory('* * * * *'),
        "func"=>function(){
            echo "job1".date("Y-m-d h:i").PHP_EOL;
        },
        "current"=>date("Y-m-d H:i"),
        "nth"=>0
    ],
    "job2"=>[
        "cron"=> Cron\CronExpression::factory('* * * * *'),
        "func"=>["/usr/bin/env",["php","./child1.php"]],
        "current"=>date("Y-m-d H:i"),
        "nth"=>0
    ],

];