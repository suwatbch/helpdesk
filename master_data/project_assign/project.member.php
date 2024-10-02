<? 
include_once "../common/tablesorter_header.php"; 
?>
<script type="text/javascript">
    $(function(){
         $("<div id=\"dialog\"  title=\"Member\"></div>")
        .appendTo("form")
        .dialog({
            width: 625
            , height: 500
            , autoOpen: false
            , modal: true
            , resizable: false
            , close : function(){
                $("#ifr").attr("src", "");
            }
        });

        $("#add_member").click(function(){
			
			//alert($("#s_project_id").val());
			
            if ($("#dialog").find("iframe").length == 0){
                $("#dialog").html("<iframe id=\"ifr\" frameborder=\"0\" width=\"100%\" height=\"100%\" scrolling=\"no\" src=\"../../blank.php\"></iframe>");
            }

			//alert($("#s_access_group_id").val()));
			
            $("#ifr").attr("src", "member_dialog.php?project_id="+$("#s_project_id").val());
            $("#dialog").dialog("open");
        });

       
    });
    
    function member_onselected(member){
       
        $("#sss_member").val(member);
        page_submit("index.php?action=project_assign.php", "save_user");
        $("#ifr").attr("src", "blank.php");
        $("#dialog").dialog("close");
    }
    
    function close_cancel(){
		
        $("#ifr").attr("src", "blank.php");
        $("#dialog").dialog("close");
    }
    
    $(function(){
		  $("img[alt=delete]").live('click', function() {
          $("#p_user_id").val($(this).attr("value"));
          page_delete("index.php?action=project_assign.php&id="+ $("#p_user_id").val(), 'delete_user');
        });
    });
</script>
<br><br>
<table width="80%" border="0" cellpadding="0" cellspacing="5" align="center">
    <tr>
        <td class="tr_header">Project Code</td>
        <td><input type="text" id="project_code" name="project_code" style="width: 100%;" value="<?=$objective["project_code"]?>"/></td>
    </tr>
    <tr>
        <td class="tr_header">Project Name</td>
        <td><input type="text" id="project_name" name="project_name" style="width: 100%;" value="<?=$objective["project_name"]?>"/></td>
    </tr>
    <tr>
        <td class="tr_header">Customer Company</td>
        <td><input type="text" id="project_name" name="project_name" style="width: 100%;" value="<?=$objective["cus_company_name"]?>"/></td>
    </tr>
	<tr>
        <td class="tr_header">Member</td>
        <td><input type="button" id="add_member" value="Add Member" class="input-button" style="width: 120px;"/></td>
    </tr>
</table>

<br>
<div class="full_width" style="overflow: auto; height: 450px; ">

    <table cellpadding="0" cellspacing="0" border="0" class="display" id="example" style="width:100%">
    <thead>
        <tr>
            <!--<th width="5%"></th>-->
            <th width="2%"><span class="Head">No.</span></th>
            <th><span class="Head">User Code</span></th>
            <th><span class="Head">First Name</span></th>
            <th><span class="Head">Last Name</span></th>
            <th><span class="Head">Company</span></th>
            <th width="8%"><span class="Head">Action</span></th>
        </tr>
    </thead>
    <tbody>
    <?php
            $index=1;
           if (count($member) > 0){
               foreach ($member as $ss_member) {
    ?>
        <tr>
                        <td align="center"><?=$index++?></td>
                        <td align="left"><?=$ss_member["code_cus"]?></td>
                        <td align="left"><?=$ss_member["firstname_cus"]?></td>
                        <td align="left"><?=$ss_member["lastname_cus"]?></td>
                        <td align="left"><?=$ss_member["cus_company_name"]?></td>
                        <td>
                            <? //if($company['status_company']=='D'){  ?>
                            <!--<img src="../../images/application_restore.png" alt="Restore" style="cursor: pointer;" />-->
                            <? // } else { ?>
                            <img id="delete" name="delete" alt="delete" src="<?=$application_path_images;?>/close_inline.png" title="delete" style="cursor: pointer; border: none;" value="<?=$ss_member["id"]?>" />
<!--<img src="../../images/close_inline.png" id="delete" style="cursor: pointer;" onclick="javascript:page_delete('index.php?action=user_other.php&specorg_id='<?=$ss_member["specorg_id"]?>,'delete');"/>-->
                            <? //} ?>
                            
                        </td>
        </tr>
                 <?php 		
		 		 }//end foreach
		 	} //end if
		 ?>
    </tbody>
</table>

    <input type="hidden" id="s_rows" name="s_row" value="<? echo count($access_group['member']);?>">
    <input type="hidden" id="s_user_id" name="s_user_id" value="">
	<input type="hidden" id="p_user_id" name="p_user_id" value="">
    <input type="hidden" id="s_project_id" name="s_project_id" value="<?=$objective["project_id"]?>">
    <input type="hidden" id="sss_member" name="sss_member" value="">
</div>