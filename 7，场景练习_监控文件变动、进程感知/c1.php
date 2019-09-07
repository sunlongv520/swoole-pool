<?php
require "vendor/autoload.php";
use Swoole\Process;
use Swoole\Coroutine\Mysql as MySQL;
echo "当前进程ID:".posix_getpid().PHP_EOL; //获取了进程ID
cli_set_process_title("mymain"); //设置了进程名称


$child1=new Process(function(){
    cli_set_process_title("mychild"); //设置了进程名称
    $mysql=new MySQL();
    $conn=$mysql->connect(['host' => '192.168.29.1', 'user' => 'shenyi', 'password' => '123123', 'database' => 'information_schema',]);
    $checkConnect="select 1";
    $checkProcessCount="select count(*) from information_schema.processlist";
    $checkThead="select * from information_schema.GLOBAL_STATUS where Variable_name like 'Thread%'";
    while(true){
        $checkResult[]=date('Y-m-d h:i:s');
        try{
            sleep(3);
            $mysql->query($checkConnect);
            $checkResult[]="检查连接正常";
            $res=$mysql->query($checkProcessCount);
            $checkResult[]="当前连接数: ".$res[0]["c"];

            $res=$mysql->query($checkThead);
            $checkResult[]="检查线程情况";
            foreach ($res as  $row){
                foreach($row as $key=>$value){
                    $checkResult[]=$key.":".$value;
                }
            }
            $checkResult[]="-----------------------------------------------";

            echo implode(PHP_EOL,$checkResult);
        }catch (Exception $exception){
            echo $exception->getMessage().PHP_EOL;
        }

    }





},false,0,true);
$child1->start();



Process::signal(SIGCHLD, function($sig) {
    //必须为false，非阻塞模式
    while($ret =  Process::wait(false)) {
        //var_dump($ret);
    }
});



