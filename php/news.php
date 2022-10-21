<?php 
    #-----Setting--------#
    include("_Setting.php");
    #--------------------#
    if(isset($_GET['success']) && isset($_SESSION['StatusMSG'])){
      if($_GET['success'] == 1){
          unset($_SESSION['StatusMSG']);
          SwalfireApanel2("<span style='color:#fff;'>You have been Registered. You must Activate your Account from the Activation Link sent to your email</span>","#111B2F","black");
      }
      if($_GET['success'] == 2){
         unset($_SESSION['StatusMSG']);
         SwalfireApanel2("<span style='color:#fff;'>We have sent the password to your email</span>","#111B2F","black");
     }
     if($_GET['success'] == 3){
      unset($_SESSION['StatusMSG']);
      SwalfireApanel2("<span style='color:#fff;'>Your Account has been activited</span>","#111B2F","black");
      }
      
  }
   if(isset($_GET['failed']) && isset($_SESSION['StatusMSG'])){
      if($_GET['failed'] == 1){
         unset($_SESSION['StatusMSG']);
         SwalfireApanel2("<span style='color:#fff;'>Error while activing your account, Please Try to contact with the administrator</span>","#111B2F","black");
      }
      if($_GET['failed'] == 2){
         unset($_SESSION['StatusMSG']);
         SwalfireApanel2("<span style='color:#fff;'>Error while sending Activition code, Please Try to contact with the administrator</span>","#111B2F","black");
      }
      if($_GET['failed'] == 3){
         unset($_SESSION['StatusMSG']);
         SwalfireApanel2("<span style='color:#fff;'>Your account not found</span>","#111B2F","black");
      }
      if($_GET['failed'] == 4){
         unset($_SESSION['StatusMSG']);
         SwalfireApanel2("<span style='color:#fff;'>This link not available</span>","#111B2F","black");
      }
   }
    #--------------------#
    $query = sqlsrv_query($dbcn, "Select * from $dbname3.dbo.news order by ID desc",array(),array("scrollable" => SQLSRV_CURSOR_KEYSET));
    echo"<span style=' margin-left:5px; color:#fff !important; font-size:40px; '>GAME UPDATES</span>";
    
    if(sqlsrv_num_rows($query) < 1){
        echo "
        <div class='news-div'> 
        <h1 style='text-align:center;' class= 'title-news'> No Updates</h1>
        <div class='news-content'>
        
        <p style='font-size:30px;'> <b>The server has no updates.</b> </p>


        
        </div>
        </div>
        ";
    }else{

    
    while ($queryres = SQLSRV_FETCH_ARRAY($query)){
        $clear = $queryres['Article'];
        $newstr = str_replace(".",".<br>",$clear);
        $newstr = str_replace("?","?<br> -",$newstr);
        $target = array("\r\n","\n","\r");
        $newstr = str_replace($target,"<br>",$newstr);
        echo "  
        <div class='news-div'>
        <h1 class= 'title-news'>".$queryres['Subject']."</h1>
         <p>[Posted by <b>".$queryres['author']."</b> at <b>".$queryres['postdate']->format('d.m.Y')."</b>].</p>
         <div class='news-content'>";

        
         for($i = 1; $i < 5; $i++)
         {
         if($queryres["imgurl$i"] != null){
             if($i == 1){
                echo"  <div class='img-content'>";
             }
             if($i==2 && $queryres["imgurl1"] == null ){
                echo"  <div class='img-content'>";
             }
             if($i==3 && $queryres["imgurl2"] == null ){
                echo"  <div class='img-content'>";
             }
             if($i==4 && $queryres["imgurl3"] == null ){
                echo"  <div class='img-content'>";
             }
             echo
             "
            <img class = 'news-imgsize' src=".$queryres["imgurl$i"].">
            ";
            
         }
         if($i == 4 && ($queryres["imgurl1"] != null || $queryres["imgurl2"] != null || $queryres["imgurl3"] != null || $queryres["imgurl4"] != null ) ){
            echo"  </div>";
         }
        }
         echo "
            <p class='news-text'>$newstr</p>
         </div>
        </div>
        
        
        ";
    }
}
?>