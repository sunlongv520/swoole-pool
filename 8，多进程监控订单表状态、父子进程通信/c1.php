<?php
require "vendor/autoload.php";
use Swoole\Process;
use Swoole\Coroutine\Mysql as MySQL;
echo "当前进程ID:".posix_getpid().PHP_EOL; //获取了进程ID
cli_set_process_title("mymain"); //设置了进程名称


$child1=new Process(function(Process $p){
    cli_set_process_title("mychild"); //设置了进程名称
    $mysql=new MySQL();
    $conn=$mysql->connect(['host' => '192.168.29.1', 'user' => 'shenyi',
        'password' => '123123', 'database' => 'test',]);
    while(true){
        $sql="select * from orders where order_ispay=1 and order_notice=0 order by order_id desc limit 0,1";
        $rows=$mysql->query($sql);
        if($rows && count($rows)==1){
            $p->write($rows[0]["order_user"]);
        }
        sleep(3);
    }

},false,1,true);
$child1->start();

$child2=new Process(function(Process $p){  //这个是用来处理发送邮件
        while(true){
            usleep(0.5*1000*1000);
            $getUser=$p->read();
            if($getUser){
                echo "进程2得到用户名:".$getUser.PHP_EOL;
            }
        }
});
$child2->start();


while(true){
    $getUser=$child1->read();
    if($getUser){
        $child2->write($getUser);
    }
    usleep(0.5*1000*1000);
}

Process::signal(SIGCHLD, function($sig) {
    //必须为false，非阻塞模式
    while($ret =  Process::wait(false)) {
        //var_dump($ret);
    }
});





