<?php 
ini_set("display_errors", "On");
error_reporting(E_ALL | E_STRICT);

require 'UserClass.php' ;
require 'RedisClass.php' ;
$cookie='d_c0="AIAAQAE0egqPTjLCM3AIisnpC8nZCEwAIC4=|1472779606"; _zap=c47f59e3-3dc1-49b1-b241-d0abafb29762; l_cap_id="NTQzZmNlNGE1NTk4NGE5NzhlZGUxYjRkOTNkNWYxNjA=|1481687551|eebec45fc06969afd5871e8a5e198cd70d2a127d"; cap_id="M2RmMTk3ZGYwNGFiNGMyYjhkN2JjMDJmYTYwMTFkN2Y=|1481687551|48eb20126d82cd2bf56359038cf0912d66bca1f7"; r_cap_id="YTExYjE4ZmE5MjhhNDdkY2I0YThhOWRhYTA5MjI3YzE=|1481687553|7e2a9aa74c4116df83965c0ee1b9e716b87b712a"; login="YjkzZmQ1MzkwOWJmNDM5MTkxYTQ3OWJkMDNiODhmYzU=|1481687715|64fe07ad06f2f582e0aeae04214c903414684905"; q_c1=e83e1ac4167744b399d58af60f840c17|1481756395000|1472779606000; z_c0=Mi4wQUFBQUNxb3JBQUFBZ0FCQUFUUjZDaGNBQUFCaEFsVk5vMDk0V0FEVmtmYVZFOW1MU2d3bG40c1BpaHdCVk1taWJn|1482461790|1ed193eb690d44323f352bae1a67da7c9ac0f706; __utmt=1; __utma=51854390.486158722.1482461986.1482461986.1482461986.1; __utmb=51854390.4.10.1482461986; __utmc=51854390; __utmz=51854390.1482461986.1.1.utmcsr=(direct)|utmccn=(direct)|utmcmd=(none); __utmv=51854390.100-1|2=registration_date=20140410=1^3=entry_date=20140410=1' ;
$redis = RedisClass::getinstance('1') ;
$user = UserClass::getinstances($cookie) ;
$sqli = new mysqli('127.0.0.1','root','123456','test');
function addUserdata($data){
		$sql = 'insert into user (user_token,followees,follows) values ("%s",%d,%d)' ;
		global $sqli ;
		$sql = sprintf($sql,$data['user_token'],$data['followees'],$data['follows']) ;
		$sqli->query($sql);
}
//var_dump($user->getFollowees('wang-lin-83-53','followers')) ;
//die ;

$redis->addUser('si-a-fei') ;
while(true){	
		$user_token = $redis->popUser() ;
		if(!$user_token){
				sleep(1) ;
				continue ;
		}
		$redis->addhasgot($user_token) ;
		$data = $user->getUserInfo($user_token) ;
		$sql_data['user_token'] = $user_token ;
		$sql_data['followees'] = $data[1] ;
		$sql_data['follows'] = $data[0] ;
		addUserdata($sql_data) ;
		$num = ceil($sql_data['follows']/10) ;
		for($i=0;$i<$num;$i++){
				$offset = $i*10 ;
				$followeeslist = $user->getFollowees($user_token,'followees',$offset) ;
				if($followeeslist){
						$listcount = count($followeeslist) ;
						for($l=0;$l<$listcount;$l++){
								if(!$redis->checkUser($followeeslist[$l]['url_token'])){
										$redis->addUser($followeeslist[$l]['url_token']) ;
								}
						}
				}
		}
		$num = ceil($sql_data['followees']/10) ;
		for($i=0;$i<$num;$i++){
				$offset = $i*10 ;
				$followerslist = $user->getFollowees($user_token,'followers',$offset) ;
				if($followerslist){
						$listcount = count($followerslist) ;
						for($l=0;$l<$listcount;$l++){
								if(!$redis->checkUser($followerslist[$l]['url_token'])){
										$redis->addUser($followerslist[$l]['url_token']) ;
							}
						}
				}
		}

}









?>
