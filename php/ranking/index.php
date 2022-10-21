<span style=' margin-left:5px; color:#fff !important; font-size:40px; '>Ranking</span>
<div class="ranking">
    <div class="ranking-menu">
        <form class="ranking-form" method="post">
            <h1 style="margin-left:-5px;font-size:30px;">Menu</h1>
            <button class="btn-T btn-T1" name="TP">Top Players</button>
            <button class="btn-T btn-T2" name="TG">Top Guilds</button>
        </form>
    </div>
    <div class="ranking-info">
    
        <div class="ranking-search-div">
        
            <form method='POST'>
            <h5 style="margin-left:-5px;font-size:30px;">Search</h5>
            <select class="btn-searchby" name='selection-searchby'>
                    <option class="opt1" value="bycharname">By Char name</option>
                    <option class="opt2" value="byguildname">By Guild name</option>
                </select>
                <input name='searchinput' type="text" placeholder='Search...' autocomplete="on">
                <button class='btn-T3' name='searchbtn'>Search</button>
            </form>
        </div>
        <div class='Ranking-players-table'>
            <table class='Ranking-players-table'>
                                <?php
                        if(isset($_POST['searchbtn'])){
                        $name = $_POST['searchinput'];
                        $guildorchar = $_POST['selection-searchby'];
                        if($guildorchar == 'bycharname'){
                            $searchbycharacter = SQLSRV_QUERY($dbcn,"SELECT * FROM $dbname3.dbo._Char Where Charname like '%$name%' and Charname not like '%]%' order by lvl DESC,Gold Desc,[str] Desc,intell Desc",array(),array('scrollable' => SQLSRV_CURSOR_KEYSET));
                           
                                echo"
                                    <tr>
                                        <th>#</th>
                                        <th>Character</th>
                                        <th>Race</th>
                                        <th>Level</th>
                                        <th>Gold</th>
                                    </tr>
                                ";
                                $i = 0;
                                while($getdata = SQLSRV_FETCH_ARRAY($searchbycharacter)){
                                    $cn = $getdata['Charname'];
                                    if($getdata['Race'] >= 1907 && $getdata['Race'] <= 1932)
                                        $rc = "Chinese";
                                    else
                                        $rc = "Europe";
                                    $lv = $getdata['lvl'];
                                    $gold = $getdata['Gold'];
                                    $charID = $getdata['ID'];
                                    $i++;
                                    echo"
                                        <tr>
                                            <td>$i</td>
                                            <td><a style='color:#fff;' href='?page=mycharacter&id=$charID'>$cn</a></td>
                                            <td>$rc</td>
                                            <td>$lv</td>
                                            <td>$gold</td>
                                        </tr>
                                    ";
                                }
                            
                        }else if($guildorchar == 'byguildname'){
                            $searchbyguild = SQLSRV_QUERY($dbcn, "SELECT * FROM $dbname3.dbo._Guild Where [Name] like '%$name%' order by lvl DESC,GP DESC",array(),array('scrollable' => SQLSRV_CURSOR_KEYSET));
                            
                                echo"
                                    <tr>
                                        <th>#</th>
                                        <th>Name</th>
                                        <th>Level</th>
                                        <th>GP</th>
                                    </tr>
                                ";
                                $i = 0;
                                while($getdata = SQLSRV_FETCH_ARRAY($searchbyguild)){
                                    $gn = $getdata['Name'];
                                    $lv = $getdata['lvl'];
                                    $GP = $getdata['GP'];
                                    $GuildID = $getdata['ID'];
                                    $i++;
                                    echo"
                                        <tr>
                                            <td>$i</td>
                                            <td><a style='color:#fff;' href='?page=myguild&id=$GuildID'>$gn</a></td>
                                            <td>$lv</td>
                                            <td>$GP</td>
                                        </tr>
                                    ";
                                }
                            }
                          }
                        
                        else if(isset($_POST['TP'])){
                            $top50 = SQLSRV_QUERY($dbcn,"SELECT top 50 * FROM _CHAR WHERE Charname not like '%]%' order by lvl DESC,Gold Desc,[str] Desc,intell Desc");
                            echo"
                            <tr>
                                <th>#</th>
                                <th>Character</th>
                                <th>Race</th>
                                <th>Level</th>
                                <th>Gold</th>
                            </tr>
                        ";
                        $i = 0;
                        while($getdata = SQLSRV_FETCH_ARRAY($top50)){
                            $cn = $getdata['Charname'];
                            if($getdata['Race'] >= 1907 && $getdata['Race'] <= 1932)
                                $rc = "Chinese";
                            else
                                $rc = "Europe";
                            $lv = $getdata['lvl'];
                            $gold = $getdata['Gold'];
                            $charID = $getdata['ID'];
                            $i++;
                            echo"
                                <tr>
                                    <td>$i</td>
                                    <td><a style='color:#fff;' href='?page=mycharacter&id=$charID'>$cn</a></td>
                                    <td>$rc</td>
                                    <td>$lv</td>
                                    <td>$gold</td>
                                </tr>
                            ";
                        }
                        
                        }
                        else if(isset($_POST['TG'])){
                            $top50 = SQLSRV_QUERY($dbcn,"SELECT top 50 * FROM _Guild order by lvl DESC,GP DESC");
                            echo"
                                    <tr>
                                        <th>#</th>
                                        <th>Name</th>
                                        <th>Level</th>
                                        <th>GP</th>
                                    </tr>
                                ";
                                $i = 0;
                                while($getdata = SQLSRV_FETCH_ARRAY($top50)){
                                    $gn = $getdata['Name'];
                                    $lv = $getdata['lvl'];
                                    $GP = $getdata['GP'];
                                    $GuildID = $getdata['ID'];
                                    $i++;
                                    echo"
                                        <tr>
                                            <td>$i</td>
                                            <td><a style='color:#fff;' href='?page=myguild&id=$GuildID'>$gn</a></td>
                                            <td>$lv</td>
                                            <td>$GP</td>
                                        </tr>
                                    ";
                                }
                            
                        
                    
                            
                        }else{
                            
                            $top = SQLSRV_QUERY($dbcn,"SELECT top 50 * FROM $dbname3.dbo._Char Where  Charname not like '%]%' order by lvl DESC,Gold Desc,[str] Desc,intell Desc",array(),array('scrollable' => SQLSRV_CURSOR_KEYSET));
                            echo"
                                    <tr>
                                        <th>#</th>
                                        <th>Character</th>
                                        <th>Race</th>
                                        <th>Level</th>
                                        <th>Gold</th>
                                    </tr>
                                ";
                                $i = 0;
                                while($getdata = SQLSRV_FETCH_ARRAY($top)){
                                    $cn = $getdata['Charname'];
                                    if($getdata['Race'] >= 1907 && $getdata['Race'] <= 1932)
                                        $rc = "Chinese";
                                    else
                                        $rc = "Europe";
                                    $lv = $getdata['lvl'];
                                    $gold = $getdata['Gold'];
                                    $charID = $getdata['ID'];
                                    $i++;
                                    echo"
                                        <tr>
                                            <td>$i</td>
                                            <td><a style='color:#fff;' href='?page=mycharacter&id=$charID'>$cn</a></td>
                                            <td>$rc</td>
                                            <td>$lv</td>
                                            <td>$gold</td>
                                        </tr>
                                    ";
                                }
                        }
                        
                        
                
                             ?>
            </table>
        </div>

    </div>
</div>
