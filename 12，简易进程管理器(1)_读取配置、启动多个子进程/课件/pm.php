<?php
require "vendor/autoload.php";
require "./pm/functions.php";
use Swoole\Process;
echo "当前进程ID:".posix_getpid().PHP_EOL; //获取了进程ID
cli_set_process_title("mymain"); //设置了进程名称

init();



Process::signal(SIGCHLD, function($sig) {
    //必须为false，非阻塞模式
    while($ret =  Process::wait(false)) {
        //var_dump($ret);
    }
});





