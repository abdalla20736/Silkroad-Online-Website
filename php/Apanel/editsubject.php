<?php
        echo"<span style=' margin-left:5px; color:#fff !important; font-size:40px; '>Edit Subject</span>";
        if(isset($_GET['failed']) && isset($_SESSION['itsadmin'])){
            SwalfireApanel2("<span style='color:#fff;'>The text between 1 - 1000 characters","#111B2F","black");
        }
        if(isset($_GET['subjectvalue']) && isset($_SESSION['itsadmin'])){
            unset($_SESSION['itsadmin']);
            $Selectsubject = $_GET['subjectvalue'];
            $getsubjectinfo = SQLSRV_QUERY($dbcn,"SELECT * FROM $dbname3.dbo.news WHERE [Subject] = '$Selectsubject'");
            $subjectinfo = SQLSRV_FETCH_ARRAY($getsubjectinfo);
            $getsubject = $subjectinfo['Subject'];
            $getarticle = $subjectinfo['Article'];
            $getimg1 = $subjectinfo['imgurl1'];
            $getimg2 = $subjectinfo['imgurl2'];
            $getimg3 = $subjectinfo['imgurl3'];
            $getimg4 = $subjectinfo['imgurl4'];
            

            echo"
            <div class='editnews-editdiv'>
                 <form enctype='multipart/form-data' method='POST' action='?page=confirmedit&v=$Selectsubject'>

                    <span>Subject : </span>
                    <input style='margin-bottom:20px;' name='subjectname' type='text'disabled value='$getsubject'><br>
                    <span class='spanart'>Article :</span>
                    <textarea class='Article-text'autocomplete='off' rows='5' cols='30' type='text' rows='1' maxlength='1000' name='Articletext'>$getarticle</textarea>
                    
                    <div class='imgupload-div'>
                    <span>imgurl1 : </span>
                    <input accept='image/png, image/jpeg, image/gif' name='imgchoice1' onchange = getPath('imgchoice1','imgg1') type='file' id='imgchoice1' style='width:90px;'/>
                    <label id='imgg1' for='imgchoice1'>Select a image:</label>
                    <input style='margin-left:20px;' onclick=noimgcheck('noimg1','imgchoice1') type='checkbox' id='noimg1' value='imgurl1' name='checked[]'>
                    <label for='noimg1'>Remove the image</label>
                    </div>

                    <div class='imgupload-div'>
                    <span>imgurl2 : </span>
                    <input accept='image/png, image/jpeg, image/gif' name='imgchoice2' onchange = getPath('imgchoice2','imgg2') type='file' id='imgchoice2' style='width:90px;'/>
                    <label id='imgg2' for='imgchoice2'>Select a image:</label>
                    <input style='margin-left:20px;' onclick=noimgcheck('noimg2','imgchoice2') type='checkbox' id='noimg2' value='imgurl2' name='checked[]'>
                    <label for='noimg2'>Remove the image</label>
                    </div>

                    <div class='imgupload-div'>
                    <span>imgurl3 : </span>
                    <input accept='image/png, image/jpeg, image/gif' name='imgchoice3' onchange = getPath('imgchoice3','imgg3') type='file' id='imgchoice3' style='width:90px;'/>
                    <label id='imgg3' for='imgchoice3'>Select a image:</label>
                    <input style='margin-left:20px;' onclick=noimgcheck('noimg3','imgchoice3') type='checkbox' id='noimg3' value='imgurl3' name='checked[]'>
                    <label for='noimg3'>Remove the image</label>
                    </div>

                    <div class='imgupload-div'>
                    <span>imgurl4 : </span>
                    <input accept='image/png, image/jpeg, image/gif' name='imgchoice4' onchange = getPath('imgchoice4','imgg4') type='file' id='imgchoice4' style='width:90px;'/>
                    <label id='imgg4' for='imgchoice4'>Select a image:</label>
                    <input style='margin-left:20px;' onclick=noimgcheck('noimg4','imgchoice4') type='checkbox' id='noimg4' value='imgurl4' name='checked[]'>
                    <label for='noimg4'>Remove the image</label>
                    </div>
                   
                    <button name='confirmedit' class='btn-site btn-editconfirm'>Confirm</button>
                    </form>
                   
                </div>
               ";

            }else{
                moveto("?page=Apanel");
            }
            
         
        
        

?>