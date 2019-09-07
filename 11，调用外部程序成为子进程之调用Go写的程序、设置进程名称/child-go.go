package main

import (
	"fmt"
	"os"
	"reflect"
	"time"
	"unsafe"
)

func main()  {
	SetProcessName("mychild go")
  for{
  	fmt.Println("shenyi")
  	time.Sleep(time.Second*3)
  }
}
func SetProcessName(name string) error {
	argv0str := (*reflect.StringHeader)(unsafe.Pointer(&os.Args[0]))
	argv0 := (*[1 << 30]byte)(unsafe.Pointer(argv0str.Data))[:argv0str.Len]

	n := copy(argv0, name)
	if n < len(argv0) {
		argv0[n] = 0
	}

	return nil
}