<?php

cli_set_process_title("mychild 3"); //设置了进程名称
while (true){
    echo "child3".PHP_EOL;
    sleep(5);
}
