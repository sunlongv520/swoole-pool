<?php

echo "当前进程ID:".posix_getpid().PHP_EOL; //获取了进程ID
cli_set_process_title("mymain"); //设置了进程名称

$child=new \Swoole\Process(function(){
    cli_set_process_title("mychild"); //设置了进程名称
    echo "我是一个子进程,ID=".posix_getpid().PHP_EOL;
    while(true) //写个死循环，让进程不退出
    {
        sleep(1);
    }
});
$child->start();

\Swoole\Process::wait();

while(true) //写个死循环，让进程不退出
{
    sleep(1);
}