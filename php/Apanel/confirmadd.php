<?php
            if(isset($_POST['confirmadd'])){
                $subject = $sec->secure($_POST['subjectname']);
                $user = $_SESSION['Char'];
                $char = SQLSRV_QUERY($dbcn,"Select Charname FROM _char Where ID = $user ");
                $getcharname = SQLSRV_FETCH_ARRAY($char);
                $charname = $getcharname['Charname'];
                $textarea = $sec->secure($_POST['Articletext']);
                $uniqsubject = SQLSRV_QUERY($dbcn,"Select * from $dbname3.dbo.news where [Subject] = '$subject'",array(),array('scrollable' => SQLSRV_CURSOR_KEYSET));
                if(SQLSRV_NUM_ROWS($uniqsubject) == 0 && !empty($subject)){
                if(strlen($textarea) >= 1 && strlen($textarea) <= 1000){
                   
                    $uploaddir = './newsimgs/';
                    SQLSRV_QUERY($dbcn,"INSERT INTO $dbname3.dbo.news([Subject],Article,author,postdate)values('$subject','$textarea','$charname',GETDATE())");
                    for($i = 1; $i < 5; $i++){
                     
         
                        if(!empty($_FILES["imgchoice$i"])){
                        $uploadfile = $uploaddir . basename($_FILES["imgchoice$i"]['name']);
                        if(move_uploaded_file($_FILES["imgchoice$i"]['tmp_name'], $uploadfile)){
                            SQLSRV_QUERY($dbcn,"UPDATE news SET  imgurl$i = '$uploadfile' WHERE [Subject] = '$subject' ");
                        }
                      }
                    }
                    
                     moveto("?page=Apanel&succuess=7");
            }else{
                $_SESSION['itsadmin'] = 'imadmin';
                moveto("?page=addsubject&failed=5");
            }
        }else{
            $_SESSION['itsadmin'] = 'imadmin';
            moveto("?page=addsubject&failed=6");
           
        }
         }
?>