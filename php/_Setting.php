<?php

$serverName = "UNKOWN-USER\SQLEXPRESS1"; //serverName\instanceName
$US = "sa";
$PS = "3199462";
$dbname1 = "SRO_VT_SHARD";
$dbname2 = "SRO_VT_ACCOUNT";
$dbname3 = "WEBSITE";
$sitename = "Silkroad Online";
$connectionInfo = array( "Database"=>"$dbname1", "Database"=>"$dbname2", "Database"=>"$dbname3");
$dbcn = sqlsrv_connect($serverName,$connectionInfo) or die("Database connection lost");
#--------Server Cap--------#
$Scap = "110";
#-------Server Degree --------#
$SDEGREE = "13";
#-------Server Race --------#
$Race = ""; 
#--------Server Mastery EU--------#
$SEUMastery = "140";
#--------Server Mastery CH--------#
$SCHMastery = "130";
#--------EXP RATE ---------#
$EXPRATE = "10";
#--------MAX PLus----------#
$MPLUS = "13";
#--------Alchemy Rate -----#
$AR = "3";
#--------Guild Limit ----#
$GL = "30";
#--------Union Limit ----#
$UN = "2";
#-------On=1-off=0 Jangan FTW ------#
$JGFTWSER = 1;
#-------On=1-off=0 Bandit FTW ------#
$BFTWSER = 0;
#-------On=1-off=0 Hotan FTW ------#
$HFTWSER = 1;
?>