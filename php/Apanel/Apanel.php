<?php
       

echo"<span style=' margin-left:5px; color:#fff !important; font-size:40px; '>ADMIN PANEL</span>";
    if(isset($_SESSION['loggedin'])){
        $User = $_SESSION['User'];
        $checkifadmin = SQLSRV_QUERY($dbcn,"SELECT ID,sec_primary,sec_content FROM $dbname3.dbo.SK_USER Where Username = '$User'");
        $R = SQLSRV_FETCH_ARRAY($checkifadmin);
        $sec1 = $R['sec_primary'];
        $sec2 = $R['sec_content'];
        $ip = $_SERVER['REMOTE_ADDR'];
        if($sec1 == 1 && $sec2 == 1){
            SQLSRV_query($dbcn,"INSERT INTO $dbname3.dbo.NTadmin (Username,Mtime,Notice,IP4)values('$User',GETDATE(),'Administrator logged in','$ip')");
            echo"<div class='Apanel-main-div'>
            <form method='POST'>
            <button name='editnew' class='btn-site Apanel-btn'>News</button>
            <button name='addepin' class='btn-site Apanel-btn' >E-pin System</button>
            <button name='banunban' class='btn-site Apanel-btn'>Ban/unBan</button>
            <button name='webshop' class='btn-site Apanel-btn'>Webshop</button>
            <button name='downloads' class='btn-site Apanel-btn'>Downloads</button>
            </form>
            </div>
            
            ";
            if(array_key_exists('editnew', $_POST)){
                $getlines = SQLSRV_QUERY($dbcn,"SELECT * from $dbname3.dbo.news");
                
                echo"
                
                    <div class='editnews-div'>
                    
                    <form method='post'>
                    <select onfocus='this.size=10;' onblur='this.size=1;' onchange='this.size=1; this.blur();' name='selectsubject'>  <option value='' disabled Selected>Enter The Article Subject</option>
                    ";
                    
                    while($usresult = SQLSRV_FETCH_ARRAY($getlines)){
                        $value1 = $usresult[1];
                        $value2 = $usresult['postdate']->format('d.m.Y');
                        
                        echo "<option value='$value1'>&emsp;&emsp;$value2&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;$value1</option>";
                    }
                    
                    echo"
                    </select><br>
                    ";
                       
                    echo"
                        <button name='addbtnnews'  class='btn-site Apanel-btn news-btn'>Add</button>
                        <button name='editbtnnews' class='btn-site Apanel-btn news-btn'>Edit</button>
                        <button name='deletebtnnews' onclick=return confirm_delete() class='btn-site Apanel-btn news-btn'>Delete</button>
                        </form>
                    </div>

                    ";
                    
                    
           

                    #-------------------------------------------------------------------------       
            }else if(array_key_exists('addepin', $_POST)){
                $getlines = SQLSRV_QUERY($dbcn,"SELECT * from epin");
                echo"<div class='addepin-div'>
                <table class='addepin-table'>
                    <tr>
                        <th>#</th>
                        <th>E-Pin</th>
                        <th>Amount</th>
                        <th>Remove</th>
                    </tr>";
                    $i=0;
                while($getinfo = SQLSRV_FETCH_ARRAY($getlines)){
                    $epin = $getinfo['realpin'];
                    $amount = $getinfo['silk'];
                    $id = $getinfo['ID'];
                    $i++;
                    echo"
                        <tr>
                        <form method='post' action='?page=Apanel&id=$id'>
                        <td>$i</td>
                        <td><span>$epin</span></td>
                        <td>$amount</td>
                        <td><button name='removeepin' class='addepin-remove-btn'>Remove</button></td>
                        </form>
                        </tr>
                        ";
                }
                        $i++;
                   echo" 
                        <tr>
                        <form method='post'>
                        <td>$i</td>
                        <td><input  type='text' style='width:250px;' placeholder='Enter the code' name='entercode' autocomplete='off'></td>
                        <td><input style='width:100px;' type='number' min='0' value=0 name='enteramount'></td>
                        <td><button name='addepin' class='addepin-add-btn'>add</button></td>
                        </form>
                        </tr>
                   </table>
                   </div>";
                   
            }else if(array_key_exists('banunban', $_POST)){
                $getus = SQLSRV_QUERY($dbcn,"Select Charname FROM $dbname3.dbo._Char  inner JOIN  $dbname3.dbo.SK_USER on SK_USER.ID = _Char.UserID and SK_USER.sec_content <> 1 and SK_USER.sec_primary <> 1 order by Charname");

                echo"
                <div class='Apanel-div'>
                <div class='ban-unban'>
                <form  method='post'>
                <input style='margin-bottom:0 !important;' type='radio' id='bycn' name='charorselect' value='usecharname' checked>
                <label for='bycn'>By charname</label><br>
                <input type='text' placeholder='Please, Enter The charname' name='getcharname'></br>
                <input style='margin-top:30px !important;' type='radio' id='byselect' name='charorselect' value='useselect'>
                <label for='byselect'>By Selection</label><br>
                <select  onfocus='this.size=10;' onblur='this.size=1;' onchange='this.size=1; this.blur();' name='selectchar'>  <option value='' disabled Selected>Select The User</option>";
                while($usresult = SQLSRV_FETCH_ARRAY($getus)){
                    $value = $usresult[0];
                    
                    echo "<option value=$value>$value</option>";
                }
                echo"
                </select><br>
                <div class='ban-unban-selection'>
                <input type='radio' id='ban' name='banorunban' value='ban' checked>
                <label for='ban'>Ban</label><br>
                <input type='radio' id='unban' name='banorunban' value='unban'>
                <label for='unban'>UnBan</label>
                </div>
                <br>
                <button name='banunbanconfirm' class='btn-site Apanel-btn' style='margin-left:80px;'>Confirm</button>
                </form>
                </div>
                ";
                
            }else if(array_key_exists('webshop', $_POST)){
                $getlines = SQLSRV_QUERY($dbcn,"SELECT * from $dbname3.dbo._Webshop");
                echo"<div class='addepin-div'>
                <table class='addepin-table'>
                    <tr>
                        <th>#</th>
                        <th>Service</th>
                        <th>Item Name</th>
                        <th>Price</th>
                        <th>Remove</th>
                        <th>Add</th>
                    </tr>";
                    $i=0;
                while($getinfo = SQLSRV_FETCH_ARRAY($getlines)){
                    $Service = $getinfo['Service'];
                    $itemname = $getinfo['Nitem'];
                    $Price = $getinfo['Price'];
                    $id = $getinfo['ID'];
                    $i++;
                    
                    echo"
                        <tr>
                        <form method='post' action='?page=Apanel&id=$id'>
                        <td>$i</td>";
                        if($Service == 0){
                            echo"<td style='font-weight:bold;Color:red;'>Stopped<button style='width:50px;margin-left:20px;background-color:black;' name='Serviceitem' class='addepin-remove-btn'>Run</button></td>";
                        }else{
                            echo"<td style='font-weight:bold;Color:green;'>Working<button style='width:50px;margin-left:20px;background-color:black;' name='Serviceitem' class='addepin-remove-btn'>Stop</button></td>";
                            
                        }
                    echo"
                        
                        <td><span><b>$itemname</b></span></td>
                        <td>$Price</td>
                        <td><button name='Removeitem' class='addepin-remove-btn'>Remove</button></td>
                        <td></td>
                        </form>
                        </tr>
                        ";
                }
                        $i++;
                   echo" 
                        <tr>
                        <form method='post'>
                        <td>$i</td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td><button name='Additem' class='addepin-add-btn'>add</button></td>
                        </form>
                        </tr>
                   </table>
                   </div>";
            }elseif(array_key_exists('downloads',$_POST)){
                $getlines = SQLSRV_QUERY($dbcn,"SELECT * from $dbname3.dbo.downloads");
                echo"<div class='addepin-div'>
                <table class='addepin-table'>
                    <tr>
                        <th>#</th>
                        <th>Description</th>
                        <th>Size</th>
                        <th>Remove</th>
                        <th>Add</th>
                    </tr>";
                    $i=0;
                while($getinfo = SQLSRV_FETCH_ARRAY($getlines)){
                    $description = $getinfo['Name'];
                    $Size = $getinfo['Size'];
                    $id = $getinfo['ID'];
                    $i++;
                    
                    echo"
                        <tr>
                        <form method='post'  action='?page=Apanel&id=$id'>
                        <td>$i</td>";
                        
                    echo"
                        
                        <td><span><b>$description</b></span></td>
                        <td>$Size</td>
                        <td><button name='Removelink' class='addepin-remove-btn'>Remove</button></td>
                        <td></td>
                        </form>
                        </tr>
                        ";
                }
                        $i++;
                   echo" 
                        <tr>
                        <form method='post'>
                        <td>$i</td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td><button name='Addlink' class='addepin-add-btn'>add</button></td>
                        </form>
                        </tr>
                   </table>
                   </div>";
            }
            
        }else{
            SQLSRV_query($dbcn,"INSERT INTO dbo.NTadmin (Username,Mtime,Notice,IP4)values('$User',GETDATE(),'This user tried to login as administrator','$ip')");
            moveto("index.php");
        }
    }else{
        moveto2("?page=news");
    }

    if(isset($_POST['banunbanconfirm'])){
        $charn = $sec->secure($_POST['getcharname']);
        $selection = $_POST['charorselect'];
        if(empty($_POST['selectchar']))
        $charnbyselect= '';
        else
        $charnbyselect = $_POST['selectchar'];
        $banorunban = $_POST['banorunban'];
 

        if($selection == "usecharname"){
            if(strlen($charn) < 5 || strlen($charn) > 16 || !ctype_alnum($charn)){

                SwalfireApanelwithicon("<span style='color:#fff; font-size:18px;'> -- The character name length should be between 5 and 16 characters<br> -- Characters and Numbers only.</span>","#111B2F","black","warning");
            }else{ 
                $ifthereachar = SQLSRV_QUERY($dbcn,"Select * from $dbname3.dbo._char Where Charname = '$charn'");
                    if($banorunban == "ban"){
                        if(SQLSRV_FETCH_ARRAY($ifthereachar) != NULL){
                         sqlsrv_query($dbcn,"UPDATE SK_USER SET ban=1 where ID in (select UserID FROM _CHAR where Charname = '$charn')");
                        SwalfireApanel("<span style='color:#fff;'>$charn has been banned</span>","#111B2F","black");
                        SQLSRV_query($dbcn,"INSERT INTO dbo.NTadmin (Username,Mtime,Notice,IP4)values('$User',GETDATE(),'$User Banned This Character $charn','$ip')");
                    }else{
                            SwalfireApanel("<span style='color:#fff;'>$charn is not found</span>","#111B2F","black");
                        }
                    }elseif($banorunban == "unban"){
                        if(SQLSRV_FETCH_ARRAY($ifthereachar) != NULL){
                        sqlsrv_query($dbcn,"UPDATE SK_USER SET ban=0 where ID in (select UserID FROM _CHAR where Charname = '$charn')");
                        SQLSRV_query($dbcn,"INSERT INTO dbo.NTadmin (Username,Mtime,Notice,IP4)values('$User',GETDATE(),'$User unBanned This Character $charn','$ip')");
                        SwalfireApanel("<span style='color:#fff;'>'$charn' has been unbanned</span>","#111B2F","black");
                        }else{
                        SwalfireApanel("<span style='color:#fff;'>$charn is not found</span>","#111B2F","black");
                        }
                    }
                }
            }else if ($selection == "useselect"){
                if($charnbyselect != ""){
                    if($banorunban == "ban"){
                        sqlsrv_query($dbcn,"UPDATE SK_USER SET ban=1 where ID in (select UserID FROM _CHAR where Charname = '$charnbyselect')");
                        SwalfireApanel("<span style='color:#fff;'>'$charnbyselect' has been banned</span>","#111B2F","black");
                        SQLSRV_query($dbcn,"INSERT INTO dbo.NTadmin (Username,Mtime,Notice,IP4)values('$User',GETDATE(),'$User Banned This Character $charnbyselect','$ip')");
                    }elseif($banorunban == "unban"){
                        sqlsrv_query($dbcn,"UPDATE SK_USER SET ban=0 where ID in (select UserID FROM _CHAR where Charname = '$charnbyselect')");
                        SwalfireApanel("<span style='color:#fff;'>'$charnbyselect' has been unbanned</span>","#111B2F","black");
                        SQLSRV_query($dbcn,"INSERT INTO dbo.NTadmin (Username,Mtime,Notice,IP4)values('$User',GETDATE(),'$User unBanned This Character $charnbyselect','$ip')");
                     }
                }else{SwalfireApanel("<span style='color:#fff;'>Process failed, you didn't select a character","#111B2F","black"); }
        }

    }
        if(isset($_POST['removeepin'])){
            $id = $_GET['id'];
            SQLSRV_QUERY($dbcn,"DELETE FROM epin Where ID = $id ");
            SwalfireApanel("<span style='color:#fff;'>Code has been removed</span>","#111B2F","black");
         }
         
         if(isset($_POST['addepin']) && isset($_POST['entercode']) && isset($_POST['enteramount'])){
            $uniquecode = SQLSRV_QUERY($dbcn,"Select pin from epin");
        
                 $c = 0;
                 $k = $sec->secure($_POST['entercode']);
                 $y = $_POST['enteramount'];
                 $adminid = $R['ID'];
                 $md5code = md5($k);
                 while($unique = SQLSRV_FETCH_ARRAY($uniquecode)){
                     if($md5code == $unique['pin'] ){
                         $c = 1;
                     }   
                 }
             if((strlen($k) > 10 && strlen($k) < 32) && $y > 0){
                     if($c == 1){
                     SwalfireApanel2("<span style='color:#fff;'>$k This code already used</span>","#111B2F","black");
                     }else{
                     SQLSRV_QUERY($dbcn,"INSERT INTO epin(realpin,pin,silk,AdminID) values('$k','$md5code',$y,$adminid)");
                     SwalfireApanel("<span style='color:#fff;'>$k This code has been added</span>","#111B2F","black");
                     }
             }else{
                 ?> <script> document.getElementsByName('entercode')[0].placeholder='10-32 letters or numbers';
                  </script> <?php
             }
         }
         #----------------------------------------news-section-----------------------------------------------#
         if(isset($_POST['deletebtnnews'])){
             
            if(empty($_POST['selectsubject'])){
                SwalfireApanel("<span style='color:#fff;'>Please, Select a subject","#111B2F","black");
            }else{
                $Selectsubject = $_POST['selectsubject'];
                SQLSRV_QUERY($dbcn,"DELETE FROM $dbname3.dbo.news WHERE [Subject] = '$Selectsubject'");
                SwalfireApanel("<span style='color:#fff;'>The subject has been removed","#111B2F","black");
            }
            
        }

        if(isset($_POST['addbtnnews'])){
                $_SESSION['itsadmin'] = 'imadmin';
                moveto("?page=addsubject");
        }

        if(isset($_POST['editbtnnews'])){
            
        if(empty($_POST['selectsubject'])){
            SwalfireApanel3("<span style='color:#fff;'>Please, Select a subject","#111B2F","black");
        }else{
            $Selectsubject1 = $_POST['selectsubject'];
            $_SESSION['itsadmin'] = 'imadmin';
            moveto("?page=editsubject&subjectvalue=$Selectsubject1");
            }
        }
        /***********************Failed&Succues msgs******************************/
        if(isset($_GET['failed']) && isset($_SESSION['StatusMSG'])){
            if($_GET['failed'] == 1){
            unset($_SESSION['StatusMSG']);
            SwalfireApanel("<span style='color:#fff;'>Please, Select a subject</span>","#111B2F","black");
             }
            if($_GET['failed'] == 2){
                unset($_SESSION['StatusMSG']);
                SwalfireApanel("<span style='color:#fff;'>All inputs are required</span>","#111B2F","black");
            }
            
        }
        if(isset($_GET['succuess']) && isset($_SESSION['StatusMSG'])){
            if($_GET['succuess'] == 5){
                unset($_SESSION['StatusMSG']);
                SwalfireApanel("<span style='color:#fff;'>Your Request Has Been Submitted</span>","#111B2F","black");
            }
            if($_GET['succuess'] == 6){
                unset($_SESSION['StatusMSG']);
                SwalfireApanel("<span style='color:#fff;'>The subject has been removed</span>","#111B2F","black");
            }
            if($_GET['succuess'] == 7){
                unset($_SESSION['StatusMSG']);
                SwalfireApanel("<span style='color:#fff;'>The subject has been added</span>","#111B2F","black");
            }
            if($_GET['succuess'] == 8){
                unset($_SESSION['StatusMSG']);
                SwalfireApanel("<span style='color:#fff;'>The Item has been added</span>","#111B2F","black");
            }
            if($_GET['succuess'] == 9){
                unset($_SESSION['StatusMSG']);
                SwalfireApanel("<span style='color:#fff;'>The Item service has been started</span>","#111B2F","black");
            }
            if($_GET['succuess'] == 10){
                unset($_SESSION['StatusMSG']);
                SwalfireApanel("<span style='color:#fff;'>The Item service has been stopped</span>","#111B2F","black");
            }
            if($_GET['succuess'] == 11){
                unset($_SESSION['StatusMSG']);
                SwalfireApanel("<span style='color:#fff;'>The Link has been removed</span>","#111B2F","black");
            }
            if($_GET['succuess'] == 12){
                unset($_SESSION['StatusMSG']);
                SwalfireApanel("<span style='color:#fff;'>The Link has been added</span>","#111B2F","black");
            }
        }

        /***************************************WebShop**************************************/
        if(isset($_POST['Additem'])){
            $itemslist = SQLSRV_QUERY($dbcn,"SELECT _Items.ID,_Items.CODE_ITEM,_Items.NAME_ITEM FROM $dbname3.dbo._Items LEFT JOIN  $dbname3.dbo._Webshop ON $dbname3.dbo._Webshop.ItemID = $dbname3.dbo._Items.ID WHERE $dbname3.dbo._Webshop.ItemID is NULL");
            
            
            echo"
            <div class='webshop-admin-div'>
                 <form enctype='multipart/form-data' method='POST'>
                 <select  onfocus='this.size=10;' onblur='this.size=1;' onchange='this.size=1; this.blur();' name='itemslist'>  <option value='' disabled Selected>Select The Item</option>
                    ";
                   while($itemslistfetch = SQLSRV_FETCH_ARRAY($itemslist)){
                       
                       if($itemslistfetch['ID'] == 0){

                    }else{
                        $itemcode = $itemslistfetch['CODE_ITEM'];
                        $itemname = $itemslistfetch['NAME_ITEM'];
                        echo"<option value='$itemcode'>$itemname</option>";
                    }
                    
                   }
                   
                 echo"
                    </select><br>
                    <input  type='text' style='width:250px;' maxlength='15' placeholder='Enter The Item Name' name='enteritemname' autocomplete='off'>
                    <br><span>Price</span><br>
                    <input style='margin-top:0;width:100px;' type='number' min='0' value=0 name='enterprice'><br> <span style='color:#2D3F6B; font-size:20px;'> (Item, Name, Price, Image are required)</span>
                    
                    
                    <div class='imgupload-div'>
                    <span>imgurl : </span>
                    <input accept='image/png, image/jpeg, image/gif' name='imgchoice' onchange = getPath('imgchoice1','imgg1') type='file' id='imgchoice1' style='width:90px;'/>
                    <label id='imgg1' for='imgchoice1'>Select a image:</label>
                    </div>

   
                   
                    <button name='confirmitem' class='btn-site btn-editconfirm'>Confirm</button>
                    </form>
                   
                </div>
               ";
        }
        /***********************Service button **********************/
        if(isset($_POST['Serviceitem'])){
            $id = $_GET['id'];
            $getservice = SQLSRV_QUERY($dbcn,"SELECT [Service] FROM $dbname3.dbo._Webshop Where ID = $id ");
            $servicefetch = SQLSRV_FETCH_ARRAY($getservice);
            if($servicefetch['Service'] == 0){
                SQLSRV_QUERY($dbcn,"UPDATE $dbname3.dbo._Webshop SET [Service] = 1 Where ID = $id");
                moveto("?page=Apanel&succuess=9");
            }else{
                SQLSRV_QUERY($dbcn,"UPDATE $dbname3.dbo._Webshop SET [Service] = 0 Where ID = $id");
                moveto("?page=Apanel&succuess=10");
            }
        }
        /******************************Remove button*****************/
        if(isset($_POST['Removeitem'])){
            $id = $_GET['id'];
            $Q = SQLSRV_QUERY($dbcn,"DELETE FROM $dbname3.dbo._Webshop Where ID = $id");
                moveto("?page=Apanel&succuess=5");
          
        }

        if(isset($_POST['confirmitem'])){
            if(!empty($_POST['itemslist']))
            $icode = $sec->secure($_POST['itemslist']);
            else
            $icode = NULL;
            $getiID = SQLSRV_QUERY($dbcn,"Select ID FROM $dbname3.dbo._items Where CODE_ITEM = '$icode' ",array(),array('scrollable' => SQLSRV_CURSOR_KEYSET));
            $pushiID = SQLSRV_FETCH_ARRAY($getiID);
            $iname = $sec->secure($_POST['enteritemname']);
            $iprice = $_POST['enterprice'];
            
            $typefile = array(
                'image/jpeg',
                'image/jpg',
                'image/gif',
                'image/png'
            );
            if(SQLSRV_NUM_ROWS($getiID) > 0){
            if (empty($iname)){
                SwalfireApanel("<span style='color:#fff;'>The item name shouldn't be empty</span>","#111B2F","black");
            }else{
                if(!empty($_FILES['imgchoice']) && $_FILES['imgchoice']['size'] <= 2097152 && in_array($_FILES['imgchoice']['type'],$typefile)){
                    $ID = $pushiID['ID'];
                    $imgdir = "./php/webshop/img/";
                    $file = $imgdir . basename($_FILES['imgchoice']['name']);
                    move_uploaded_file($_FILES['imgchoice']['tmp_name'],$file);
                    $add = SQLSRV_QUERY($dbcn,"INSERT INTO $dbname3.dbo._Webshop([Service],Nitem,Price,ItemID,img)values(1,'$iname','$iprice',$ID,'$file')");
                    moveto("?page=Apanel&succuess=8");
                }else{
                    SwalfireApanel("<span style='color:#fff;'>1.the file shouldn't be empty<br>2.The image size should be less than 2 MB<br>3.The image type should be (jpeg,jpg,gif,png)</span>","#111B2F","black");
                    
                }
                
            
                
                
            }
        }else{
            SwalfireApanel("<span style='color:#fff;'>Please, Select an item</span>","#111B2F","black");
        }
            
        }
        /*************************Download add form ***********************/
        if(isset($_POST['Addlink'])){
            
            
            
            echo"
            <div class='webshop-admin-div'>
                 <form enctype='multipart/form-data' method='POST'>
                
                    <input  type='text' style='width:600px;' minlength='10' maxlength='50' placeholder='Enter The Link Description' name='enterlinkdes' autocomplete='off'>
                    <input  type='text' style='width:600px;' placeholder='Enter The Link' name='enterlink' autocomplete='off'>
                    <br><span>Size</span><br>
                    <input style='margin-top:0;width:100px;' type='number' step='0.01' min='0' value=0 name='entersize'>
                    <Select style='width:100px;' name='selectsize'>
                        <option selected value='GB'>GB</option>
                        <option value='MB'>MB</option>
                    </select>
                    <button name='confirmlink' class='btn-site btn-editconfirm'>Confirm</button>
                    </form>
                   
                </div>
               ";
        }
        if(isset($_POST['confirmlink'])){
            $desc = $sec->secure($_POST['enterlinkdes']);
            $lin = $sec->secure($_POST['enterlink']);
            $siz1 = $_POST['selectsize'];
            $siz2 = $sec->secure($_POST['entersize']);
            $rsize = "$siz2 $siz1";
            if(empty($desc) || empty($siz2) || empty($lin)){

                moveto("?page=Apanel&failed=2");
                
            }else{
                SQLSRV_QUERY($dbcn,"INSERT INTO $dbname3.dbo.downloads([Name],[Link],[Addby],[Size])values('$desc','$lin','$User','$rsize')");
                moveto("?page=Apanel&succuess=12");
            }
             
        }
        if(isset($_POST['Removelink'])){
            $id = $_GET['id'];
            $delete = SQLSRV_QUERY($dbcn,"DELETE FROM $dbname3.dbo.downloads Where ID = $id");
            moveto("?page=Apanel&succuess=11");
        }

?>