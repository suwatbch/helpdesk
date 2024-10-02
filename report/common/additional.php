<?php
include_once '../../include/config.inc.php';
include_once "../../include/class/user_session.class.php";


?>
<link type="text/css" rel="stylesheet" href="../../include/css/report.css"/>
<!--<link type="text/css" rel="stylesheet" href="../../include/css/report_print.css" media="print"/>-->
<script type="text/javascript" src="../../dialog/dialog.ui.js"></script>
<script type="text/javascript">
 $(document).ready(function () {	
  
});
        
function dialog_onSelected(lookuptype, obj){
        if (obj != null){
            if (lookuptype == "employee"){
                $("#employee_id").val(obj.employee_id);                
                $("#employee_name").val(obj.employee_name);
                

            }
          } 
}
 
 

 
 
</script>


<label id="message" name="message"></label>
<input type="hidden" id="mode" name="mode" />
<input type="hidden" id="report_id" name="report_id" value="<?=$report_id;?>" />
<input type="hidden" id="response_id" name="response_id" value="<?=$response_id;?>" />
<input type="hidden" id="user_id" name="user_id" value="<?=user_session::get_user_id();?>" />



<table width="60%" cellpadding="0" cellspacing="5" id="savearea" name="savearea">
    
             <?
                if (user_session::get_edit_rpt_per() == 'Y' && user_session::get_user_id() == $response_id && $final != 'Y'){
                    ?>
    <tr>
        <td align="left" style="width: 350px;">
            <span lookuptype="employee" name="employee" id="employee" style="width: 300px;" title="Employee"  
                  dialogWidth="627" dialogHeight="400" param="edtreport=Y" />

        </td>
         <td align="left" style="width: 80px;">
            <div align="center" id="send" name="send" >Send</div>&nbsp;&nbsp;&nbsp;
         </td>
                     <?   
                        
                }elseif ($chk_dup_data == 0 && $report_id == 0 && user_session::get_edit_rpt_per() == 'Y' ){
                    ?>
                        <tr>
        <td align="left" style="width: 350px;">
            <span lookuptype="employee" name="employee" id="employee" style="width: 300px;" title="Employee"  
                  dialogWidth="627" dialogHeight="400" allowNone="true" />

        </td>
         <td align="left" style="width: 80px;">
            <div align="center" id="send" name="send" >Send</div>&nbsp;&nbsp;&nbsp;
        </td>
                     <? 
                }
                        
                        
                        
             
             ?>
        
        <td align="left" style="width: 120px;">
            <?
                if (user_session::get_appv_rpt_per() == 'Y' && user_session::get_user_id() == $response_id && $final != 'Y'){
                    ?>
                        <div align="center" id="final" name="final" value="Y" >Approve Report</div>
                        
                        <?
                }elseif ($chk_dup_data == 0 && $report_id == 0 && user_session::get_appv_rpt_per() == 'Y' ){
                    ?>
                        <div align="center" id="final" name="final" value="Y" >Approve Report</div>
                     <? 
                }
             
             ?>
            
            
        </td>
        <td align="left" style="width: 300px;">
            <div id="ajax-panel" name="ajax-panel"></div>
            
        </td>
     </tr>
</table>


<br><br>
<div name="additional">
    <span><b><? echo $subject_add;?></b></span><br><br><br>
    <!--=========================== COMMENT 1 ==============================-->
    <!--====================================================================-->
    <div class="comment_subject" style="width: 99%">ด้านพัฒนาบุคคลากร CBS</div><br>
    <table class="tb_additional" width="100%">
        <tr>
            <th width="5%">ลำดับ</th>
            <th width="35%">ระบบงานที่ควรพัฒนาบุคคลากร</th>
            <th width="15%">% สถิติการแจ้ง SPIES ทั้งหมด</th>
            <th width="30%">เขตการไฟฟ้าที่ควรเข้ารับการพัฒนาบุคคลากร</th>
            <th width="15%">% สถิติการแจ้ง SPIES เทียบกับเขตอื่นๆ</th>
        </tr>
        <? if ($report_id == 0 && user_session::get_edit_rpt_per() == 'Y' ) {
            $name = array();
            $val = array();
            foreach ($ad1_pea_area_pc as $key => $row) {
                $val[$key] = $row['val'];
            }

            array_multisort($val, SORT_DESC, $ad1_pea_area_pc);
            
            $text4 = "";
            $text5 = "";
            foreach ($ad1_pea_area_pc as $value) {
                $text4 .= $value["name"]. "\n";
                $text5 .= $value["val"]. "%\n";
            }
            
            ?>
                
          <tr>
            <td><textarea id="txt_detail1" style="width: 100%; height: 200px; border: none; text-align: center;">1</textarea></td>
            <td><textarea id="txt_detail2" style="width: 100%; height: 200px; border: none;" ><?=$ad1_max_howto["name"];?></textarea></td>
            <td><textarea id="txt_detail3" style="width: 100%; height: 200px; border: none; text-align: center;"><?=$ad1_max_howto["val"]."%";?></textarea></td>
            <td><textarea id="txt_detail4" style="width: 100%; height: 200px; border: none;"><?=$text4;?></textarea></td>
            <td><textarea id="txt_detail5" style="width: 100%; height: 200px; border: none; text-align: center;"><?=$text5;?></textarea></td>
        </tr>         
                <?
            }else {
                ?>
         <tr>
            <td><textarea id="txt_detail1" style="width: 100%; height: 200px; border: none; text-align: center;"><?=$additional_text["text1"];?></textarea></td>
            <td><textarea id="txt_detail2" style="width: 100%; height: 200px; border: none;" ><?=$additional_text["text2"];?></textarea></td>
            <td><textarea id="txt_detail3" style="width: 100%; height: 200px; border: none; text-align: center;"><?=$additional_text["text3"];?></textarea></td>
            <td><textarea id="txt_detail4" style="width: 100%; height: 200px; border: none;"><?=$additional_text["text4"];?></textarea></td>
            <td><textarea id="txt_detail5" style="width: 100%; height: 200px; border: none; text-align: center;"><?=$additional_text["text5"];?></textarea></td>
        </tr>           
                   <?
            }
        ?>
        
    </table>
    <table class="tb_additional" width="100%">
        <tr>
            <td width="100%" style="border: none;"><b>ข้อเสนอแนะ</b></td>
        </tr>
        <tr>
            <td style="width: auto; height: auto; border: none;">
                <textarea id="txt_detail6"  style="width: 100%; height: 200px; border: none;"><?=$additional_text["text6"];?></textarea>
            </td>
        </tr>
    </table>
    
    
    
    
    <!--=========================== COMMENT 1 : BPM ==============================-->
    <!--==========================================================================-->
    <div style="page-break-before: always;"><br><br>
    <div class="comment_subject" style="width: 99%; background-color: #F36C00;">ด้านพัฒนาบุคคลากร BPM</div><br>
    <table class="tb_additional" width="100%">
        <tr>
            <th width="5%">ลำดับ</th>
            <th width="35%">ระบบงานที่ควรพัฒนาบุคคลากร</th>
            <th width="15%">% สถิติการแจ้ง SPIES ทั้งหมด</th>
            <th width="30%">เขตการไฟฟ้าที่ควรเข้ารับการพัฒนาบุคคลากร</th>
            <th width="15%">% สถิติการแจ้ง SPIES เทียบกับเขตอื่นๆ</th>
        </tr>
        <? if ($report_id == 0 && user_session::get_edit_rpt_per() == 'Y' ) {
            $name = array();
            $val = array();
            foreach ($BPM_ad1_pea_area_pc as $key => $row) {
                $val[$key] = $row['val'];
            }

            array_multisort($val, SORT_DESC, $BPM_ad1_pea_area_pc);
            
            $BPM_text4 = "";
            $BPM_text5 = "";
            foreach ($BPM_ad1_pea_area_pc as $value) {
                $BPM_text4 .= $value["name"]. "\n";
                $BPM_text5 .= $value["val"]. "%\n";
            }
            
            ?>
                
          <tr>
            <td><textarea id="txt_detail1_BPM" style="width: 100%; height: 200px; border: none; text-align: center;">1</textarea></td>
            <td><textarea id="txt_detail2_BPM" style="width: 100%; height: 200px; border: none;" ><?=$BPM_ad1_max_howto["name"];?></textarea></td>
            <td><textarea id="txt_detail3_BPM" style="width: 100%; height: 200px; border: none; text-align: center;"><?=$BPM_ad1_max_howto["val"]."%";?></textarea></td>
            <td><textarea id="txt_detail4_BPM" style="width: 100%; height: 200px; border: none;"><?=$BPM_text4;?></textarea></td>
            <td><textarea id="txt_detail5_BPM" style="width: 100%; height: 200px; border: none; text-align: center;"><?=$BPM_text5;?></textarea></td>
        </tr>         
                <?
            }else {
                ?>
         <tr>
            <td><textarea id="txt_detail1_BPM" style="width: 100%; height: 200px; border: none; text-align: center;"><?=$additional_text["BPM_text1"];?></textarea></td>
            <td><textarea id="txt_detail2_BPM" style="width: 100%; height: 200px; border: none;" ><?=$additional_text["BPM_text2"];?></textarea></td>
            <td><textarea id="txt_detail3_BPM" style="width: 100%; height: 200px; border: none; text-align: center;"><?=$additional_text["BPM_text3"];?></textarea></td>
            <td><textarea id="txt_detail4_BPM" style="width: 100%; height: 200px; border: none;"><?=$additional_text["BPM_text4"];?></textarea></td>
            <td><textarea id="txt_detail5_BPM" style="width: 100%; height: 200px; border: none; text-align: center;"><?=$additional_text["BPM_text5"];?></textarea></td>
        </tr>           
                   <?
            }
        ?>
        
    </table>
    <table class="tb_additional" width="100%">
        <tr>
            <td width="100%" style="border: none;"><b>ข้อเสนอแนะ</b></td>
        </tr>
        <tr>
            <td style="width: auto; height: auto; border: none;">
                <textarea id="txt_detail6_BPM"  style="width: 100%; height: 200px; border: none;"><?=$additional_text["BPM_text6"];?></textarea>
            </td>
        </tr>
    </table>
    
    
    
    <!--=========================== COMMENT 2 ============================ -->
    <!--================================================================== -->
    <div style="page-break-before: always;"><br><br>
    <div class="comment_subject" style="width: 99%;">ด้านการปรับปรุง ป้องกันระบบงาน IT และกระบวนการปฎิบัติงาน CBS</div><br>
    <div style="width: 100%; height: 500px;">
        <div style="float: left; width: 25%; height: auto;">
            <table class="tb_additional" style="width: 100%;">
                <tr>
                    <th width="22%">ลำดับ</th>
                    <th width="78%">ระบบงาน IT ที่ควรปรับปรุงป้องกัน</th>
                </tr>
     <? if ($report_id == 0 && user_session::get_edit_rpt_per() == 'Y' ) { 
         $number = "";
         $text8 = "";
         if (strUtil::isNotEmpty($ad2_max_inc["name"])){
             $number = "1";
             $text8 = $ad2_max_inc["name"];
         }
         ?>
                <tr>
                    <td><textarea id="txt_detail7"  style="width: 100%; height: 430px; border: none; text-align: center;"><?=$number;?></textarea></td>
                    <td><textarea id="txt_detail8" style="width: 100%; height: 430px; border: none;"><?=$text8;?></textarea></td>
                </tr> 
                <?
            }else {
                ?>
                <tr>
                    <td><textarea id="txt_detail7"  style="width: 100%; height: 430px; border: none; text-align: center;"><?=$additional_text["text7"];?></textarea></td>
                    <td><textarea id="txt_detail8" style="width: 100%; height: 430px; border: none;"><?=$additional_text["text8"];?></textarea></td>
                </tr>                
                 <?
            }
        ?>
                
            </table>
        </div>
        <div style="float: right; width: 75%; height: auto;">
            <div style="float: top; width: 100%; height: auto;">
                <table class="tb_additional" style="width: 100%;">
                    <tr>
                        <th width="40%">%สถิติการแจ้ง SPIES ทั้งหมด</th>
                        <th width="60%">ข้อเสนอแนะ</th>
                    </tr>
                    <tr>
                         <? if ($report_id == 0 && user_session::get_edit_rpt_per() == 'Y' ) { 
                             $text9 = "";
                             if (strUtil::isNotEmpty($ad2_max_inc["name"])){
                                 $text9 = $ad2_max_inc["val"]."%";
                             }
         ?>
                        
                        <td><textarea id="txt_detail9" style="width: 100%; height: 200px; border: none; text-align: center;"><?=$text9;?></textarea></td>
                         
                            <?
                        }else {
                        ?>
                        
                        <td><textarea id="txt_detail9" style="width: 100%; height: 200px; border: none; text-align: center;"><?=$additional_text["text9"];?></textarea></td>
                        <?
                        }
                    ?>
                        <td><textarea id="txt_detail10" style="width: 100%; height: 200px; border: none;"><?=$additional_text["text10"];?></textarea></td>
                    </tr>
                </table>
            </div>
            <div style="float: bottom; width: 100%; height: auto;">
                <table class="tb_additional" style="width: 100%;">
                    <tr>
                        <th width="30%">เขตการไฟฟ้าที่ควรปรับปรุงการปฏิบัติงาน</th>
                        <th width="20%">%สถิติการแจ้ง SPIES ทั้งหมด</th>
                        <th width="50%">ข้อเสนอแนะ</th>
                    </tr>
                    <tr>
                        <? if ($report_id == 0 && user_session::get_edit_rpt_per() == 'Y' ) {
                            $text11 = "";
                            $text12 = "";
                             if (strUtil::isNotEmpty($ad2_pea_area_pc["name"])){
                                 $text11 = $ad2_pea_area_pc["name"];
                                 $text12 = $ad2_pea_area_pc["val"]."%";
                             }
                            
                            ?>
                        <td><textarea id="txt_detail11" style="width: 100%; height: 200px; border: none;"><?=$text11;?></textarea></td>
                        <td><textarea id="txt_detail12" style="width: 100%; height: 200px; border: none; text-align: center;"><?=$text12;?></textarea></td>
                        <?
                        }else {
                        ?>
                        <td><textarea id="txt_detail11" style="width: 100%; height: 200px; border: none;"><?=$additional_text["text11"];?></textarea></td>
                        <td><textarea id="txt_detail12" style="width: 100%; height: 200px; border: none; text-align: center;"><?=$additional_text["text12"];?></textarea></td>
                        <?
                        }
                        ?>
                        <td><textarea id="txt_detail13" style="width: 100%; height: 200px; border: none;"><?=$additional_text["text13"];?></textarea></td>
                    </tr>
                </table>
            </div>
        </div>
    </div></div>
    
    
    <!--=========================== COMMENT 2 :BPM ============================ -->
    <!--================================================================== -->
    <div style="page-break-before: always;"><br><br>
    <div class="comment_subject" style="width: 99%; background-color: #F36C00;">ด้านการปรับปรุง ป้องกันระบบงาน IT และกระบวนการปฎิบัติงาน BPM</div><br>
    <div style="width: 100%; height: 500px;">
        <div style="float: left; width: 25%; height: auto;">
            <table class="tb_additional" style="width: 100%;">
                <tr>
                    <th width="22%">ลำดับ</th>
                    <th width="78%">ระบบงาน IT ที่ควรปรับปรุงป้องกัน</th>
                </tr>
     <? if ($report_id == 0 && user_session::get_edit_rpt_per() == 'Y' ) { 
         $number = "";
         $BPM_text8 = "";
         if (strUtil::isNotEmpty($BPM_ad2_max_inc["name"])){
             $number = "1";
             $BPM_text8 = $BPM_ad2_max_inc["name"];
         }
         ?>
                <tr>
                    <td><textarea id="txt_detail7_BPM"  style="width: 100%; height: 430px; border: none; text-align: center;"><?=$number;?></textarea></td>
                    <td><textarea id="txt_detail8_BPM" style="width: 100%; height: 430px; border: none;"><?=$BPM_text8;?></textarea></td>
                </tr> 
                <?
            }else {
                ?>
                <tr>
                    <td><textarea id="txt_detail7_BPM"  style="width: 100%; height: 430px; border: none; text-align: center;"><?=$additional_text["BPM_text7"];?></textarea></td>
                    <td><textarea id="txt_detail8_BPM" style="width: 100%; height: 430px; border: none;"><?=$additional_text["BPM_text8"];?></textarea></td>
                </tr>                
                 <?
            }
        ?>
                
            </table>
        </div>
        <div style="float: right; width: 75%; height: auto;">
            <div style="float: top; width: 100%; height: auto;">
                <table class="tb_additional" style="width: 100%;">
                    <tr>
                        <th width="40%">%สถิติการแจ้ง SPIES ทั้งหมด</th>
                        <th width="60%">ข้อเสนอแนะ</th>
                    </tr>
                    <tr>
                         <? if ($report_id == 0 && user_session::get_edit_rpt_per() == 'Y' ) { 
                             $BPM_text9 = "";
                             if (strUtil::isNotEmpty($BPM_ad2_max_inc["name"])){
                                 $BPM_text9 = $BPM_ad2_max_inc["val"]."%";
                             }
         ?>
                        
                        <td><textarea id="txt_detail9_BPM" style="width: 100%; height: 200px; border: none; text-align: center;"><?=$BPM_text9;?></textarea></td>
                         
                            <?
                        }else {
                        ?>
                        
                        <td><textarea id="txt_detail9_BPM" style="width: 100%; height: 200px; border: none; text-align: center;"><?=$additional_text["BPM_text9"];?></textarea></td>
                        <?
                        }
                    ?>
                        <td><textarea id="txt_detail10_BPM" style="width: 100%; height: 200px; border: none;"><?=$additional_text["BPM_text10"];?></textarea></td>
                    </tr>
                </table>
            </div>
            <div style="float: bottom; width: 100%; height: auto;">
                <table class="tb_additional" style="width: 100%;">
                    <tr>
                        <th width="30%">เขตการไฟฟ้าที่ควรปรับปรุงการปฏิบัติงาน</th>
                        <th width="20%">%สถิติการแจ้ง SPIES ทั้งหมด</th>
                        <th width="50%">ข้อเสนอแนะ</th>
                    </tr>
                    <tr>
                        <? if ($report_id == 0 && user_session::get_edit_rpt_per() == 'Y' ) {
                            $BPM_text11 = "";
                            $BPM_text12 = "";
                             if (strUtil::isNotEmpty($BPM_ad2_pea_area_pc["name"])){
                                 $BPM_text11 = $BPM_ad2_pea_area_pc["name"];
                                 $BPM_text12 = $BPM_ad2_pea_area_pc["val"]."%";
                             }
                            
                            ?>
                        <td><textarea id="txt_detail11_BPM" style="width: 100%; height: 200px; border: none;"><?=$BPM_text11;?></textarea></td>
                        <td><textarea id="txt_detail12_BPM" style="width: 100%; height: 200px; border: none; text-align: center;"><?=$BPM_text12;?></textarea></td>
                        <?
                        }else {
                        ?>
                        <td><textarea id="txt_detail11_BPM" style="width: 100%; height: 200px; border: none;"><?=$additional_text["BPM_text11"];?></textarea></td>
                        <td><textarea id="txt_detail12_BPM" style="width: 100%; height: 200px; border: none; text-align: center;"><?=$additional_text["BPM_text12"];?></textarea></td>
                        <?
                        }
                        ?>
                        <td><textarea id="txt_detail13_BPM" style="width: 100%; height: 200px; border: none;"><?=$additional_text["BPM_text13"];?></textarea></td>
                    </tr>
                </table>
            </div>
        </div>
    </div></div>
    
    
    
    <!--======================= COMMENT 3 =============================-->
    <div style="page-break-before: always;"><br><br>
    <div class="comment_subject" style="width: 99%;">ประเด็นติดตามจากเดือนก่อนหน้า CBS</div><br>
    <table id="tb_additional_3" class="tb_additional"  width="100%">
        <tr>
            <th width="5%">ลำดับ</th>
            <th width="25%">ประเด็นที่ติดตาม</th>
            <th width="20%">เขตการไฟฟ้า</th>
            <th width="25%">แนวทางการแก้ไข</th>
            <th width="25%">ผลการปรับปรุง</th>
        </tr>
        <tr>
            <td><textarea id="txt_detail14" style="width: 100%; height: 400px; border: none; text-align: center;"><?=$additional_text["text14"];?></textarea></td>
            <td><textarea id="txt_detail15" style="width: 100%; height: 400px; border: none;"><?=$additional_text["text15"];?></textarea></td>
            <td><textarea id="txt_detail16" style="width: 100%; height: 400px; border: none;"><?=$additional_text["text16"];?></textarea></td>
            <td><textarea id="txt_detail17" style="width: 100%; height: 400px; border: none;"><?=$additional_text["text17"];?></textarea></td>
            <td><textarea id="txt_detail18" style="width: 100%; height: 400px; border: none;"><?=$additional_text["text18"];?></textarea></td>
            
        </tr>
    </table></div>  
    
    
    <!--======================= COMMENT 3 : BPM =============================-->
    <div style="page-break-before: always;"><br><br>
    <div class="comment_subject" style="width: 99%; background-color: #F36C00;">ประเด็นติดตามจากเดือนก่อนหน้า BPM</div><br>
    <table id="tb_additional_3" class="tb_additional"  width="100%">
        <tr>
            <th width="5%">ลำดับ</th>
            <th width="25%">ประเด็นที่ติดตาม</th>
            <th width="20%">เขตการไฟฟ้า</th>
            <th width="25%">แนวทางการแก้ไข</th>
            <th width="25%">ผลการปรับปรุง</th>
        </tr>
        <tr>
            <td><textarea id="txt_detail14_BPM" style="width: 100%; height: 400px; border: none; text-align: center;"><?=$additional_text["BPM_text14"];?></textarea></td>
            <td><textarea id="txt_detail15_BPM" style="width: 100%; height: 400px; border: none;"><?=$additional_text["BPM_text15"];?></textarea></td>
            <td><textarea id="txt_detail16_BPM" style="width: 100%; height: 400px; border: none;"><?=$additional_text["BPM_text16"];?></textarea></td>
            <td><textarea id="txt_detail17_BPM" style="width: 100%; height: 400px; border: none;"><?=$additional_text["BPM_text17"];?></textarea></td>
            <td><textarea id="txt_detail18_BPM" style="width: 100%; height: 400px; border: none;"><?=$additional_text["BPM_text18"];?></textarea></td>
            
        </tr>
    </table></div>  
</div><br><br>




<!--</form>-->