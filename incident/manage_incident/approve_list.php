<?php
    include_once "approve_list.action.php";

    $arr_activity = $activity_plan["data"];
    $total_row = $activity_plan["total_row"];
?>
<link type="text/css" rel="stylesheet" href="../../include/js/tabber/example.css"/>
<script type="text/javascript" src="../../include/js/tabber/tabber.js"></script>
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
        
        $("<div id=\"dialog-reason\"></div>")
        .appendTo("form")
        .dialog({
            width: 500
            , height: document.body.clientHeight - 200
            , autoOpen: false
            , modal: true
            , resizable: false
            , title: "Rejection Reason"
            , close : function(){
                $("#ifr-reason").attr("src", "");
            }
        });
        

       
        $("img[alt=View]").click(function(){
            if ($("#dialog").find("iframe").length == 0){
                $("#dialog").html("<iframe id=\"ifr\" frameborder=\"0\" width=\"100%\" height=\"100%\" scrolling=\"auto\" src=\"../../blank.php\"></iframe>");
            }
            
            $("#ifr").attr("src", "../../dialog/activity_plan.php?id=" + $(this).attr("value") + "&status=" + $("#type_status").val());

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
                        var member = new Array;
                        $("#tblmember tbody").find(":checked").each(function(){
                        
                        var tr = $(this).parent().parent();
                        var obj = new Object;

                        obj.activity_plan_id = tr.attr("value");
                        member.push(obj);
                    });
                        var select_id = window.id_onselected(member);
                        if (select_id != ""){
                            $("#selected").val(select_id); 
                            page_submit("index.php?action=approve_list.php", "approve");
                        }
                    }
                }
            });

        $("#reject").click(function(){
            if (validate()){
                if (validate2()){
                    $("#click_type").val("reject");
                    $("#tblmember tbody").find(":checked").each(function(){
                        if ($("#dialog-reason").find("iframe").length == 0){
                        $("#dialog-reason").html("<iframe id=\"ifr-reason\" frameborder=\"0\" width=\"100%\" height=\"100%\" scrolling=\"no\" src=\"../../blank.php\"></iframe>");
                    }
                    $("#ifr-reason").attr("src", "reject_dialog.php");
                    $("#dialog-reason").dialog("open");
                    });
                    
                }
            }
        });

            $("#div").css("display", "block");   
            
            
            
            $("#search").click(function(){
            if (validate()){
                var arr = null;
                var d1 = $("#start_date").val();
                var d2 = $("#end_date").val();
                
                arr = d1.split("-");
                d1 = arr[2] + "" + arr[1] + "" + arr[0];

                arr = d2.split("-");
                d2 = arr[2] + "" + arr[1] + "" + arr[0];

                if (d2 < d1) {
                    jAlert('warning', 'Activity to is greater than Activity from.', 'Helpdesk System : Messages');
                    return false;
                }
                
                page_submit("index.php?action=approve_list.php", "search");
            }
        });
        
        $("#chkAll").change(function(){
                    var checked = $(this).is(":checked");
                    $("#tblmember tbody :checkbox").each(function(){
                        $(this).attr("checked", checked);
                    });
                });

        $("#tblmember tbody :checkbox").change(function(){
            var checked = true;
            $("#tblmember tbody :checkbox").each(function(){
                if (!$(this).is(":checked")){
                    checked = false;
                    return;
                }
            });

            $("#chkAll").attr("checked", checked);                    
        });
        
        $("#sendmail").click(function(){
                    page_submit("sendmail.php?action=mail");
                });
        
});

function dialog_onSelected(lookuptype, obj){
        if (obj != null){
            if (lookuptype == "project"){
                $("#project_id").val(obj.project_id);
                $("#project_name").val(obj.project_name);

            } else if (lookuptype == "employee"){
                $("#employee_id").val(obj.employee_id);
                $("#employee_name").val(obj.employee_name);
            }
          } 
        }
        
        
function validate2(){
        var err = $("#duration span").html();
        if (err != "" && err != null){
            jAlert('error', err, 'Helpdesk System : Messages');
            //alert(err);
            if (err.indexOf("End") > -1){
                $("#end_time").focus();
            } else {
                $("#start_time").focus();
            }
            return false;
        }
        return true;
    }
    
    
    
function id_onselected(member){
        var plan_id = "" ;
        var i = 0;
        while (i< member.length){
            if (i==0){
                plan_id = member[i].activity_plan_id
            }else{
                plan_id = plan_id + ",";
                plan_id = plan_id + member[i].activity_plan_id
            };
        i++;
        }
        return plan_id;
}

function reject_reason(reason,type){
    if (type == "Y"){
        var member = new Array;
        $("#tblmember tbody").find(":checked").each(function(){

            var tr = $(this).parent().parent();
            var obj = new Object;

            obj.activity_plan_id = tr.attr("value");
            member.push(obj);
        });
        var select_id = window.id_onselected(member);
        $("#selected").val(select_id); 
        $("#reject_remark").val(reason);
        page_submit("index.php?action=approve_list.php", "reject");
    }
    $("#ifr-reason").attr("src", "blank.php");
    $("#dialog-reason").dialog("close");
}

</script>
<script type="text/javascript">
    $(function(){
        $("#save").click(function(){
            if (validate()){
                $("#permission").val(perm.getValues());
                $("#member").val(getMembers());

                page_submit("index.php?action=access_group.php", "save");
            }            
        });

        $("#undo").click(function(){
            page_submit("index.php?action=access_group.php");
        });

        $("#back").click(function(){
            page_submit("index.php?action=access_group_list.php");
        });

        $("#perm").attr("src", "access_group.permission.php?access_group_id=<?=$access_group["access_group_id"]?>");
        $("#div").css("display", "block");
    });
</script>
<div style="margin-top: 5px;">
    <table width="100%" border="0" cellpadding="0" cellspacing="0">
        <tr>
            <td colspan="5"><b>Incident Request Information</b><br></td>
        </tr>
        <tr>
        	<td>
            	<table width="100%" border="0" cellspacing="0" cellpadding="0">
                  <tr>
                    <td colspan="8" style="line-height:5px;">&nbsp;</td>
                  </tr>
                  <tr>
                    <td width="8%" class="tr_header">Summary*</td>
                    <td width="29%"><textarea name="description" maxlength="300" style="width: 275px; height: 30px;"><?=htmlspecialchars($access_group["description"])?></textarea></td>
                    <td width="7%" class="tr_header">Status</td>
                    <td width="20%"><select id="type_status" name="type_status" style="width: 200px;">
                    <option value="WP" selected>New</option>
                    <option value="WP">Assigned</option>
                    <option value="CP">Working</option>
                    <option value="RJ">Pending</option>
                    <option value="RJ">Resolved</option>
                    <option value="RJ">Propose Closed</option>
                    <option value="RJ">Closed</option>
                </select></td>
                    <td width="11%" class="tr_header">Status Reason</td>
                    <td width="25%"><select id="type_status" name="type_status" style="width: 200px;">
                    <option value="WP" selected></option>
                    <option value="WP">Assigned</option>
                    <option value="CP">Working</option>
                    <option value="RJ">Pending</option>
                    <option value="RJ">Resolved</option>
                    <option value="RJ">Propose Closed</option>
                    <option value="RJ">Closed</option>
                </select></td>
                  </tr>
                  <tr>
                    <td colspan="8" style="line-height:2px;">&nbsp;</td>
                 </tr>
                  <tr>
                    <td class="tr_header">Notes</td>
                    <td rowspan="3"><textarea name="description" maxlength="300" style="width: 275px; height: 50px;" readonly><?=htmlspecialchars($access_group["description"])?></textarea></td>
                    <td class="tr_header">Impact</td>
                    <td><select id="type_status" name="type_status" style="width: 200px;">
                    <option value="WP" selected></option>
                    <option value="WP">Wait for Approve</option>
                    <option value="CP">Approved</option>
                    <option value="RJ">Rejected</option>
                </select></td>
                    <td class="tr_header">Priority</td>
                    <td><input type="text" name="access_group_name" style="width: 200px" maxlength="50" readonly class="disabled" description="Group Name" value="<?=htmlspecialchars($access_group["access_group_name"])?>"/></td>
                  </tr>
                  
                  <tr>
                    <td colspan="8" style="line-height:2px;">&nbsp;</td>
                  </tr>
                  <tr>
                    <td>&nbsp;</td>
                    <td class="tr_header">Urgency</td>
                    <td><select id="type_status" name="type_status" style="width: 200px;">
                    <option value="WP" selected></option>
                    <option value="WP">Wait for Approve</option>
                    <option value="CP">Approved</option>
                    <option value="RJ">Rejected</option>
                </select></td>
                    <td>&nbsp;</td>
                    <td>&nbsp;</td>
                  </tr>
                </table>
            </td>
        </tr>
    </table>
    <hr>
</div>

<div id="div"  style="display: none;">
    <div class="tabber">
        <div align="left" class="tabbertab" title="Customer" style="height: 280px;">
            <?php include "create.tab.customer.php";?>
        </div>
        <div align="left" class="tabbertab" title="Contact" style="height: 280px;">
            <?php include "create.tab.contact.php";?>
        </div>
        <!--<div align="left" class="" title="Cassification" style="visibility:hidden; height: 280px;">-->
        <div align="left" class="tabbertab" title="Cassification" style="height: 280px;">
            <?php include_once "create.tab.cassification.php";?>
        </div>
        <div align="left" class="tabbertab" title="Assignment" style="height: 280px;">
            <?php include_once "create.tab.assignment.php";?>
        </div>
    </div>
        
        
    <div class="button-action" style="text-align: left; margin-top: 5px;">
        <input type="button" id="save" class="input-button input-button-save" value="Save"/>
        <input type="button" id="undo" class="input-button input-button-undo" value="Undo"/>
        <input type="button" id="back" class="input-button input-button-back" value="Close"/>
    </div>
</div>

<br>

<div>
<?php
    if (strUtil::isEmpty(user_session::get_sale_group_id())){
 ?>       
     <input type="button" id="sendmail" class="input-button input-button-new" value="   Send Email" />   
 <?php       
    }
?>   
<input type="hidden" name="selected" id="selected"/>
<input type="hidden" name="reject_remark" id="reject_remark"/>
<input type="hidden" name="sale_id" id="sale_id" value="<?=user_session::get_sale_id()?>"/>
</div>