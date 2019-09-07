<?php
$processList=[];
 function init(){
     global $processList;
     $config=parse_ini_file(__DIR__."/p.conf",true);
     $childs=$config['childs'];
     foreach ($childs as $key=>$value){
         if(isset($processList[$key])) continue;
         $exec_params=explode(" ",$value);
         $p=new \Swoole\Process(function(\Swoole\Process $process) use($exec_params){
             $process->exec($exec_params[0],array_splice($exec_params,1));
         });
         $pid=$p->start();//用户自定义进程
         $processList[$key]=[
           "pid"=>$pid,
             "start"=>date("Y-m-d")
         ];

     }
 }
 //运行 核心子进程
 function initCore(){
     $watch_config=new \Swoole\Process(function(\Swoole\Process $process){
         cli_set_process_title("mymain watch");
         watchConfig();
     });
     $watch_config->start();
 }
function watchConfig(){
    $watchFile=__DIR__."/p.conf";
    $watchFile_md5=md5_file($watchFile);
    while (true){
        $getMd5=md5_file($watchFile);
        if(strcmp($watchFile_md5,$getMd5)!==0){
            //echo "文件发生了变动".PHP_EOL;
            \Swoole\Process::kill(posix_getppid(),SIGUSR1);
            $watchFile_md5=$getMd5;
        }
        sleep(2);
    }

}