 
<?php
   date_default_timezone_set('Asia/Jakarta');
 //  include("dbcon.php");
 //  $link=Conection();
// terim.php?id=byk0001&msg=alive
   if(isset($_GET['id'])and($_GET['msg'])) {
    // $s = date("Y-m-d H:i:s", time());//time ();
   $s = time ();
    //$s = date('Y-m-d H:i:s');
   
	$dt1=date("H:i:s",$s);
    $tgljam =date("Y-m-d H:i:s",$s);
	
	
    $id1=$_GET['id'];
	$msg1=$_GET['msg'];
	$idmandiri="byk0001";
	$idhotel5="hyk0005";
	$stAlive="alive";
		if (($id1==$idmandiri) and ($msg1==$stAlive)){
			
	
		echo "suksesss";
		//include("tellbot.php");
		//https://api.telegram.org/bot216353971:AAHyd_ZKzWFAUeSGI2fdkQJfdhmLZYLG0G0/sendMessage?chat_id=-198645569&text=/alive
		
		/*
		$token_bot="216353971:AAHyd_ZKzWFAUeSGI2fdkQJfdhmLZYLG0G0";
		$data['chat_id']=-198645569;//307734416;
		$data['text']="aloooha from php"; 
		
		function kirimperintah($perintah,$token_bot,array $keterangan=null) 
		{ 
		$url="https://api.telegram.org/bot".$token_bot."/"; 
		$url.=$perintah."?";
		foreach ($keterangan as $k => $v) {
			$url.=$k."=".$v."&";
		}
		$url=rtrim($url,"&");
		$result=file_get_contents($url); 
		return $output; 
		} 
		
		kirimperintah("sendMessage",$token_bot,$data); 
		echo 'done'; 
		*/
		
		
		
		function KirimPerintahCurl($perintah,$data){
		  $ch = curl_init();
		  curl_setopt($ch, CURLOPT_URL,BotKirim($perintah));
		  curl_setopt($ch, CURLOPT_POST, count($data));
		  curl_setopt($ch, CURLOPT_POSTFIELDS,http_build_query($data));
		  curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
		 
		  $kembali = curl_exec ($ch);
		  curl_close ($ch);
		 
		  return $kembali;
		}
		
		 function KirimPerintahStream($perintah,$data){
		   $options = array(
			  'http' => array(
				  'header'  => "Content-type: application/x-www-form-urlencoded\r\n",
				  'method'  => 'POST',
				  'content' => http_build_query($data),
			  ),
		  );
		  $context  = stream_context_create($options);
		  $result = file_get_contents(BotKirim($perintah), false, $context);
		  return $result;
		}
		
		function KirimPerintah($perintah,$data){
    // Detek otomatis metode curl atau stream (by Radya)
			 if(is_callable('curl_init')) {
			   $hasil = KirimPerintahCurl($perintah,$data);
				//cek kembali, terkadang di XAMPP Curl sudah aktif
				//namun pesan tetap tidak terikirm, maka kita tetap gunakan Stream
				if (empty($hasil)){
					$hasil = KirimPerintahStream($perintah,$data);
				 }   
			  }
			  else {
				 $hasil = KirimPerintahStream($perintah,$data);
				}
			 return $hasil;         
		 }
		 
		
		
		
		 
		
		
		
		
		
		} else
		{
			echo "another case!";
		}

	
	
	
	
	}
    else {

       //   $result=mysql_query("select * from tblevel order by id desc");//,$link);
    }

?>

