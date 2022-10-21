
<?php
echo"<span style=' margin-left:5px; color:#fff !important; font-size:40px; '>Add Subject</span>";
    if(isset($_GET['failed']) && $_GET['failed'] == 5 && isset($_SESSION['itsadmin'])){
        SwalfireApanel2("<span style='color:#fff;'>The text between 1 - 1000 characters</span>","#111B2F","black");
    }
    if(isset($_GET['failed']) && $_GET['failed'] == 6 && isset($_SESSION['itsadmin'])){
        SwalfireApanel2("<span style='color:#fff;'>The Subject name is already used or No subject name has been entered</span>","#111B2F","black");
    }
    if(isset($_SESSION['itsadmin'])){
        unset($_SESSION['itsadmin']);

        echo"
            <div class='editnews-editdiv'>
                 <form enctype='multipart/form-data' method='POST' action='?page=confirmadd'>

                    <span>Subject : </span>
                    <input style='margin-bottom:20px;' name='subjectname' type='text' autocomplete='off'><br>
                    <span>If you want to end the line please put .(dot) or ?</span>
                    <span class='spanart'>Article :</span>
                    <textarea class='Article-text'autocomplete='off' rows='5' cols='30' type='text' rows='1' maxlength='1000' name='Articletext'></textarea>
                    
                    <div class='imgupload-div'>
                    <span>imgurl1 : </span>
                    <input accept='image/png, image/jpeg, image/gif' name='imgchoice1' onchange = getPath('imgchoice1','imgg1') type='file' id='imgchoice1' style='width:90px;'/>
                    <label id='imgg1' for='imgchoice1'>Select a image:</label>
                    </div>

                    <div class='imgupload-div'>
                    <span>imgurl2 : </span>
                    <input accept='image/png, image/jpeg, image/gif' name='imgchoice2' onchange = getPath('imgchoice2','imgg2') type='file' id='imgchoice2' style='width:90px;'/>
                    <label id='imgg2' for='imgchoice2'>Select a image:</label>
                    </div>

                    <div class='imgupload-div'>
                    <span>imgurl3 : </span>
                    <input accept='image/png, image/jpeg, image/gif' name='imgchoice3' onchange = getPath('imgchoice3','imgg3') type='file' id='imgchoice3' style='width:90px;'/>
                    <label id='imgg3' for='imgchoice3'>Select a image:</label>
                    </div>

                    <div class='imgupload-div'>
                    <span>imgurl4 : </span>
                    <input accept='image/png, image/jpeg, image/gif' name='imgchoice4' onchange = getPath('imgchoice4','imgg4') type='file' id='imgchoice4' style='width:90px;'/>
                    <label id='imgg4' for='imgchoice4'>Select a image:</label>
                    </div>
                   
                    <button name='confirmadd' class='btn-site btn-editconfirm'>Confirm</button>
                    </form>
                   
                </div>
               ";      

    }else{
        moveto("?page=Apanel");
    }
?>