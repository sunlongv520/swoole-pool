<?php

cli_set_process_title("mychild 1"); //设置了进程名称
while (true){
    echo "child1".PHP_EOL;
    sleep(5);
}
