<?php
class RedisClass{
		private static $readygot='ready_user_token' ;
		private static $hasgot='hasgot_user_token' ;
		private static $instances = array();
		private $rediscon ;
		//多进程使用同一个连接的话 会出错所以 一个进程对应一个连接
		public static function getinstance($pid){
				if(empty(self::$instances[$pid])){
						self::$instances[$pid] = new self ;
						$ins = self::$instances[$pid] ;
						$ins->rediscon = new Redis() ;
						$ins->rediscon->connect('127.0.0.1','6379') ;
				}
				return self::$instances[$pid] ;
		}

		private function __construct(){
		}

		private function __clone(){
		}

		public function addUser($user_token){
				return $this->rediscon->sadd(self::$readygot,$user_token);  
		}

		public function popUser(){
				return  $this->rediscon->spop(self::$readygot) ;
		}

		public function addhasgot($user_token){
				return $this->rediscon->sadd(self::$hasgot,$user_token) ;
		}

		public function checkUser($user_token){
				if($this->rediscon->sismember(self::$hasgot,$user_token)){
						return true ;
				}
				return false ;
		}

}
?>
