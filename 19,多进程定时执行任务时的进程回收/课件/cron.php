<?php
date_default_timezone_set('PRC');//设置中国时区
require_once 'vendor/autoload.php';
use Swoole\Process;
$config=require(__DIR__."/crond/crond.config.php");

cli_set_process_title("master");
$manager=new Process(function(Process $process) use($config){
 cli_set_process_title("manager");
    while(true) {
        $keys = [];
        foreach ($config as $key => &$value) {
                ["cron" => $cron, "func" => $func, "current" => $current, "nth" => $nth] = $value;
                $time = $cron->getNextRunDate($value["current"], $nth, true)->getTimestamp() - strtotime(date("Y-m-d H:i"));
                if ($time === 0) {
                    $keys[] = $key;
                    $value['nth']=$value['nth']+1;
            }
            sleep(1);
        }
        if(count($keys)>0){
            $process->write(implode(",",$keys));
            Process::kill(posix_getppid(),SIGUSR1);
        }

    }
},false,1);
$manager->start();


Process::signal(SIGUSR1, function($sig) use($manager,$config) {
    $ret=$manager->read();
    $keys=explode(",",$ret);
    foreach ($keys as $key){
        {
            $c=$config[$key];
            $func=$c["func"];
            $child=new Process(function(Process $process) use($func){
                if(is_callable($func)){
                    $func();
                }else if(is_array($func)){
                    $process->exec(...$func);
                }
            });
            $child->start();
        }

    }
});




Process::signal(SIGCHLD, function($sig) {
    //必须为false，非阻塞模式
    while($ret =  Process::wait(false)) {
        //var_dump($ret);
    }
});









