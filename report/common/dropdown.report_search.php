<?php
    include_once "../../include/class/php_header.class.php";
    include_once "../../include/class/dropdown.class.php";
    include_once "../../include/class/db/db.php";
    include_once "../../include/class/util/strUtil.class.php";
    include_once "../../include/class/model/prd_tier3.class.php"; 
     include_once "../../include/class/model/status.class.php";
     include_once "../../include/class/model/report.class.php";
    
    php_header::text_html_utf8();

    $comp_id = $_GET["comp_id"];
    
    if (strUtil::isNotEmpty($comp_id)){
//        $dd_status = dropdown::loadStatus($db, "status_id", "name=\"status_id\" style=\"width: 100%;\"");
//        $dd_status_l = dropdown::loadStatus($db, "status_id_l", "name=\"status_id_l\" style=\"width: 100%;\"");
        
        echo $dd_cus_zone = dropdown::loadCusZone($db, "customer_zone_id", $comp_id, "", "", "");
        echo $dd_cus_zone_l = dropdown::loadCusZone($db, "customer_zone_id_l", $comp_id, "", "", "");
//        $dd_cus_zone_l = dropdown::loadCusZone($db, "customer_zone_id_l", $comp_id, "", "", "");
//        
//        $dd_prd_tier3 = dropdown::loadPrd_tier3_report($db, "prd_tier_id3", "name=\"cas_prd_tier_id3\" style=\"width: 100%;\"","","","",$comp_id);
//        $dd_prd_tier3_l = dropdown::loadPrd_tier3_report($db, "prd_tier_id3_l", "name=\"cas_prd_tier_id3_l\" style=\"width: 100%;\"","","","",$comp_id);
        
//        echo body_includes($dd_status,$dd_status_l,$dd_cus_zone,$dd_cus_zone_l,$dd_prd_tier3,$dd_prd_tier3_l);
        
    }
    
    
    function body_includes($dd_status,$dd_status_l,$dd_cus_zone,$dd_cus_zone_l,$dd_prd_tier3,$dd_prd_tier3_l){
        $body = "
            <div id='report-ajax' name='report-ajax'>
            <tr>
                <td></td>
                <th align=''left'>Status/สถานะ</th>
                <td align='left'>$dd_status</td>
                <td align='center'>To</td>
                <td>$dd_status_l</td>
                <td></td>
            </tr>
            <tr>
                <td></td>
                <th align='left'>Production Class 3</th>
                <td align='left'>$dd_prd_tier3</td>
                <td align='center'>To</td>
                <td>$dd_prd_tier3_l</td>
                <td></td>
            </tr>
            <tr>
                <td></td>
                <th align='left'>Customer Area/เขต</th>
                <td align='left'>$dd_cus_zone</td>
                <td align='center'>To</td>
                <td>$dd_cus_zone_l</td>
                <td></td>
            </tr>
            </div>";
        
        return $body;
    }
    
        
    
/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */
?>
