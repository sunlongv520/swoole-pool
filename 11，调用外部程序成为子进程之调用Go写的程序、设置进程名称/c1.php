<?php
require "vendor/autoload.php";
use Swoole\Process;
use Swoole\Coroutine\Mysql as MySQL;
echo "当前进程ID:".posix_getpid().PHP_EOL; //获取了进程ID
cli_set_process_title("mymain"); //设置了进程名称


$child1=new Process(function(Process $p){
     //$p->exec("/usr/bin/env",['php','./child.php']);
    $p->exec("./child-go",[]);
},true,0,true);
$child1->start();

while(true){
    $ret=$child1->read();
    echo $ret;
    usleep(0.5*1000*1000);
}


Process::signal(SIGCHLD, function($sig) {
    //必须为false，非阻塞模式
    while($ret =  Process::wait(false)) {
        //var_dump($ret);
    }
});





