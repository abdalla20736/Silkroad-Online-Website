<?php
            if(isset($_POST['confirmedit'])){
                $Selectsubject = $_GET['v'];
                $user = $_SESSION['Char'];
                $char = SQLSRV_QUERY($dbcn,"Select Charname FROM _char Where ID = $user ");
                $getcharname = SQLSRV_FETCH_ARRAY($char);
                $charname = $getcharname['Charname'];
                $textarea = $sec->secure($_POST['Articletext']);
                if(strlen($textarea) >= 1 && strlen($textarea) <= 1000){
                   
                    $uploaddir = './newsimgs/';
                    SQLSRV_QUERY($dbcn,"UPDATE $dbname3.dbo.news SET author = '$charname', [Article] = '$textarea', postdate=GETDATE() where [Subject] = '$Selectsubject'");
                    for($i = 1; $i < 5; $i++){
                     
         
                        if(!empty($_FILES["imgchoice$i"])){
                        $uploadfile = $uploaddir . basename($_FILES["imgchoice$i"]['name']);
                        if(move_uploaded_file($_FILES["imgchoice$i"]['tmp_name'], $uploadfile)){
                            SQLSRV_QUERY($dbcn,"UPDATE $dbname3.dbo.news SET  imgurl$i = '$uploadfile' WHERE [Subject] = '$Selectsubject' ");
                        }
                      }
                    }
                   
                    if(!empty($_POST['checked'])){
                        foreach($_POST['checked'] as $checked){
                           SQLSRV_QUERY($dbcn,"UPDATE news SET $checked = NULL where [Subject] = '$Selectsubject'");
                        }
                    }   
                    
                     moveto("?page=Apanel&succuess=5");
                    
            }else{
                $_SESSION['itsadmin'] = 'imadmin';
                moveto("?page=editsubject&failed=5&subjectvalue=$Selectsubject");
                exit();
            }
         }
?>