<?php

include_once 'criteria_search.action.php';
//$report = 1 : monthly
//$report = 2 : aging
//$report = 3 : outstanding
//echo $ddassign_comp_id = user_session::get_user_company_id();

?>

<style type="text/css">
  .ui-autocomplete { overflow-y: scroll; }
  * html .ui-autocomplete { /* IE max- */height: expression( this.scrollHeight > 200 ? "200px" : "auto" ); }
  .ui-autocomplete { max-height: 200px; }
</style>


<link type="text/css" rel="stylesheet" href="<?=$application_path_include?>/css/cctstyles.css"/>
<script type="text/javascript">
    $(function(){
        $("img#search").click(function(){
			
		
//            if ($("#hd_report").val() == 1){//monthly report
//                var sdate = $("#date_monthly").val();
//                sdate = sdate.split(",")
//                $("#inc_date").val(sdate[0]);
//                $("#l_inc_date").val(sdate[1]);
//                
////                alert($("#inc_date").val());
////                alert($("#l_inc_date").val());
//            }

           if (validate()){
               
                var arr = null;
                var d1 = $("#inc_date").val();
                var d2 = $("#l_inc_date").val();
                var str_report = $("#hd_report").val();
				
                if (d1 == ""){
                    alert("Please select start date");
                    return false;
                } 
                
                if (d2 == ""){
                    alert("Please select end date");
                    return false;
                } 
                
                arr = d1.split("-");
                d1 = arr[2] + "" + arr[1] + "" + arr[0];

                arr = d2.split("-");
                d2 = arr[2] + "" + arr[1] + "" + arr[0];

                if (d2 < d1) {
                    alert("Incident date to is greater than Incident date from.");
                    return false;
                }
                if (str_report == '4') {
	                if($("#status_id").val() > $("#status_id_l").val() && $("#status_id_l").val()!=""){
	                    alert("Status to is greater than Status from ");
	                    return false;
	                }
	                if($("#status_id").val()=="" && $("#status_id_l").val()!=""){
	                    alert("Please select Status from");
	                    return false;
	                }

	                if($("#ident_type_id").val() > $("#ident_type_id_l").val() && $("#ident_type_id_l").val()!= ""){
	                    alert("Incident Type to is greater than Incident Type from ");
	                    return false;
	                }
	                if($("#ident_type_id").val()=="" && $("#ident_type_id_l").val()!=""){
	                    alert("Please select Incident Type from");
	                    return false;
	                }
                }
				
                if (str_report == '3' || str_report == '4') {
	                if($("#customer_zone_id").val() > $("#customer_zone_id_l").val() && $("#customer_zone_id_l").val()!= "" ){
	                    alert("Customer Area to is greater than Customer Area from ");
	                    return false;
	                }
	                if($("#customer_zone_id").val()=="" && $("#customer_zone_id_l").val()!=""){
	                    alert("Please select Customer Area from");
	                    return false;
	                }
                }
                
                if (str_report == '2' || str_report == '3' || str_report == '4'){
                    
	                if($("#prd_tier_id3").val() > $("#prd_tier_id3_l").val() && $("#prd_tier_id3_l").val()!=""){
	                    alert("Production Class 3 to is greater than Production Class 3 from ");
	                    return false;
	                }
	                if($("#prd_tier_id3").val()=="" && $("#prd_tier_id3_l").val()!=""){
	                    alert("Please select Production Class 3 from");
	                    return false;
	                }
                }
                
                if (str_report == '4') {

                        if($("#reference_from").val() > $("#reference_to").val()){
                            alert("Reference to is greater than Reference from");
                            return false;
                        }
                }
                

                if($("#show_to_customer").is(':checked')){
                    var show_to_customer = "Y";
                }else{
                    var show_to_customer = "N";
                }
                var page = $("#result_page").val();
                var comp = $("#cus_company_id").val();
                var project = $("#project_id").val();
                var status = $("#status_id").val();
                var status_l = $("#status_id_l").val();
                var ident_type_id = $("#ident_type_id").val();
                var ident_type_id_l = $("#ident_type_id_l").val();
                var prd_tier_id3 = $("#prd_tier_id3").val();
                var prd_tier_id3_l = $("#prd_tier_id3_l").val();
                var customer_zone_id = $("#customer_zone_id").val();
                var customer_zone_id_l = $("#customer_zone_id_l").val();
                var s_owner = $("#s_owner").val();
                var s_resolved = $("#s_resolved").val();
                var reference_from =$("#reference_from").val();
                var reference_to =$("#reference_to").val();

                var url = page + '?comp=' + comp + '&start=' + d1 + '&end=' + d2 + '&pj=' + project + '&c3=' + prd_tier_id3
                        + '&c3_l=' + prd_tier_id3_l + '&zone=' + customer_zone_id + '&zone_l=' + customer_zone_id_l + '&st='+status +'&st_l='+status_l
                        + '&id_t=' +ident_type_id+'&id_t_l='+ident_type_id_l+'&s_ow='+s_owner+'&s_re='+s_resolved
                        +'&ref_from='+reference_from+'&ref_to='+reference_to+'&show_to_customer='+show_to_customer;
//                alert(url);
                window.open(url,'_blank,_top');
           }
           
                
            
           
                
        });
        
        
        $("img#cancel").click(function(){
           page_submit("../../incident/main_incident/index.php?mode=1")
        });
     
     
     
     
       
    
    });
    
    

</script>
<script type="text/javascript">
    $(document).ready(function(){
        $("#s_owner").autocomplete({
            source: '../common/get_owner.php',
            minLength:1
        });

        $("#s_resolved").autocomplete({
            source: '../common/get_owner.php',
            minLength:1
        });

    });
</script>
<input type="hidden" name="hd_report" id="hd_report" value="<?=$report;?>" />
<!--<div width="100%">-->
    <table id="tb_adv_left" width="98%" border="0">
        
        
        <tr>
            <td></td>
            <th align="left">Company Code/รหัสบริษัท <span class="required">*</span></th>
            <td align="left" colspan="3"><?=$dd_company;?></td>
            <td></td>
        </tr>
        <tr>
            <td></td>
            <th align="left">Project/โครงการ <span class="required">*</span></th>
            <td align="left" colspan="3"><?=$dd_project;?></td>
            <td></td>
        </tr>
        <? if($report == 4){ ?>
        <tr>
                <td></td>
                <th align="left">Incident Type</th>
                <td align="left"><?=$dd_incident_type;?></td>
                <td align="center">To</td>
                <td><?=$dd_incident_type_l;?></td>
                <td></td>
        </tr>
        <? } 
        
        if($report != 1 && $report != 2 && $report != 5){ //&& $report != 3  ?>
        <tr>
            <td></td>
            <th align="left">Incident Date/วันที่ <span class="required">*</span></th>
            <td align="left"><span required type="calendar" name="inc_date" id="inc_date" value="" img="../../images/calendar.png"></span></td>
            <td align="center">To</td>
            <td align="left"><span required type="calendar" name="l_inc_date" id="l_inc_date" img="../../images/calendar.png" ></span></td>
            
            <td></td>
        </tr>
        <? }elseif ($report == 1) { ?>
		<tr>
            <td></td>
            <th align="left">Incident Date/วันที่ <span class="required">*</span></th>
            <td align="left"><span required type="calendar" name="inc_date" id="inc_date" value="" img="../../images/calendar.png"></span></td>
            <td align="center">To</td>
            <td align="left"><span required type="calendar" name="l_inc_date" id="l_inc_date" img="../../images/calendar.png" ></span></td>
            
            <td></td>
        </tr>
         <!--
		 <tr>
            <td></td>
            <th align="left">Incident Date/วันที่ <span class="required">*</span></th>
            <td align="left" colspan="3"><?= $dd_date_monthly;?></td>
            <td><input type="hidden" id="inc_date" name="inc_date"/><input type="hidden" id="l_inc_date" name="l_inc_date" /></td>
         </tr>   
		 -->
	<? }else { ?>
         <tr>
            <td></td>
            <th align="left">Incident Date/วันที่ <span class="required">*</span></th>
            <td align="left"><input type="text" id="inc_date" name="inc_date" value="<?=date("d-m-Y");?>" readonly="readonly" class="readonly" align="center" /></td>
            <td align="center"></td>
            <td align="left"><input type="hidden" id="l_inc_date" name="l_inc_date" value="<?=date("d-m-Y");?>" readonly="readonly" class="readonly" align="center" /></td>
            
            <td></td>
        </tr>   
            
            
            
            
        <?} if($report == 4){ ?>
        <tr>
                <td></td>
                <th align="left">Status/สถานะ</th>
                <td align="left"><?=$dd_status;?></td>
                <td align="center">To</td>
                <td><?=$dd_status_l;?></td>
                <td></td>
            </tr>
        <? } ?>
        <?
    if ($report == 3 || $report == 4 || $report == 5){// for Outstanding Report
       ?>
        
            <tr>
                <td></td>
                <th align="left">Customer Area/เขต</th>
                <td align="left"><?=$dd_cus_zone;?></td>
                <td align="center">To</td>
                <td><?=$dd_cus_zone_l;?></td>
                <td></td>
            </tr>
            <?
    }
    
    if ($report == 2 || $report == 3 || $report == 4 || $report == 5){
            
            ?>
           <tr>
                <td></td>
                <th align="left">Production Class 3</th>
                <td align="left"><?=$dd_prd_tier3;?></td>
                <td align="center">To</td>
                <td><?=$dd_prd_tier3_l;?></td>
                <td></td>
            </tr>
   <? 
    }
    if($report == 4){
    ?>
            <tr>
                <td></td>
                <th align="left" >Owner</th>
                <td colspan="4"><input type="text" id="s_owner" name="s_owner" style="width: 460px;"></td>
            </tr>
            <tr>
                <td></td>
                <th align="left" >Resolved By</th>
                <td colspan="4"><input type="text" id="s_resolved" name="s_resolved" style="width: 460px;"></td>
            </tr>
            <tr>
                <td></td>
                <th align="left" >Reference No.</th>
                <td ><input type="text" id="reference_from" name="reference_from" style="width:100%;"></td>
                <td align="center">To</td>
                <td ><input type="text" id="reference_to" name="reference_to" style="width:100%;"></td>
            </tr>
     <? } ?>
 <!--Add below by Uthen.P 13-05-2016 -->
        <? $show_to_customer = "N";?>

        <!-- Commented by Uthen.P 13-05-2016
        <tr>
            <td></td>
            <th align="left">Report to customer</th>
            <td align="left"><input type="checkbox" id="show_to_customer" name="show_to_customer" value="Y" checked style="margin: 0px 0px;width: 25px;"
                    <?#= ($show_to_customer == "Y") ? "checked":"" ;?> ></td>
        </tr>
        -->
        
<!--        <tr>
            <td><br><br><br></td>
            <td align="left" colspan="4" valign="bottom" >Resolution</td>
            <td></td>
        </tr>-->
        
<!--        <tr>
            <td><br><br></td>
        </tr>    
        <tr>
            <td></td>
            <th align="left">Production class 1</th>
            <td align="left"><input type="text" /></td>
            <td align="center">To</td>
            <td><input type="text" /></td>
            <td></td>
        </tr>
        <tr>
            <td></td>
            <th align="left">Production class 2</th>
            <td align="left"><input type="text" /></td>
            <td align="center">To</td>
            <td><input type="text" /></td>
            <td></td>
        </tr>
        <tr>
            <td></td>
            <th align="left">Production class 3</th>
            <td align="left"><input type="text" /></td>
            <td align="center">To</td>
            <td><input type="text" /></td>
            <td></td>
        </tr>-->
        <tr>
                <td colspan="6" ><br><br><br><br><br>
                    <div width="100%" style="background-color: #C0D9EA;" align="center">
                        <br><br>
                        <img id="search" name="search" src="<?=$application_path_images?>/search.gif" style="cursor: pointer;">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                        <img id="cancel" name="cancel" src="<?=$application_path_images?>/btn_cancel.png" style="cursor: pointer;">
                        <br><br>
                    </div> 
                </td>
                
            </tr>
        <tr>
            <td width="15%"></td>
            <td width="30%"></td>
            <td width="15%"></td>
            <td width="10%"></td>
            <td width="15%"></td>
            <td width="15%"></td>
        </tr>
    </table>
    
<!--</div>-->