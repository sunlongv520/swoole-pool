<?php

cli_set_process_title("mychild 2"); //设置了进程名称
while (true){
    echo "child2".PHP_EOL;
    sleep(5);
}
