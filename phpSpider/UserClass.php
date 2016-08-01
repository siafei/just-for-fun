<?php
class UserClass{
    private static $instance ;
    private static $cookie ;
    private static $useragent = 'Mozilla/5.0 (Macintosh; Intel Mac OS X 10_11_6) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/50.0.2661.102 Safari/537.36' ;
    public function getinstances($cookie){
        if(empty($instance)){
            self::$cookie = $cookie ;
            self::$instance = new self ; 
        }
        return self::$instance ;
    }
    // 获取用户信息
    public function getUserInfo($uname){
        $ch = curl_init('https://www.zhihu.com/people/'.$uname) ;
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_COOKIE, self::$cookie) ;
        curl_setopt($ch, CURLOPT_USERAGENT, self::$useragent);
        $info = curl_exec($ch) ;
        return $info ;
    }
    //获取用户关注着
    public function getFollowes(){
         $header[] = 'method:next' ;
         $header[] = 'params:{"offset":40,"order_by":"created","hash_id":"64e29e1315485906c1a2b610f7ab741d"}' ;
         $ch = curl_init('www.zhihu.com/node/ProfileFolloweesListV2') ;
         curl_setopt($ch, CURLOPT_AUTOREFERER, 'www.zhihu.com/people/si-a-fei/followees');
         curl_setopt($ch, CURLOPT_HTTPGET, 'next');
         curl_setopt($ch, CURLOPT_COOKIE, self::$cookie);
         curl_setopt($ch, CURLOPT_USERAGENT, self::$useragent);
         $info = curl_exec($ch) ;
         return $info ;
    }

    //获取用户关注了哪些人
    public function getFollowees($uname){
        $ch = curl_init('https://www.zhihu.com/people/'.$uname.'/followees') ;
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_COOKIE, self::$cookie);
        curl_setopt($ch, CURLOPT_USERAGENT, self::$useragent);
        $info = curl_exec($ch) ;
        return $info ;
    }
}

?>
