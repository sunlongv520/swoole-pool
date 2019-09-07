<?php
$processList=[];

 function init(){//这个函数是主进程 执行的
     global $processList;
     $config=parse_ini_file(__DIR__."/p.conf",true);
     $childs=$config['childs'];//获取到进程配置
     foreach ($childs as $key=>$value){
         if(isset($processList[$key])) continue;
         $exec_params=explode(" ",$value);
         $p=new \Swoole\Process(function(\Swoole\Process $process) use($exec_params){
             $process->exec($exec_params[0],array_splice($exec_params,1));
         });
         $pid=$p->start();//用户自定义进程
         $processList[$key]=[
           "pid"=>$pid,
            "start"=>date("Y-m-d h:i:s")
         ];
     }
     rmProcess($childs);//删除多余进程
     writeProcessData();
 }
 function writeProcessData(){
     global $processList;
     $content=json_encode($processList);
     file_put_contents(__DIR__."/p.data",$content);
 }
//删除多余进程
function rmProcess($childs){
    global $processList;
    $plist=array_diff_key($processList,$childs);
    foreach ($plist as $pkey=>$pvalue){
        \Swoole\Process::kill($pvalue["pid"],SIGTERM);//停止指定子进程
        unset($processList[$pkey]);
    }
}
 //运行 核心子进程
 function initCore(){
     $watch_config=new \Swoole\Process(function(\Swoole\Process $process){
         cli_set_process_title("mymain watch");
         watchConfig();
     });
     $watch_config->start();
     $api_server=new \Swoole\Process(function(\Swoole\Process $process){
         $process->exec("/usr/bin/env",["php",__DIR__."/httpapi.php"]);
     });
     $api_server->start();

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