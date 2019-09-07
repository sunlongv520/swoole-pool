<?php
date_default_timezone_set('PRC'); //设置中国时区
require_once 'vendor/autoload.php';


$config=[
    "job1"=>[
        "cron"=> Cron\CronExpression::factory('* * * * *'),
        "func"=>function(){
            echo "job1".date("Y-m-d h:i").PHP_EOL;
        },
        "current"=>date("Y-m-d H:i"),
        "nth"=>0
    ]
];
while(true){

    foreach($config as $key=>&$value){
        $cron=$value["cron"];
        $func=$value["func"];
        $current=$value["current"];
        $nth=$value['nth'];
        $time=$cron->getNextRunDate($value["current"],$nth,false)->getTimestamp()-strtotime(date("Y-m-d H:i"));
        if($time===0){
            //执行业务逻辑
            $func();
            $value['nth']=$value['nth']+1;
        }
    }


    sleep(1);
}


