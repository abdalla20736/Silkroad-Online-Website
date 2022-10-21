<?php

include('_Setting.php');
echo"<span style=' margin-left:5px; color:#fff !important; font-size:40px; '>Login</span>";
if(isset($_SESSION['loggedin'])){
    echo '<meta http-equiv="refresh" content="0; url=index.php">';
}else{
            echo' <div class="login-inside" style="margin-top:30px;">
            <div class="login-mainworddiv">
           <h1 class="login-mainword">Login to your account</h1>
            </div>
       <form method ="post" action="?page=login">
       <label for="Login"></label>
        <div class="showlogin-marginauto">
       <input type="text" placeholder="Username" name="ouruser" autocomplete="off">
        <label for="Password"></label>   
       <input type="password" name="pass" placeholder="Password" autocomplete="off"><br>
        </div>
       <span>You dont have an Account ?</span> <a href="?page=createacc">Register</a>
       <input type="Submit"  class="btn-site btn-login-div" name="lo" value="Login" >
       
       </form >
       <div class="showlogin-borderupper">
       <p>Forget your Password ? no worries, <a href="?page=recoverps">click here</a> &nbsp;to reset your password.</p>
        </div>
       </div> 
            ';        
    
}
if(isset($_POST['lo']))
        {
            $us = $sec->secure($_POST['ouruser']);
            $ps = $sec->secure($_POST['pass']);
                if(empty($us)){
                $error[] = "Please fill username input.";
                 }else{
                if(strlen($us) < 5) $error[] =  "Username too short";
                if(strlen($us) > 16) $error[] = "Username too long";
                if(!ctype_alnum($us)) $error[] = "Username should be Characters and Numbers only.";
                }

                if(empty($ps)){
                    $error[] = "Please fill password input.";
                 }else{
                    if(strlen($ps) < 8) $error[] =  "Password too short";
                    if(strlen($ps) > 32) $error[] = "Password too long";
                    if(!ctype_alnum($ps)) $error[] = "Password should be Characters and Numbers only.";
                }

                if(@count($error) > 0){
                    echo '<script>alert("';
                    $i =0;
                    for($err = 0; $err < count($error);$err++){
                        $i++;
                        echo $i.": ".$error[$err].'\n';
                    } echo '")</script>';
                } else{

                $checkban = sqlsrv_query($dbcn,"select * From $dbname3.dbo.SK_USER Where Username = '$us' and ban = 1",array(),array("scrollable" => SQLSRV_CURSOR_KEYSET)) or die("<h1><center>Error code #6</h1></center>");
                if(sqlsrv_num_rows($checkban) != 0){
                    echo '<script>alert("Account is banned.")</script>';
                }else{

                $pshash = md5($ps);
                 $getuser= sqlsrv_query($dbcn,"select * From $dbname3.dbo.SK_USER Where Username = '$us' and Password = '$pshash'",array(),array("scrollable" => SQLSRV_CURSOR_KEYSET)) or die("<h1><center>Error code #6</h1></center>");
                 $getuserresults = sqlsrv_fetch_array($getuser);
                if(sqlsrv_num_rows($getuser) != 1){
                    echo '<script>alert("Wrong username or password.")</script>';
                }else if($getuserresults['Active'] != 1){
                    echo '<script>alert("This account is not activited.")</script>';   
                }else {
                    $getthecharid = sqlsrv_query($dbcn,"Select top 1 * From _Char where UserID in (Select ID FROM SK_USER WHERE Username = '".$getuserresults['username']."' )");
                    
                    sqlsrv_query($dbcn,"UPDATE $dbname3.dbo.SK_USER SET LastWebvisit = GETDATE() Where Username = '$us'");
                    sqlsrv_query($dbcn,"UPDATE $dbname3.dbo.SK_USER SET [status] = 1 Where Username = '$us'");
                    
                    $now = time();
                    $_SESSION['loggedin'] = "YES";
                    $_SESSION['TIMEOUTS'] = time();
                    $_SESSION['User']=$getuserresults['username'];
                    if($getcharid = sqlsrv_fetch_array($getthecharid))
                    $_SESSION['Char']=$getcharid['ID'];
                    else{$_SESSION['Char']=null;}

                    echo '<script>alert("You logged in succussful"); window.location.href="index.php";</script>';
                    
                    
                    
                    
                    
                    
                    
                    }
                
                }
            }
        }

?>

