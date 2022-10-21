
<?php 
    #--------Setting--------#
    include("_Setting.php");
    #-----------------------#
    
    $query = sqlsrv_query($dbcn,"select * from $dbname3.dbo.downloads",array(),array('scrollable' => SQLSRV_CURSOR_KEYSET));
    
    echo "<span style='color:#fff !important; font-size:40px; '>DOWNLOAD</span><div class='dw-outside'> <table class='dw-table'> <tr>
    <th class='table-th'></th>
    <th class='table-th'><span>Description</span></th>
    <th class='table-th'><span>Size</span></th>
    <th class='table-th'>Link</th>

    </tr>";
   if(SQLSRV_NUM_ROWS($query) > 0)
    while($queryres = SQLSRV_FETCH_ARRAY($query)){

        echo"
        
        
        
        <tr>
        <td class='table-th'><img class='dw-img' src='./img/dw.svg'></td>
        <td class='table-th td-descrip'><span>".$queryres['Name']."</span></td>
        <td class='table-th'><span>".$queryres['Size']."</span></td>
        <td class='table-th'><a href=".$queryres['Link'].">Download</a></td>

        </tr>
        
        
        
        ";
    }
    else{
        echo"<tr>
        <td class='table-th'><img class='dw-img' src='./img/404.png'></td>
        <td class='table-th'><span>The game has no links</span></td>
        <td class='table-th'><span>None</span></td>
        <td class='table-th'><a >None</a></td>

        </tr>";
    }
    echo"</table></div>";
    echo"
    <span style=' margin-left:5px; color:#fff !important; font-size:40px; '>SYSTEM REQUIREMENTS</span>
    <table class='system-req'>
        <tr>
        
        <th>COMPONENTS</th>
        <th>MINIMUM</th>
        <th>RECOMMENDED</th>
        </tr>
        <tr>
        
        <th>Processor (CPU)</th>
        <th>AMD Athlon™ 64 X2 Dual Core Processor 4600+ 2.4GHz<br>
        Intel® Core™2 Duo Processor T6400 2.0GHz</th>
        <th>AMD Ryzen™ 3 1200 Processor @ 3.1GHz (4 Cores), ~3.4GHz<br>
        Intel® Core™ i5-3470 Processor @ 3.20GHz (4 Cores),~3.2GHz</th>
        </tr>
        <tr>
        <th>Memory (RAM)</th>
        <th>4GB RAM</th>
        <th>8GB RAM</th>
        </tr>
        <tr>
        <th>Video Card</th>
        <th>NVIDIA® GeForce® 9500 GT<br>
        AMD Radeon™ HD 6450<br>
        Intel® HD Graphics 3000</th>
        <th>NVIDIA® GeForce® GT 630<br>
        AMD Radeon™ HD 6570<br>
        Intel® HD Graphics 6000</th>
        </tr>
        <tr>
        <th>Hard Drive Space</th>
        <th>7 GB of free space</th>
        <th>9 GB of free space</th>
        </tr>
        <tr>
        <th>Operating System</th>
        <th>Window® 7 32-bit</th>
        <th>Window® 7/8/10 64-bit</th>
        </tr>
        <tr>
        <th>DirectX©</th>
        <th>DirectX© 9.0c</th>
        <th>DirectX© 11 or better</th>
        </tr>
        <tr>
        <th>Internet Connection</th>
        <th>Cable/DSL</th>
        <th>Cable/DSL or better</th>
        </tr>
    </table>

    ";
?>