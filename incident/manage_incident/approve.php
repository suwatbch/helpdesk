<?php
//    include ('../../include/css/cctstyles.css');
    include_once "approve_list.action.php";
    $param_search = paramsearch();

    include_once "approve.action.php";
    search();
    $arr_activity = $activity_plan["data"];
    $total_row = $activity_plan["total_row"];
    
//    echo "total row = $total_row";
    
        

?>
<script type="text/javascript" src="../../dialog/dialog.ui.js"></script>
<script type="text/javascript">
    $(function(){
        
        $("<div id=\"dialog\"></div>")
        .appendTo("form")
        .dialog({
            width: 750
            , height: document.body.clientHeight - 25
            , autoOpen: false
            , modal: true
            , resizable: false
            , title: "Activity Plan"
            , close : function(){
                $("#ifr").attr("src", "");
            }
        });

       
        $("img[alt=View]").click(function(){
            if ($("#dialog").find("iframe").length == 0){
                $("#dialog").html("<iframe id=\"ifr\" frameborder=\"0\" width=\"100%\" height=\"100%\" scrolling=\"auto\" src=\"../../blank.php\"></iframe>");
            }
            
            $("#ifr").attr("src", "../../dialog/activity.php?id=" + $(this).attr("value"));

            var maxHeight = 420;
            var height = $("#dialog").dialog("option", "height");
            if ( height > maxHeight){
                $("#dialog").dialog("option", "height",  maxHeight);
            }

            $("#dialog").dialog("open");
        });
        
        
        $("#approve").click(function(){
                if (validate()){
                    if (validate2()){
                        alert('Approve');
//                        page_submit("index.php?action=approve.php", "approve");
                    }
                }
            });

            $("#reject").click(function(){
                if (validate()){
                    if (validate2()){
                        alert('Reject');
//                        page_submit("index.php?action=approve.php", "reject");
                    }
                }
            });

            $("#div").css("display", "block");   
        
});
</script>
<table width="100%" border="0" cellpadding="0" cellspacing="0">
    <tr>
        <td colspan="2"><b> Approve Activity Plan </b></td>
    </tr>
<tr>
            <td height="30" align="right" valign="middle">
            Employee Name  </td>
            <td>
               <input type="text" readonly="true" style="width: 280px;" value="<?=$param_search["employee_name"];?>" />
               <input type="hidden" id="employee_id" value="<?=$param_search["employee_id"];?>" />
            </td>
        </tr>
        <tr>
            <td height="30" align="right" valign="middle">
            Project Name </td>
            <td>
                <input type="hidden" id="project_id" value="<?=$param_search["project_id"];?>" />
              <input type="text" readonly="true" style="width: 280px;" value="<?=$param_search["project_name"];?>" />
            </td>
         </tr>
         <tr>
        <td height="30" align="right" valign="middle">
            Activity From</td>
            <td>
                <input type="text" readonly="true" style="width: 120px;" value="<?=$param_search["start_date"];?>" />
            &nbsp;To
            <span class="tr_detail">
                <input type="text" readonly="true" style="width: 120px;" value="<?=$param_search["end_date"];?>" />
            </span>
           
          </td>
          </tr>
          <tr>
              <td></td>
              <td>
            <?php include_once "../../include/page_control.php";?>
        </td>
          </tr>
          
</table>
<table width="100%" cellpadding="0" cellspacing="1" class="data-table">
    <thead>
        <tr>
            <td width="5%" align="center">Select</td>
            <td width="5%" align="center">No.</td>
            <td width="11%" align="center">Date</td>
            <td width="12%" align="center">Time</td>
            <td width="40%" align="center">Customer Name</td>
            <td width="20%" align="center">Objective</td>
            <td width="7%" align="center">View</td>
         </tr>
    </thead>
    <tbody>
        <?php
            if (count($arr_activity) > 0){
                $index = get_first_reccord($page, $page_size);
                foreach ($arr_activity as $activity_plan) {
        ?>
        <tr style="cursor: pointer" value="<?=$activity_plan["activity_plan_id"]?>" >
            <td align="center"><input name="selected" type="checkbox" value="<?=$activity_plan["activity_plan_id"]?>" /></td>
            <td align="center"><?=$index++?></td>
            <td align="center"><?=dateUtil::date_dmy($activity_plan["activity_plan_date"])?></td>
            <td align="center"><?=(strUtil::isEmpty($activity_plan["start_time"])) ? $activity_plan["duration_time"]." ".$activity_plan["unit_of_time"] : $activity_plan["start_time"]." - ".$activity_plan["end_time"]?></td>
            <td><?=$activity_plan["customer_name"]?></td>
            <td><?=$activity_plan["objective_name"]?></td>
            <td>
              <img src="../../images/application_view.png" alt="View" style="cursor: pointer;" value="<?=$activity_plan["activity_plan_id"]?>"/>
            </td>
            
        </tr>
        <?php
                }
            }
        ?>
    </tbody>
</table><br>
<span class="button-action" style="margin-top: 5px">
        <input type="button" id="approve" class="input-button input-button-approve" value="   Approve"/>
        <input type="button" id="reject" class="input-button input-button-reject" value=" Reject"/>
</span>
<input type="hidden" name="activity_id" id="activity_id"/>
<input type="hidden" name="activity_status" id="activity_status"/>
<input type="hidden" name="sale_id" id="sale_id" value="<?=user_session::get_sale_id()?>"/>
<!-- ตัวอย่างภาษา -->