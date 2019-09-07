<?php
date_default_timezone_set('PRC');//设置中国时区
require_once 'vendor/autoload.php';
use Swoole\Process;

$config=require(__DIR__."/crond/crond.config.php");

while(true){
    foreach($config as $key=>&$value){
        ["cron"=>$cron,"func"=>$func,"current"=>$current,"nth"=>$nth]=$value;
        $time=$cron->getNextRunDate($value["current"],$nth,true)->getTimestamp()-strtotime(date("Y-m-d H:i"));
        if($time===0){
            //执行业务逻辑
           $child=new Process(function(Process $process) use($func){
               if(is_callable($func)){
                   $func();
               }else if(is_array($func)){
                   $process->exec(...$func);
               }
           });
           $pid=$child->start();
           if($pid)
             $value['nth']=$value['nth']+1;
        }
    }
    sleep(1);
}



Process::signal(SIGCHLD, function($sig) {
    //必须为false，非阻塞模式
    while($ret =  Process::wait(false)) {
        //var_dump($ret);
    }
});







