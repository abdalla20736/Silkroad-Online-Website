<?php
        use PHPMailer\PHPMailer\PHPMailer;
        use PHPMailer\PHPMailer\SMTP;
        use PHPMailer\PHPMailer\Exception;

        if(isset($_SESSION['User'])){
                
            echo "<div class='exist-msg'><h1>".$sitename."</h1>
                <p>You must logout in order to register an account.</p></div>";
        }else{
                if(isset($_POST['signup'])){
                $us = $sec->secure($_POST['reg-username']);
                $ps = $sec->secure($_POST['reg-password']);
                $ps2 = $sec->secure($_POST['reg-password2']);
                $em= $sec->secure($_POST['reg-email']);
                $em2= $sec->secure($_POST['reg-email2']);
                $NickN = $sec->secure($_POST['reg-nickname']);
                $confirmcode = md5(uniqid(rand()));

                        
                #-----user-security-----#
                if(empty($us)){
                        $error[] = "Please fill username input.";
                }else{
                        if(strlen($us) < 5) $error[] =  "Username too short";
                        if(strlen($us) > 16) $error[] = "Username too long";
                        if(!ctype_alnum($us)) $error[] = "Username should be Characters and Numbers only.";
                }
                #-----End-user-security-----#
                #-----Password-security-----#
                if(empty($ps)){
                        $error[] = "Please fill password inputs.";
                }else{
                        if(strlen($ps) < 8) $error[] =  "Password too short";
                        if(strlen($ps) > 32) $error[] = "Password too long";
                        if(!ctype_alnum($ps)) $error[] = "Password should be Characters and Numbers only.";
                }
               
                if(empty($ps2)){
                        $error[] = "Please fill password inputs.";
                }else{
                        if(strlen($ps2) < 8) $error[] =  "Password too short";
                        if(strlen($ps2) > 32) $error[] = "Password too long";
                        if(!ctype_alnum($ps2)) $error[] = "Password should be Characters and Numbers only.";
                }#------Check match----#
                        if($ps != $ps2){
                                $error[] = "Password do not match";
                        }
                #-----END-Password-security-----#
                #---------Nickname and username-----#
                        if(empty($NickN)){
                           $error[] = "Please fill nickname input.";
                        }else{
                        if(strlen($NickN) < 5) $error[] =  "Nickname too short";
                        if(strlen($NickN) > 32) $error[] = "Nickname too long";
                        if(!ctype_alnum($NickN)) $error[] = "Nickname should be Characters and Numbers only.";
                        }
                        if($us == $NickN){
                                $error[] = "The username and nickname shouldn't be same";
                        }
                #--------END-Nickname and username-----#
                 #-----END-E-mail-security-----#
                if(empty($em)){
                        $error[] = "Please fill E-mail inputs.";
                }elseif(!filter_var($em,FILTER_VALIDATE_EMAIL)){
                        $error[] = "Email not valid";
                }
                if(empty($em2)){
                        $error[] = "Please fill E-mail inputs.";
                }elseif(!filter_var($em,FILTER_VALIDATE_EMAIL)){
                        $error[] = "Email not valid";
                }
                        if($em != $em2){
                                $error[] = "Email do not match";
                        }
                 #-----END-E-mail-security-----#
                if(@count($error) > 0){
                        echo'<div class="reg-error">';
                        for($err = 0; $err <count($error); $err++){
                                echo'<b>- Error:</b>'.$error[$err].'<br>';
                        }

                        echo'<br> <a href="?page=createacc">Go back and try again.</a></div>';

                }else{
                        $exist = sqlsrv_query($dbcn,"Select * from $dbname3.dbo.SK_USER Where Username = '$us' or Email = '$em'",array(),array("scrollable" => SQLSRV_CURSOR_KEYSET));
                        $account_exist = sqlsrv_num_rows($exist);
                        
                        if($account_exist > 0){
                                echo '<div class="reg-error"><b>Error:</b> An account with such Username or Email already exists.<br><br> <a href="?page=createacc">Go back and try again</a> </div>';
                               
                        }else{
                                $pshash = md5($ps);
                                $q1=sqlsrv_query($dbcn,"INSERT INTO $dbname3.dbo.SK_USER ([Username],[password],[Name],[Email],[sec_primary],[sec_content],[ban],[LastWebvisit],[Status],Realpassword,Active,Code) Values ('$us','$pshash','$NickN','$em',3,3,0,GETDATE(),0,'$ps',0,'$confirmcode')");
                                $q2=sqlsrv_query($dbcn,"INSERT INTO $dbname3.dbo.SK_Silk (ID,silk)VALUES((Select ID FROM SK_USER WHERE username = '$us'),'0')");
                                if($q1 && $q2){
                                        $url = $_SERVER['HTTP_HOST'];
                                        $activeurl = "http://$url?page=Activereg&u=$us&cod=$confirmcode";
                                        $_SESSION['Active'] = 'YES';
                                        $_SESSION['LAST_ACTIVITY'] = time();
                                        //************************send active mail*****************/
                                        
                                        if(isset($_SESSION['Active'])){
                                                require './php/forgetpassword/PHPMailer/src/Exception.php';
                                                require './php/forgetpassword/PHPMailer/src/PHPMailer.php';
                                                require './php/forgetpassword/PHPMailer/src/SMTP.php';
                                                unset($_SESSION['Active']);
                                                $mail = new PHPMailer(true);
                                                
                                                try {
                                                    //Server settings
                                                    $mail->SMTPDebug = false; //SMTP::DEBUG_SERVER;                      // Enable verbose debug output
                                                    $mail->isSMTP();                                            // Send using SMTP
                                                    $mail->Host       = 'smtp.gmail.com';                    // Set the SMTP server to send through
                                                    $mail->SMTPAuth   = true;                                   // Enable SMTP authentication
                                                    $mail->Username   = 'abdalla20736@gmail.com';                     // SMTP username
                                                    $mail->Password   = 'Aa3199462';                               // SMTP password
                                                    $mail->SMTPSecure = 'tls';         // Enable TLS encryption; `PHPMailer::ENCRYPTION_SMTPS` encouraged
                                                    $mail->Port       = 587;                                    // TCP port to connect to, use 465 for `PHPMailer::ENCRYPTION_SMTPS` above
                                                
                                                    //Recipients
                                                    $mail->setFrom('abdalla20736@gmail.com', 'Silkroad Online');
                                                    $mail->addAddress("$em", "$NickN");     // Add a recipient
                                                    $mail->addReplyTo('abdalla20736@gmail.com', 'Silkroad Online');
                                                
                                                
                                                    // Content
                                                    $mail->isHTML(true);                                  // Set email format to HTML
                                                    $mail->Subject = 'Silkroad Online User Registration Activation Email';
                                                    $mail->Body    = "<h1>Hello $NickN.</h1><br><br><br>  
                                                    <span style='font-size:16px; font-style:italic;'>Click this link to activate your account.<br>
                                                     <a href='$activeurl'>$activeurl</a><br>
                                                     The link is available only for 1 day.
                                                    </span";
                                                    $mail->AltBody = 'Silkroad Online Activition Mail';
                                                
                                                    $mail->send();
                                                    moveto('?page=news&success=1');
                                                    } catch (Exception $e) {
                                                    moveto('?page=news&failed=2');
                                                    }
                                                }
                                                /***********************************************************************/

                                }else{
                                        moveto('?page=createacc&failed=1');
                                }
                        }
                }

            }
            else{
                echo"<span style=' margin-left:5px; color:#fff !important; font-size:40px; '>Register</span>";
                    echo '
                    <div class="reg-page-common">
                        
                        
                        <div>
                            <form action="?page=createacc" method="post">
                                
                                <input class="reg-input" type="text" name="reg-username" placeholder="Username*" autocomplete="off">
                                <input class="reg-input" type="text" name="reg-nickname" placeholder="Nickname*" autocomplete="off"> <span>&nbsp;(Min-5 letters or numbers)</span><br>
                                <input class="reg-input" type="password" name="reg-password" placeholder="Password*" autocomplete="off">
                                <input class="reg-input" type="password" name="reg-password2" placeholder="Repeat password*" autocomplete="off"> <span>&nbsp;(Min-8 letters or numbers)</span><br>
                                <input class="reg-input" type="email" name="reg-email" placeholder="E-mail*" autocomplete="remove">
                                <input class="reg-input" type="email" name="reg-email2" placeholder="Repeat E-mail*" autocomplete="nope"><span>(Email should be valid&real)</span><br>

                                
                             
                                


                                <input class="btn-site btn-register" type="Submit" value="Sign up !!" name ="signup">

                            </form>
                        </div>
                        <div class="terms">
                        <b>Your passwords and account security</b><br><br>
	
			1.1 You agree and understand that you are responsible for maintaining the confidentiality of passwords associated with any account you use to access any of our services.<br><br>
			1.2 Accordingly, you agree that you will be solely responsible to SilkCore for all activities that occur under your account.<br><br>
			1.3 You agree that you will not engage in any activity that interferes with or disrupts the services we provided.<br><br>
			1.4 You agree to not promote or use any third party material, which could change gameplay or effect the environment to other users.
			This could include automated bots or scripts, in doing so, your account could be punished from accessing any services.
                        </div>
                        </div>
                        ';
            }  
            if(isset($_GET['failed']) && isset($_SESSION['StatusMSG'])){
                if($_GET['failed'] == 1){
                    unset($_SESSION['StatusMSG']);
                    SwalfireApanel2("<span style='color:#fff;'>Error, Please Try to contact with the administrator</span>","#111B2F","black");
                }
           
        }
        }
?>