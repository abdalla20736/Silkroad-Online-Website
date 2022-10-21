<head>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@10"></script>
</head>
<?php
    echo"<span style=' margin-left:5px; color:#fff !important; font-size:40px; '>WEB SHOP</span>";
    #--------include-settings-------#
    include("./php/_Setting.php");
    #-------------------------------#
    #-----select the current page---#
    if(isset($_GET['pages'])){
        $pages = $_GET['pages'];
    }else{
        $pages = 1;
    }
    #-------------------------------#
    
    
    if(isset($_SESSION['loggedin'])){
    
    
    #-----------define-elements quntity& get last element----------#
    $perpage = 8;
    $getlastelement = ($pages-1)* $perpage;
    #--------------------------------------------------------------#
    #-----------Organize the elements queries----------------------#
    $GetShop = SQLSRV_QUERY($dbcn,"Select * from $dbname3.dbo._Webshop",array(),array('scrollable' => SQLSRV_CURSOR_KEYSET)); 
    $Checkservices = SQLSRV_QUERY($dbcn,"select * from $dbname3.dbo._Webshop where [Service] = 1",array(),array('scrollable' => SQLSRV_CURSOR_KEYSET));
    $limitshop = SQLSRV_QUERY($dbcn,"Select top 8 * FROM (SELECT ROW_NUMBER() OVER(ORDER BY ID) AS Quntity, * FROM _Webshop) AS Pages where Quntity > $getlastelement",array(),array('scrollable' => SQLSRV_CURSOR_KEYSET)); 
    #-----------divide the elements into the page------#
    $Rowsquntity = SQLSRV_NUM_ROWS($GetShop);
    $pagesquntity = ceil($Rowsquntity/$perpage);
    #--------------------------------------------------#
    
    #-----------------check if the table has items or if the services are 0 ------------------#
    if(sqlsrv_num_rows($GetShop) > 0 && sqlsrv_num_rows($Checkservices) > 0){
    #-----------------print all items into the web shop --------------------------------------#
        echo"<div class='borders-web-mall'>";
    while($GettingShop = SQLSRV_FETCH_ARRAY($limitshop)){
    #-----------------check if the item has been found inside the game items table------------#
        $Checktheitem = SQLSRV_QUERY($dbcn,"SELECT ID FROM _Items where ID in (SELECT ItemID FROM _Webshop where ID = ".$GettingShop['ID'].") and ID <> 0",array(),array('scrollable' => SQLSRV_CURSOR_KEYSET));
        if(SQLSRV_NUM_ROWS($Checktheitem) > 0 ){
            if($GettingShop['Service'] != 0 && !empty($GettingShop['Nitem']) && !empty($GettingShop['img']) && $GettingShop['ItemID'] != 0){
                    $HID = $GettingShop['ID']+2548941894;
                    
                echo "
                
                        <div class='web-mall-div'>
                        <form method='post' action='?page=purchasing&id= ".$HID."'>
                            
                            <img class='webmall-icons' src=".$GettingShop['img'].">
                            <p style='left:-5px; font-size:13px; position:relative;'><img class='icon'  src='./img/ico/dollar.svg'> ".$GettingShop['Price']." Silk</p>
                            <p>".$GettingShop['Nitem']."</p>
                            
                            <button class ='fix-mallbutton' name='purchase' id='form'>
                            </form>
                        </div>
            
                    ";

            }
        }
    }
#--------------------------------------------------------------------------------------------------------------------#
                         echo"<div class='numweb'>";
                    if($pages != 1){
                        echo"<a class='numwebmall' href='?page=webmall&pages=1'>First</a>";
                        $pervious = $pages - 1;
                        echo"<a class='numwebmall' href='?page=webmall&pages=$pervious'>Pervious</a>";
                    }
                    if($pages != 1 && $pages != $pagesquntity)
                    {
                            echo" <span class='numwebmall'> | </span> ";
                    }
                    if($pages != $pagesquntity){
                        
                        $next = $pages + 1;
                        echo"<a class='numwebmall' href='?page=webmall&pages=$next'>Next</a>";
                        echo"<a class='numwebmall' href='?page=webmall&pages=$pagesquntity' >Last</a>";
                    }
                        echo"</div>";
                    echo " </div>";
           
        }else{
            echo " <p class='exist-msg'> <b>The shop doesn't have any item until now.</b></p>";
            
        }
}else{
        #-------------------if the person is guest, it ask him to login ---------------------------------#
        echo "<div class='gu-ch-error-div'><span class='gu-ch-error'> <b>You must login in order to buy an item from the shop.</b></span></div>";
        sqlsrv_close( $dbcn); 

}
   #----------------------------------purchase function by pressing Purchase button -------------------------#
    if(isset($_POST['purchase'])){
        if(isset($_SESSION['loggedin'])){
            #---------------------------------get the user && the item information---------------------------------------#
            $USID = sqlsrv_query($dbcn,"select * from $dbname3.dbo.SK_USER WHERE Username = '".$_SESSION['User']."'");
            $GETUSID = SQLSRV_FETCH_ARRAY($USID);
            $RID =  $_GET['id']-2548941894;
            $SRID = $_GET['id'];
            $SRUS = $GETUSID['ID'] + 2548941894;
            #-------------------------------------------------------------------------------------------------------------#

            
           #-------------------------------------- Sweetalert2 to confirm purchase process-----------------------#
                    ?>
                    
                        <script type ="text/javascript">
                         var iden = <?php echo $SRID; ?>;
                         var Backus = <?php echo $SRUS;?>;
                         
                         
                         Swal.fire({
                            
                            title: '<span style="color:#fff;">Do you want to Buy the item?</span>',
                            showCancelButton: true,
                            confirmButtonText: `Yes, Buy it!`,
                            background: '#111B2F',
                            confirmButtonColor:'black',
                            cancelButtonColor:'#20659e'
                            }).then((result) => {
                            if (result.isConfirmed) {
                                <?php 
                                $GETID = $SRID + $SRUS;
                                $LINK = "?page=completepurchasing&id=".$SRID."&us".$SRUS."";
                                // insert this line to allow the purchase process only through the purchase button
                                sqlsrv_query($dbcn,"INSERT INTO _Webshop_links(ID,Link,UserID,[Availability],[Time])VALUES($GETID,'$LINK',$SRUS,1,DATEADD(SECOND, 0, GETDATE()))");
                                
                                ?>
                                //redirect to a page to compelete the purchase process
                                window.location.href= "?page=completepurchasing&id="+iden+"&us="+Backus+"";
                                
                               
                                
                            } else if (result.isDenied) {
                                    
                               sqlsrv_query($dbcn,"D");
                               

                            }
                            })

                                
                        </script>
                       
                 
                    <?php
               
               
        }
     } 
     

    
    #---Complete payment&& Get the item-----#
    if(isset($_SESSION['loggedin'])){
     if($_GET['page'] == 'completepurchasing'){ 
        
        $GETID = $_GET['id']+$_GET['us'];
        $GET2 = $_GET['us'];
        $Link = "?page=completepurchasing&id= ".$_GET['id']."&us".$_GET['us']."";
        usleep( 250000 );
        $checklink = sqlsrv_query($dbcn,"Select * FROM $dbname3.dbo._Webshop_links where ID = ".$GETID." and UserID = ".$_GET['us']." and [Availability] = 1 and [Time] <= GETDATE()",array(),array('scrollable' => SQLSRV_CURSOR_KEYSET));
        
        if(SQLSRV_NUM_ROWS($checklink) > 0){
        
        
        
       
        $RUS = $_GET['us']-2548941894;
        $RID = $_GET['id']-2548941894;
        $Return = 0;
        $params = array( 
        array(&$RUS, SQLSRV_PARAM_IN),
        array(&$RID, SQLSRV_PARAM_IN),
        array(&$Return, SQLSRV_PARAM_OUT)
        );
        
         SQLSRV_QUERY($dbcn,"EXEC $dbname3.dbo.WEBMALL_Purchase @UserID=?,@WebItemID=?,@Return=?",$params);
         sqlsrv_query($dbcn,"DELETE FROM $dbname3.dbo._Webshop_links  where ID = ".$GETID." and UserID = ".$_GET['us']." and [Availability] = 1");
         
        if($Return == -5){
            
            ?>
            
            <script>
            Swal.fire({
                confirmButtonColor: '#000',
                text :'Your inventory is full'
                })
            </script>
            <?php
            echo '<meta http-equiv="refresh" content="2; url=?page=webmall">';
        }elseif($Return == -3){
            ?>
            <script>
            Swal.fire({
                confirmButtonColor: '#000',
                text:'The item which is in the item mall is not available'
            }
                )
            
            </script>
            <?php
            echo '<meta http-equiv="refresh" content="2; url=?page=webmall">';
        }elseif($Return == -4){
            ?>
            <script>
            Swal.fire({
                confirmButtonColor: '#000',
                text:'The User Not found'
            }
                )
            </script>
            <?php
        }elseif($Return == -2){
                ?>
                <script>
                Swal.fire({
                    confirmButtonColor: '#000',
                    text:'You dont have enough silk points to buy this item'
                    
                })
                </script>
                <?php
                echo '<meta http-equiv="refresh" content="2; url=?page=webmall">';
                echo"".$GET22."","".$RID1."";
        }else{
            sqlsrv_query($dbcn,"INSERT INTO dbo._Webshop_log(RUserID,RItemID,Purchasetime)values('$RUS','$RID',GETDATE())");
            ?>
            
            <script>
            Swal.fire({
                confirmButtonColor: '#000',
                text:'Your item has been transfered to your inventory'
                
            });

            </script>
            
                <?php
            echo '<meta http-equiv="refresh" content="2; url=?page=webmall">';
            }
         
        }else{
            
            ?>
                <script>
                Swal.fire({
                confirmButtonColor: '#000',
                text:'Use purchase button to buy.'
                
            });
            </script>
            
            <?php
             echo '<meta http-equiv="refresh" content="2; url=?page=webmall">';
            
        }
        
    }
        
    }else{
        
    }
    
    
   


                 
?>  
