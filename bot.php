<?php

system('clear');
function curl($url, $headers, $mode="get", $data=0)
	{
	if ($mode == "get" || $mode == "Get" || $mode == "GET")
		{
		$ch = curl_init();
		curl_setopt($ch, CURLOPT_URL, $url);
		curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, true);
		curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
		curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
		$result = curl_exec($ch);
		$httpcode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
		}
	elseif ($mode == "post" || $mode == "Post" || $mode == "POST")
		{
		$ch = curl_init();
		curl_setopt($ch, CURLOPT_URL, $url);
		curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, true);
		curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
		curl_setopt($ch, CURLOPT_POST, 1);
		curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
		curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
		$result = curl_exec($ch);
		$httpcode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
		}
	else
		{
		$result = "Not define";
		}
	$_POST["httpcode"] = $httpcode;
	return $result;
	}

if (file_exists("config.json"))
{
	$file = file_get_contents("config.json");
	$file = json_decode($file, true);
	$userid = $file["userid"];
	$token = $file["token"];
}
elseif (!file_exists("config.json"))
{
	echo "\033[1;32mENTER USERID \033[1;36m> ";
	$cookie["userid"] = trim(fgets(STDIN));
        echo "\033[1;32mENTER TOKEN \033[1;36m> ";
        $cookie["token"] = trim(fgets(STDIN));


	echo "\033[0m";
	$a = json_encode($cookie, JSON_PRETTY_PRINT);
	file_put_contents("config.json", $a);
	$userid = $cookie["userid"];
	$token = $cookie["token"];

}


$headers[] = "charset: UTF-8";
$headers[] = "api-version: 2";
$headers[] = "external-version: 2.5.2";
$headers[] = "app-id: ClipClaps_gg";
$headers[] = "timezone: 7";
$headers[] = "userid: {$userid}";
$headers[] = "version: 42";
$headers[] = "token: {$token}";
$headers[] = "content-type: application/json; charset=utf-8";
$headers[] = "user-agent: okhttp/4.2.1";
$headers[] = "lang: id";



		// GET ACCOUNT INFO
$url = 'https://api.cc.lerjin.com/user/self/info';
$data = '{"userid":"'.$userid.'","token":"'.$token.'"}';
$s =  json_decode(curl($url, $headers, "post", $data), true);
$s = $s['data'];
echo "\033[0;37m\n";
echo "\033[4;32m\033[1;36mPJR❤️\033[0m❤️\033[1;37mYOUR ACCOUNT INFORMATIONS BY EMRAN\033[0m❤️\033[4;32m\033[1;36mPJR❤️\033[0m\n";
echo "\033[0;37m\n";
echo "\033[1;32m███████╗███╗░░░███╗██████╗░░█████╗░███╗░░██╗\033[1;36m ";
echo "\033[1;32m██╔════╝████╗░████║██╔══██╗██╔══██╗████╗░██║\033[1;36m  ";
echo "\033[1;32m██╔══╝░░██║╚██╔╝██║██╔══██╗██╔══██║██║╚████║\033[1;36m ";
echo "\033[1;98m██╔══╝░░██║╚██╔╝██║██╔══██╗██╔══██║██║╚████║\033[1;98m ";
echo "\033[1;32m╚══════╝╚═╝░░░░░╚═╝╚═╝░░╚═╝╚═╝░░╚═╝╚═╝░░╚══╝\033[1;36m ";
echo "\033[0;37m\n";
echo "Nickname	[ ".$s["nickname"]." ]\n";
echo "Coins		[ ".$s["coins"]." ]\n";
echo "Cash		[ ".$s["cash"]." ]\n";
echo "\n\n";


		// GET READING TIME
$url = 'https://api.cc.lerjin.com/reading/timer';
$s =  json_decode(curl($url, $headers, "post", $data), true);
$s = $s["data"];

$day = $s["day"];
$activeDay = $s["activeDay"];
$videoTime = $s["videoTime"];
$articleTime = $s["articleTime"];


foreach ($s["config"]["timerReward"] as $a){
if ($videoTime < $a["time"]){

if (!$a["specific"]){
$specific = "false";
}else{
$specific = "true";
}

	$d["articleTime"] = $articleTime;
	$d["videoTime"] = $a["time"];
	$d["userid"] = $userid;
	$d["day"] = $day;
	$d["token"] = $token;
	$data = json_encode($d);
$header = array();
foreach ($headers as $head){
$header[] = $head;
}$header[] = "content-length: ".strlen($data);
$url = 'https://api.cc.lerjin.com/reading/refreshTime';
$s =  json_decode(curl($url, $header, "post", $data), true);


$d["rewardTime"] = $a["time"];
$d["rewardType"] = $a["rewardType"];
$d["activeDay"] = $activeDay;
$d["specific"] = $specific;
$d["version"] = "10";
$data = json_encode($d);

$header = array();
foreach ($headers as $head){
$header[] = $head;
}$header[] = "content-length: ".strlen($data);

$url = 'https://api.cc.lerjin.com/reading/obtainReward';
$s =  json_decode(curl($url, $header, "post", $data), true);
if ($s["msg"] == "Success"){
$videoTime = $a["time"]+1;
echo "Succes		reward type [".$d["rewardType"]."]\n";
sleep(10);
}else{
print_r($_POST["httpcode"]);
print_r($s);
exit();
}
}
}












?>
