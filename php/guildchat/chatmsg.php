<?php
session_start();
$serverName = "UNKOWN-USER\SQLEXPRESS1"; //serverName\instanceName
$US = "sa";
$PS = "3199462";
$dbname1 = "SRO_VT_SHARD";
$dbname2 = "SRO_VT_ACCOUNT";
$dbname3 = "WEBSITE";
$connectionInfo = array( "Database"=>"$dbname1", "Database"=>"$dbname2", "Database"=>"$dbname3");
$dbcn = sqlsrv_connect($serverName,$connectionInfo) or die("Database connection lost");
$Gcharid = $_SESSION['Char'];
$getallchars = SQLSRV_QUERY($dbcn,"Select * from $dbname3.dbo._Guildmembers Where GuildID in (Select GuildID from $dbname3.dbo._Guildmembers Where CharID = $Gcharid)");
$Getallcharsr = SQLSRV_FETCH_ARRAY($getallchars);
$Gguildid = $Getallcharsr['GuildID'];
$getC = SQLSRV_QUERY($dbcn,"Select _OnlineChat.ID,_Guild.[Name] as GName,Charname,GuildID,CharID,MSG,Mtime from $dbname3.dbo._OnlineChat inner join $dbname3.dbo._Guild on _OnlineChat.GuildID = _Guild.ID inner join $dbname3.dbo._Char on _OnlineChat.CharID = _Char.ID where GuildID = '$Gguildid' order by _OnlineChat.Mtime ASC");

while($pushinfo = SQLSRV_FETCH_ARRAY($getC)){
    $Charname = $pushinfo['Charname'];
    $msg = $pushinfo['MSG'];
    $time = $pushinfo['Mtime'];
    if($pushinfo['CharID'] == $Gcharid){
        echo"
        <div id='7awl' class='chat-msg-box chat-msg-box-me'><span ><p class='followme'>@$Charname <br> $msg</p> <b class='chat-time'>".$time->format('h:i')."</b></span></div>
        ";
    }else{
    echo"
    <div class='chat-msg-box '><span ><p class='followme'>@$Charname  : $msg</p> <b class='chat-time'>".$time->format('h:i')."</b></span></div>
    ";
} 
}

?>