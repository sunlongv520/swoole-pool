<?php


use Swoole\Process;

echo "当前进程ID:".posix_getpid().PHP_EOL; //获取了进程ID
cli_set_process_title("mymain"); //设置了进程名称


$child1=new Process(function(){
    cli_set_process_title("mychild1"); //设置了进程名称
    while(true) //写个死循环，让进程不退出
        sleep(1);
});
$child1->start();

$child2=new Process(function(){
    cli_set_process_title("mychild2"); //设置了进程名称
});
$child2->start();



Process::signal(SIGCHLD, function($sig) {
    //必须为false，非阻塞模式
    while($ret =  Process::wait(false)) {
        var_dump($ret);
    }
});



