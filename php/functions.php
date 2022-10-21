
<?php 
#--------Functions-----------

    function Emsg($msg){
        echo"<script type='text/javascript'>alert('$msg');</script>";
    }
    function Checkpassword($currps){
        if(strlen($currps) < 8 ) { return false;}
        if(strlen($currps) > 32) { return false;}
        if(!ctype_alnum($currps)) { return false;}
        return true;
    }
    function setInterval1($f,$ms){
        $second = (int)$ms/1000;
        while(true){
            $f;
            sleep($second);
        }
    }
    function SwalfireApanel($title, $Backgroundcolor, $confirmbutton){
        ?> <script> 
       
        Swal.fire({
        
            title: "<?php echo $title ?>",
            confirmButtonText: `Ok`,
            background: "<?php echo $Backgroundcolor ?>",
            confirmButtonColor:"<?php echo $confirmbutton ?>"
            
            }).then(function(isConfirm){
                window.location.href="?page=Apanel";
            });
            
            </script><?php
     }
     function SwalfireApanelwithicon($title, $Backgroundcolor, $confirmbutton,$icon){
        ?> <script> 
       
        Swal.fire({
        
            title: "<?php echo $title ?>",
            confirmButtonText: `Ok`,
            background: "<?php echo $Backgroundcolor ?>",
            icon: "<?php echo $icon?>",
            confirmButtonColor:"<?php echo $confirmbutton ?>"
            
            }).then(function(isConfirm){
                window.location.href="?page=Apanel";
            });
            
            </script><?php
     }
     function SwalfireApanel2($title, $Backgroundcolor, $confirmbutton){
        ?> <script> 
       
        Swal.fire({
        
            title: "<?php echo $title ?>",
            confirmButtonText: `Ok`,
            background: "<?php echo $Backgroundcolor ?>",
            confirmButtonColor:"<?php echo $confirmbutton ?>"
            
            });
            
            </script><?php
     }
     function SwalfireApanel3($title, $Backgroundcolor, $confirmbutton){
        ?> <script> 
        window.location.href="?page=Apanel&failed=1";
        Swal.fire({
        
            title: "<?php echo $title ?>",
            confirmButtonText: `Ok`,
            background: "<?php echo $Backgroundcolor ?>",
            confirmButtonColor:"<?php echo $confirmbutton ?>"
            
            })
            
            </script><?php
     }
     function SwalfireApanel4($title, $Backgroundcolor, $confirmbutton,$link){
        ?> <script> 
        Swal.fire({
        
        title: "<?php echo $title ?>",
        confirmButtonText: `Ok`,
        background: "<?php echo $Backgroundcolor ?>",
        confirmButtonColor:"<?php echo $confirmbutton ?>"
        
        }).then(function(isConfirm){
            window.location.href="<?php echo $link?>";
        });

            </script><?php
     }
     function moveto($link){
         $_SESSION['StatusMSG'] = 'YES';
        ?> <script> 
        link = "<?php echo $link; ?>"
        window.location.href=link;
        </script><?php
     }
     function moveto2($link){
       ?> <script> 
       link = "<?php echo $link; ?>"
       window.location.href=link;
       </script><?php
    }
     
     ?>
     
     
   

