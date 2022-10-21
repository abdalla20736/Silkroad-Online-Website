<?php

 #--- Set default page, if you do not get "page" ---#
if(empty($_GET['page']) && !isset($_GET['pages'])){
#--- Include default (notice.php) or another ---#
	include("./php/news.php");
#--- Else if get "page" ---#
}elseif($_GET['page'] == 'purchasing' || $_GET['page'] == 'completepurchasing') {

	
	include("./php/webshop/webmall.php");
}else {

#--- Check if page exist ---#
if(file_exists("./php/".$_GET['page'].".php")) {

		#--- If page exist ---#
		$check = preg_match("/^[a-zA-Z0-9]+$/", $_GET['page']);
		if ($check == 0) {
			die('<meta http-equiv="refresh" content="0;url=?page=logout">');
		} else {
			include("php/".$_GET['page'].".php");
		}


}else if (file_exists("./php/webshop/".$_GET['page'].".php")) {
		#--- If page exist ---#
		$check = preg_match("/^[a-zA-Z0-9]+$/", $_GET['page']);
		if ($check == 0) {
			die('<meta http-equiv="refresh" content="0;url=?page=logout">');
		} else {

			include("php/webshop/".$_GET['page'].".php");
		}
}elseif(file_exists("./php/ranking/".$_GET['page'].".php")){
		#--- If page exist ---#
		$check = preg_match("/^[a-zA-Z0-9]+$/",$_GET['page']);
		if($check == 0){
			die('<meta http-equiv="refresh" content="0;url=?page=logout">');
		} else{
			include("php/ranking/".$_GET['page'].".php");
		}
		#--- If page exist ---#
}elseif(file_exists("./php/guildchat/".$_GET['page'].".php")){
	#--- If page exist ---#
	$check = preg_match("/^[a-zA-Z0-9]+$/",$_GET['page']);
	if($check == 0){
		die('<meta http-equiv="refresh" content="0;url=?page=logout">');
	} else{
		include("php/guildchat/".$_GET['page'].".php");
	}

		#--- Else if page dont exist ---#
}elseif(file_exists("./php/Apanel/".$_GET['page'].".php")){
	#--- If page exist ---#
	$check = preg_match("/^[a-zA-Z0-9]+$/",$_GET['page']);
	if($check == 0){
		die('<meta http-equiv="refresh" content="0;url=?page=logout">');
	} else{
		include("php/Apanel/".$_GET['page'].".php");
	}

		#--- Else if page dont exist ---#
}else if (file_exists("./php/forgetpassword/".$_GET['page'].".php")){
	#--- If page exist ---#
	$check = preg_match("/^[a-zA-Z0-9]+$/",$_GET['page']);
	if($check == 0){
		die('<meta http-equiv="refresh" content="0;url=?page=logout">');
	} else{
		include("php/forgetpassword/".$_GET['page'].".php");
	}
}else {
			#--- Include standard page (or give error, open option) ---#
			include("./php/error.php");
	}
}

?>