<?php

echo "当前进程ID:".posix_getpid().PHP_EOL; //获取了进程ID
cli_set_process_title("mymain"); //设置了进程名称

$child=new \Swoole\Process(function(){
    cli_set_process_title("mychild"); //设置了进程名称

    while(true) //写个死循环，让进程不退出
    {
        echo "my name is";
        sleep(1);
    }
},true);
$child->start();


\Swoole\Process::wait(false);

while(true) //写个死循环，让进程不退出
{
    echo $child->read()." shenyi".PHP_EOL;
    sleep(1);
}