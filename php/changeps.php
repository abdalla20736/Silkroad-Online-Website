<head>
<script src="./js/functions.js"></script>
</head>
<?php
echo"<span style=' margin-left:5px; color:#fff !important; font-size:40px; '>Change Password</span>";
if(isset($_POST['Changebutton'])){
    $currentps= $sec->secure($_POST['changepstext1']);
    $new1ps= $sec->secure($_POST['changepstext2']);
    $rps= $sec->secure($_POST['changepstext3']);
    $currps = md5($currentps);
    $newps = md5($new1ps);
    $repeatps = md5($rps);
    $error = null;
    $error1 = null;
    $error2 = null;
    if(empty($currentps)){
        $error = "Please, Enter the password";
    }elseif(!Checkpassword($currentps)){
         $error = "the password between 8 ~ 32 letters and nummbers only";
    }
    if(empty($new1ps)){
        $error1 = "Please, Enter the password";
    }elseif(!Checkpassword($new1ps)){
         $error1 = "the password between 8 ~ 32 letters and nummbers only";
    }
    if(empty($rps)){
        $error2 = "Please, Enter the password";
    }elseif(!Checkpassword($rps)){
         $error2 = "the password between 8 ~ 32 letters and nummbers only";
    }
    
     if($error == null && $error1 == null && $error2 == null){

     $getcurrps = sqlsrv_query($dbcn,"select * from $dbname3.dbo.SK_USER where Username = '".$_SESSION['User']."'");
        $getcurrpsres = SQLSRV_FETCH_ARRAY($getcurrps);


 
        if($getcurrpsres['password'] == $currps){
        
        
         if($newps === $repeatps && $getcurrpsres['password'] != $newps){
            SQLSRV_QUERY($dbcn,"UPDATE SK_USER SET [Password] = '".$newps."', Realpassword = '$new1ps' Where Username = '".$_SESSION['User']."'");
            echo '<script>alert("the Password has been changed");window.location.href="?page=myaccount";</script>';

         }else{
            echo '<script>alert("The repeated password not the same such as the new password or your current password equal to the new password.");window.location.href="?page=changeps";</script>';
                }
            }else{
                echo'  
                 <div  class="changepsform"><form  class="changepsform" method="post" action="?page=changeps">
                 <span>Current Password &nbsp;</span>
                 <input type="password" id="text1" name="changepstext1"><br>
                <span>New Password &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</span>
                <input type="password" id="text2" name="changepstext2"><br>
                <span>Repeat Password &nbsp;&nbsp;&nbsp;</span>
                <input type="password" id="text3" name="changepstext3"><br>
                <button class="btn-site myaccount-btn" name="Changebutton">Change Password</button>
                    </form> </div>';
                ?>
                <script> changepsjs("text1","The password's incorrect !!!") </script>
                <?php
            }
        
        } else{
            echo'   <div class="changepsform"><form class="changepsform" method="post" action="?page=changeps">
        <span>Current Password &nbsp;</span>
        <input type="password" id="text1" name="changepstext1"><br>
        <span>New Password &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</span>
        <input type="password" id="text2" name="changepstext2"><br>
        <span>Repeat Password &nbsp;&nbsp;&nbsp;</span>
        <input type="password" id="text3" name="changepstext3"><br>
        <button class="btn-site myaccount-btn" name="Changebutton">Change Password</button>
            </form> </div>';

            if(empty($currentps)){
                ?>
                <script type="text/javascript">
                    changepsjs("text1", "Please, Enter the password");
                </script>
                <?php
            }elseif(!Checkpassword($currentps)){
                 ?>
                 <script> 
                    changepsjs("text1", "The password between 8 ~ 32 letters and nummbers only");
                 </script>
                <?php
            }
            
            if(empty($new1ps)){
                ?><script> 
                    changepsjs("text2", "Please, Enter the password");
                </script> <?php
            } elseif(!Checkpassword($new1ps)){
                ?><script> 
                    changepsjs("text2", "The password between 8 ~ 32 letters and nummbers only");
                </script> <?php
            }
            
            if(empty($rps)){
                ?><script> 
                    changepsjs("text3", "Please, Enter the password");
                </script> <?php
            }elseif(!Checkpassword($rps)){
                ?><script> 
                    changepsjs("text3", "The password between 8 ~ 32 letters and nummbers only");
                </script> <?php
            
            }
        }
           

         
    }else if(isset($_SESSION['loggedin'])){
        echo'   <div class="changepsform"><form class="changepsform" method="post" action="?page=changeps">
        <span>Current Password &nbsp;</span>
        <input type="password" name="changepstext1"><br>
        <span>New Password &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</span>
        <input type="password" name="changepstext2"><br>
        <span>Repeat Password &nbsp;&nbsp;&nbsp;</span>
        <input type="password" name="changepstext3"><br>
        <button class="btn-site myaccount-btn" name="Changebutton">Change Password</button>
            </form> </div>';
    }else{
        echo "<script>window.location.href = 'index.php';</script>";
    }

?>