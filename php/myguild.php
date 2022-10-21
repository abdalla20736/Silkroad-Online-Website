<?php
    
    $Guildid = $_GET['id'];
    $checkifguild = SQLSRV_QUERY($dbcn,"Select * from $dbname3.dbo._Guild where ID = '$Guildid'",array(),array('scrollable' => SQLSRV_CURSOR_KEYSET));
    if(SQLSRV_NUM_ROWS($checkifguild) > 0){
    if(isset($_GET['pages'])){
        $pages = $_GET['pages'];
    }else{
        $pages = 1;
    }
    $getrows = SQLSRV_QUERY($dbcn,"SELECT * from $dbname3.dbo._Guildmembers where GuildID = $Guildid",array(),array('scrollable' => SQLSRV_CURSOR_KEYSET));
    $perpage = 10;
    $curpage = ($pages-1)*$perpage;
    $rowsmembers = SQLSRV_NUM_ROWS($getrows);
    $countpages = ceil($rowsmembers/$perpage);
    $getguildinfo = SQLSRV_QUERY($dbcn,"WITH GETROWSWITHINNER AS (Select $dbname3.dbo._Char.Charname,$dbname3.dbo._Guildmembers.CharID,$dbname3.dbo._Char.Race,$dbname3.dbo._Char.lvl,$dbname3.dbo._Guildmembers.GPMEMBER,$dbname3.dbo._Guildmembers.Permission, ROW_NUMBER() OVER(order by CharID) as rowsn from $dbname3.dbo._Guildmembers  INNER JOIN _Char On $dbname3.dbo._Guildmembers.CharID = $dbname3.dbo._Char.ID where GuildID = $Guildid )Select top $perpage * from GETROWSWITHINNER Where rowsn  > $curpage ",array(),array('scrollable' => SQLSRV_CURSOR_KEYSET));
    $getgpsum = SQLSRV_QUERY($dbcn,"Select SUM(GPMEMBER) as value_GP from $dbname3.dbo._Guildmembers where GuildID = $Guildid", array(),array('scrollable'=> SQLSRV_CURSOR_KEYSET));
    $getguildleader = SQLSRV_QUERY($dbcn,"Select top 1 * From $dbname3.dbo._Char Where ID in (select CharID from $dbname3.dbo._Guildmembers where GuildID = $Guildid and Permission = 1)", array(),array('scrollable'=> SQLSRV_CURSOR_KEYSET));
    $getcheckresult = SQLSRV_FETCH_ARRAY($checkifguild);
    $getgpsumr= SQLSRV_FETCH_ARRAY($getgpsum);
    $getguildleaderres = SQLSRV_FETCH_ARRAY($getguildleader);   
    if(SQLSRV_NUM_ROWS($getguildleader) > 0 && SQLSRV_NUM_ROWS($getguildinfo) > 0 && SQLSRV_NUM_ROWS($getgpsum) > 0 ){
    echo'<div class=" guild-div">
    <div class="guild-div1">
    <h1> Basics <span class="guildname">'.$getcheckresult['Name'].'</span></h1> 
    <span>Leader :&nbsp;&nbsp;&nbsp; <a style="color:#2E3C6B; font-size:20px;" href="?page=mycharacter&id='.$getguildleaderres['ID'].'"> '.$getguildleaderres['Charname'].'</a></span><br>
    <span>Level: '.$getcheckresult['lvl'].'</span><br>
    <span>Member: '.SQLSRV_NUM_ROWS($getguildinfo).'</span><br>
    <span>GP: '.$getgpsumr['value_GP'].'</span>
    </div>
    <div class="guild-div2">
    <h1 style="margin-top:50px;"> Members </h1>
    <table class="guild-div-table">     <tr>
    <th>#</th>
    <th>Character</th>
    <th>Race</th>
    <th>Level</th>
    <th>GP</th>
    <th>Power</th>
</tr>';
}else{
    echo'<div class="guild-div">
    <div class="guild-div1">
    <h1> Basics <span class="guildname">None</span></h1> 
    <span>Leader :&nbsp;&nbsp;&nbsp; Not known</span><br>
    <span>Level: 0</span><br>
    <span>Member: None</span><br>
    <span>GP: 0</span>
    </div>
    <div class="guild-div2">
    <h1 style="margin-top:50px;"> Members </h1>
    <table class="guild-div-table">     <tr>
    <th>#</th>
    <th>Character</th>
    <th>Race</th>
    <th>Level</th>
    <th>GP</th>
    <th>Power</th>
</tr>';
}
        $i = $curpage;
        if(SQLSRV_NUM_ROWS($getguildinfo) > 0){
    while($getn = SQLSRV_FETCH_ARRAY($getguildinfo)){
        
        $i++;
        if($getn['Race'] >= 1907 && $getn['Race'] <= 1932)
            $Rc = "Chinese";
        else
            $Rc = "Europe";

         if($getn['Permission'] == 1 )
            $perm = "Commander";
        elseif($getn['Permission'] == 2 )
            $perm = "Deputy Commander";
        else $perm = "Guild Member";
        echo'<tr>
        <td>'.$i.'</td>
        <td>'.$getn['Charname'].'</td>
        <td>'.$Rc.'</td>
        <td>'.$getn['lvl'].'</td>
        <td>'.$getn['GPMEMBER'].'</td>
        <td>'.$perm.'</td>
    </tr>';
    }
}else{
    echo'<tr>
        <td>#</td>
        <td>No Characters</td>
        <td>None</td>
        <td>None</td>
        <td>0</td>
        <td>Not known</td>
    </tr>';
}
 


    echo'</table>
    </div> <div class="desgin1"> <ul class="lastlist">';
    if($countpages != 1){
      for($k = 1; $k <= $countpages; $k++)
      { echo '<li><a class="guild-pages selected" href="?page=myguild&id='. $Guildid.'&pages='.$k.'">'.$k.'</a></li>';}
        }
      echo'</ul></div></div>';
}else{
    echo'<div style="margin-top:80px;" class="gu-ch-error-div"><span class="gu-ch-error">Sorry, the guild has been not found or you have no guild,</span></div>';
}
?>