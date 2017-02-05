<?php
//PBSSbot
$TOKEN="216353971:AAHyd_ZKzWFAUeSGI2fdkQJfdhmLZYLG0G0";
function request_url($method)
{
 global $TOKEN;
 return "https://api.telegram.org/bot" . $TOKEN . "/". $method;
}
function getLink($url)
{
 require_once ('simplerss.php');
 
 $rss = new simplerss;
 $items = $rss->parse(array($url));
 $i = 1;
 $result = '';
 foreach($items as $feed)
 {
 $result .= '<a href="'.$feed->link.'">'.$feed->title.'</a>
';
 if($i == 5) break;
 $i++;
 }
 return $result;
}


function send_reply($chatid, $msgid, $text)
{
 $data = array(
 'parse_mode' => 'HTML',
 'chat_id' => $chatid,
 'text' => $text,
 'disable_web_page_preview' => true
 //'reply_to_message_id' => $msgid
 );
 // use key 'http' even if you send the request to https://...
 $options = array(
 'http' => array(
 'header' => "Content-type: application/x-www-form-urlencoded\r\n",
 'method' => 'POST',
 'content' => http_build_query($data),
 ),
 );
 $context = stream_context_create($options);
 $result = file_get_contents(request_url('sendMessage'), false, $context);
}
function create_response($text)
{
 if(strpos($text, '/about')!== FALSE)
 {
 $result = 
 'Iam panic button BYK0001, Silahkan Kontak  @fixduino
Terima Kasih
 ';
 }
 else if(strpos(strtolower($text), '/new')!== FALSE){
 
// $result = '<b>Artikel Terbaru fixtutor.com</b>';
// $result .= getLink('http://miconos.co.id');
 
 $result = 
 'Total 2 Panik Button Brooo
 ';
 
 }
 else if(strpos(strtolower($text), '/stat')!== FALSE){
 
 $result = '<b>Panic Button BYK0001</b>
 <b>Bank Mandiri Tugu</b>
 <b>Jl Sudirman</b>
 <b>Status Alive</b>
';
 }
 else if(strpos(strtolower($text), '/help')!== FALSE){
 
 $result = '<b>Command List bot</b>
';
 $result .= '<b>/new</b> - Get Update Article fixtutor.com
<b>/about</b> - Get Info Developer
<b>/help</b> - Get Command List
<b>/stat</b> - Get Status client panic button
';
 }
 else {
 
 $result = 'Fixduino, Senang berkenalan dengan anda';
 }
 return $result;
}


function process_message($message)
{
 $updateid = $message["update_id"];
 $message_data = $message["message"];
 if (isset($message_data["text"])) {
 $chatid = $message_data["chat"]["id"];
 $message_id = $message_data["message_id"];
 $text = $message_data["text"];
 $response = create_response($text);
 send_reply($chatid, $message_id, $response);
 } 
 return $updateid;
}
function get_updates($offset) 
{
 $url = request_url("getUpdates")."?offset=".$offset;
 $resp = file_get_contents($url);
 $result = json_decode($resp, true);
 if ($result["ok"]==1)
 return $result["result"];
 return array();
}
function process_one()
{
 $update_id = 0;
 
 if (file_exists("last_update_id")) {
 $update_id = (int)file_get_contents("last_update_id");
 }
 
 $updates = get_updates($update_id);
 
 foreach ($updates as $message)
 {
 $update_id = process_message($message);
 }
 file_put_contents("last_update_id", $update_id + 1);
 
}
 
while (true) {
 process_one();
}
?>