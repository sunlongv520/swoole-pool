<?php


use Swoole\Process;

echo "当前进程ID:".posix_getpid().PHP_EOL; //获取了进程ID
cli_set_process_title("mymain"); //设置了进程名称


$child1=new Process(function(){
    //cli_set_process_title("mychild1"); //设置了进程名称
    $http=new \Swoole\Http\Server("0.0.0.0","80");
    $http->set([
        "worker_num"=>1
    ]);
    $http->on("request",function($req,$res){
       $res->end("myhttp");
    });
    $http->on("start",function($sever){
        cli_set_process_title("mymaster");
    });
    $http->on("managerstart",function($sever){
        cli_set_process_title("mymanager");
    });
    $http->on("workerstart",function($sever){
        cli_set_process_title("myworker");
    });
    $http->start();

});
$child1->start();



Process::signal(SIGCHLD, function($sig) {
    //必须为false，非阻塞模式
    while($ret =  Process::wait(false)) {
        var_dump($ret);
    }
});



