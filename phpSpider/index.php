<?php 
require 'RedisClass.php' ;
require 'UserClass.php' ;
$cookie = 'q_c1=db7d8b9ceac749de90f400c268567949|1467882414000|1467882414000; l_cap_id="ZmJkOWM1YzVhNmZlNGJmNWFkODQxNjQ0MWU5MDA1YmQ=|1467882414|83368f7b76bad7c745cd8295c7230533c1d1e92e"; cap_id="MTUxMTI5ZmFkNTI2NDVlMjlkNzI5Y2FiY2RlOTRiZjY=|1467882414|7174ce6adba2ffd9fca2aeb081fd3d2b796e7e2f"; d_c0="ADCAH7Q6MQqPTuzXKW5_GJ6LAuriPlV-YW4=|1467882414"; _zap=c2bb6eb8-c5b8-4b5f-8814-5807eee503e9; _za=4b3db9a1-23b4-4e16-9df7-b122d14aefc7; login="OGUxMTczNTFhZWYxNDgxNWJkNWE5NjdhMWM0NjA4YTM=|1467882429|9b5d67a6ac11820ef4ab175eb854c35240415d95"; z_c0=Mi4wQUFBQUNxb3JBQUFBTUlBZnREb3hDaGNBQUFCaEFsVk52YWlsVndBa3Z5WThwb2tXODRTMlRQS1V3RDVkZGFySElB|1467882429|ddb28ffef22ca95747e9197b5348b13eec7cd49d; _xsrf=8df0cd106b3ba9770e92529480f85934; s-q=%E8%8B%8F%E5%9B%BD%E6%94%BF; s-i=1; sid=5j1rhou9; s-t=autocomplete; a_t="2.0AAAACqorAAAXAAAAr3HGVwAAAAqqKwAAADCAH7Q6MQoXAAAAYQJVTb2opVcAJL8mPKaJFvOEtkzylMA-XXWqxyAOrIOXht6LEE1V_-dHAfLPUJMPbA=="; __utmt=1; __utma=51854390.628905948.1469690075.1470018438.1470031038.7; __utmb=51854390.4.10.1470031038; __utmc=51854390; __utmz=51854390.1469698784.2.2.utmcsr=baidu|utmccn=(organic)|utmcmd=organic; __utmv=51854390.100-1|2=registration_date=20140410=1^3=entry_date=20140410=1' ;

$user = UserClass::getinstances($cookie) ;
$info = $user->getFollowes() ;
echo htmlspecialchars($info) ;



?>
