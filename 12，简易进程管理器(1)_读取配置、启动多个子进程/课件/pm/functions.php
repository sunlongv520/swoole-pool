<?php
 function init(){
     $config=parse_ini_file("./pm/p.conf",true);
     $childs=$config['childs'];
     foreach ($childs as $key=>$value){
         $exec_params=explode(" ",$value);
         $p=new \Swoole\Process(function(\Swoole\Process $process) use($exec_params){
             $process->exec($exec_params[0],array_splice($exec_params,1));
         });
         $p->start();

     }
 }