<?php
class UserClass{
		private static $instance ;
		private static $cookie ;
		private static $header ;
		private $url = 'https://www.zhihu.com/api/v4/members/';
		private $getpara = '?per_page=10&include=data%5B%2A%5D.answer_count%2Carticles_count%2Cfollower_count%2Cis_followed%2Cis_following%2Cbadge%5B%3F%28type%3Dbest_answerer%29%5D.topics&limit=10&offset=' ;
		public static function getinstances($cookie){
				if(empty($instance)){
						self::$cookie = $cookie ;
						self::setHeader(self::$cookie) ;
						self::$instance = new self ; 
				}
				return self::$instance ;
		}


		private function sendHttp($url,$method="get",$header='',$params=array()){
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

		//获取用户数据
		private function getUserData($data){
				$data = json_decode($data,true) ;
				if(!empty($data['data'])){
						return $data['data'] ;
				}
				return false ;
		}

		private function getUserInfoFromData($data){
				//return htmlspecialchars($data) ;
				preg_match_all('/<div class="NumberBoard-value">(\d*)<\/div>/i',$data,$userinfo) ;
				return $userinfo[1] ;
		}



		//获取用户关注了被关注的列表
		public function getFollowees($user_token,$type='followees',$offset=0){
				$url = $this->url.$user_token.'/'.$type.$this->getpara.$offset ;
				$followees = $this->sendHttp($url) ;
				$followees = $this->getUserData($followees) ;
				if($followees){
						return $followees ;
				}
				return false ;
		}

		//获取用户信息 暂时返回 关注多少人 被关注多少人
		public function getUserInfo($user_token){
				$url = 'https://www.zhihu.com/people/'.$user_token.'/activities';
				$userinfo = $this->sendHttp($url) ;
				$userinfo = $this->getUserInfoFromData($userinfo) ;
				return $userinfo ;
		}

		//关注取消关注用户 type=1 关注
		public function doFollower($user_token,$type=1){
				$url = $this->url.$user_token.'/followers' ;
				if($type===1){
						$res = $this->sendHttp($url,'post');	
				}elseif($type===0){
						$res = $this->sendHttp($url,'delete');	
				}
				return $res ;
		}


}

?>
