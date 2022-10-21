<?php
$msgg = $_POST['msg'];
$Gguildid = $_POST['gid'];
$Gcharid = $_POST['gcid'];

include_once $_SERVER['DOCUMENT_ROOT'].'/php/_Setting.php';
SQLSRV_QUERY($dbcn,"INSERT INTO $dbname3.dbo._OnlineChat (MSG,GuildID,CharID) values ('$msgg',$Gguildid,$Gcharid)");
?>