<?php
class UserClass{
    private static $instance ;
    private static $cookie ;
	private static $header ;
	public static function getinstances($cookie){
        if(empty($instance)){
            self::$cookie = $cookie ;
			self::setHeader(self::$cookie) ;
            self::$instance = new self ; 
        }
        return self::$instance ;
    }

	public function sendHttp($url,$method="get",$params=array()){
		$ch = curl_init() ;
		curl_setopt($ch,CURLOPT_URL,$url) ;
		//关掉证书认证
		curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
		curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);
		//设置已变量形式返回
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
		curl_setopt($ch,CURLOPT_HTTPHEADER,self::$header);
		switch($method){
			case "get":
				curl_setopt($ch,CURLOPT_HTTPGET,true);
				break ;
			case "post":
				curl_setopt($ch,CURLOPT_POST,true);
				curl_setopt($ch,CURLOPT_POSTFIELDS,$params);
				break ;
			case "delete":
				curl_setopt ($ch, CURLOPT_CUSTOMREQUEST, "DELETE");
				curl_setopt($ch, CURLOPT_POSTFIELDS,$params);
				break ;
			case "put":
				curl_setopt ($ch, CURLOPT_CUSTOMREQUEST, "PUT");
				curl_setopt($ch, CURLOPT_POSTFIELDS,$params);
				break ;
		}
		$response = curl_exec($ch);
		return $response ;
		curl_close($ch);
	}

	private static function setHeader($cookies){
		$cookie = "Cookie:".$cookies ;
		self::$header = array(
			$cookie,
			'Host:www.zhihu.com',
			'Referer:https://www.zhihu.com/',
			'User-Agent:Mozilla/5.0 (Windows NT 6.1; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/54.0.2840.99 Safari/537.36',
			'Upgrade-Insecure-Requests:1',
			'authorization:Bearer Mi4wQUFBQUNxb3JBQUFBZ0FCQUFUUjZDaGNBQUFCaEFsVk5vMDk0V0FEVmtmYVZFOW1MU2d3bG40c1BpaHdCVk1taWJn|1482134526|9bf60095e42eac0eed82c2bf9f436e3cfb273340'
		) ;	
	
	}



}

?>
