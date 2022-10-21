
<?php
    $charid = $_GET['id'];
    $checkifchar = SQLSRV_QUERY($dbcn,"Select * from $dbname3.dbo._Char where ID = $charid ",array(),array('scrollable' => SQLSRV_CURSOR_KEYSET));
    if(SQLSRV_NUM_ROWS($checkifchar) > 0){
    $getRank = SQLSRV_QUERY($dbcn,"Select * from (select ROW_NUMBER() OVER(order by lvl DESC,Gold Desc,[str] Desc,intell Desc) as rown,* from $dbname3.dbo._Char ) as page where rown > 0 and ID = $charid");   
    $getguild = SQLSRV_QUERY($dbcn,"Select * from $dbname3.dbo._Guild Where ID in (Select GuildID FROM $dbname3.dbo._Guildmembers where CharID = $charid)");
    $getuserinfo = SQLSRV_QUERY($dbcn,"select * from $dbname3.dbo.SK_USER Where ID in (select UserID FROM $dbname3.dbo._CHAR WHERE ID = $charid)");
    $char = SQLSRV_FETCH_ARRAY($checkifchar);
    $getRankRes = SQLSRV_FETCH_ARRAY($getRank);
    $getuserinfores = SQLSRV_FETCH_ARRAY($getuserinfo);
    $getguildres = SQLSRV_FETCH_ARRAY($getguild);
        #-----------------------------------------------------#
            $race = $char['Race'];
            $CN = $char['Charname'];
            $rank = $getRankRes['rown'];
            $lvl = $char['lvl'];
            $str = $char['str'];
            $int = $char['intell'];
            $GUID = NULL;
            $GUNM = NULL;
            if(!empty($getguildres['ID'])){
                $GUID = $getguildres['ID'];
            }
            if(!empty($getguildres['Name'])){
                $GUNM = $getguildres['Name'];
            }
            $getstatus = $getuserinfores['Status'];
            if(!$getuserinfores['LastWebvisit'])
            $lasttime = "none";
            else $lasttime = $getuserinfores['LastWebvisit']->format('d.m.Y h:i');
            
        echo"
        <span style=' margin-left:5px; color:#fff !important; font-size:40px; '>MY CHARACTER</span>
        <div class='mycharacter-div'>
        <div class='mycharacter-div-div1'>

        <div class='mycharacter-img-div'>
        <img src='./img/chars/$race.gif'>
        </div>
            <div class='mycharacter-rank-name-div'>
            <span class='mycharacter-name' >$CN</span><br>
            
            <span class='mycharacter-rank' >Rank : $rank</span>
            </div>
            </div>
            
            <div class='mycharacter-div-div2'>
           
              <table class='mycharacter-info'>  
                  <tr>
                      <th><span>STATUS :</span></th>
                      ";
                        if($getstatus === 1)
                           echo "<th> <span style='color:green;'>Online</span></th>";
                        else echo "<th> <span style='color:red;'>Offline</span></th>";
                     
                      echo"
                  </tr>
                  <tr>
                      <th><span>CURRENT LEVEL : </span></th>
                      <th> $lvl</th>
                  </tr>
                  <tr>
                      <th><span>STRENGTH :</span></th>
                      <th>$str</th>
                  </tr>
                  <tr>
                      <th><span>INTELLECT :</span></th>
                      <th> $int</th>
                  </tr>
                
                  <tr>
                      <th><span>LAST LOGIN :</span></th>
                      <th>$lasttime</th>
                  </tr>
                  <tr>
                      <th><span>GUILD :</span></th>
                      ";


                      if($GUID != null && $GUNM != null)
                      {     
                        echo"<th> <a href='?page=myguild&id=$GUID'>$GUNM</a></th>";
                      }else {echo"<th> <a>No Guild</a></th>";}

                    echo"
                      
                  </tr>
            </table> 
        
            </div>
           
        </div>
        ";
    }else{
        echo"<div class='gu-ch-error-div'><span class='gu-ch-error'>Sorry, the character has been not found or you have no character,</span></div>";
    }
?>