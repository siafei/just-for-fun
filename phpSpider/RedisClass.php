<?php
class RedisClass{
   private static $instances = array();
   //多进程使用同一个连接的话 会出错所以 一个进程对应一个连接
   public static function getInstance($pid){
        if(empty(self::$instances[$pid])){
            self::$instances[$pid] = new Redis() ;
            self::$instances[$pid]->connect('127.0.0.1','6379') ;
        }
        return self::$instances[$pid] ;
   }

   private function __construct(){
   }

   private function __clone(){
   }
}
?>
