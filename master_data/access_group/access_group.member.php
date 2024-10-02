<? include_once "../common/tablesorter_header.php"; ?>
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
            if ($("#dialog").find("iframe").length == 0){
                $("#dialog").html("<iframe id=\"ifr\" frameborder=\"0\" width=\"100%\" height=\"100%\" scrolling=\"no\" src=\"../../blank.php\"></iframe>");
            }

            $("#ifr").attr("src", "member_dialog.php?access_group_id="+$("#s_access_group_id").val());
            $("#dialog").dialog("open");
        });

       
    });
    
    function member_onselected(member){
       
        $("#sss_member").val(member);
        page_submit("index.php?action=access_group.php", "save_user");
        $("#ifr").attr("src", "blank.php");
        $("#dialog").dialog("close");
    }
    
    function close_cancel(){
		
        $("#ifr").attr("src", "blank.php");
        $("#dialog").dialog("close");
    }
    
    $(function(){
        $("img[alt=delete]").live('click', function() {
          $("#s_user_id").val($(this).attr("value"));
          page_delete("index.php?action=access_group.php&user_id="+ $("#s_user_id").val() + "&access_group_id=" + $("#s_access_group_id").val(), 'delete_user');
        });
    });
</script>
<div style="text-align: right; margin: 0px 22px 2px 0px;">
    <input type="button" id="add_member" value="Add Member" class="input-button" style="width: 100px;"/>
</div>
<br><br>
<div class="full_width" style="overflow: auto; height: 450px; ">
 <table cellpadding="0" cellspacing="0" border="0" class="display" id="example" style="width:100%;">
    <thead>
        <tr>
            <th width="5%" align="center"><span class="Head">No.</span></th>
            <th width="15%" align="center"><span class="Head">Employee Code</span></th>
            <th width="26%" align="left"><span class="Head">First Name</span></th>
            <th width="26%" align="left"><span class="Head">Last Name</span></th>
            <th width="20%" align="left"><span class="Head">Company</span></th>
            <th width="8%" align="center"><span class="Head">Action</span></th>
        </tr>
    </thead>
    <tbody>
            <?php
                if (count($access_group["member"]) > 0){
                    $index = 1;
                    foreach ($access_group["member"] as $m) {
            ?>
            <tr value="<?=$m["user_id"]?>">
                <td width="5%" align="center"><?=$index++?></td>
                <td width="15%" align="center"><?=$m["employee_code"]?></td>
                <td width="26%" align="left"><?=$m["first_name"]?></td>
                <td width="26%" align="left"><?=$m["last_name"]?></td>
                <td width="20%" align="left"><?=$m["company_name"]?></td>
                <td width="8%" align="center"><img src="../../images/close_inline.png" id ="delete" name="delete" alt="delete" style="cursor: pointer;" value="<?=$m["user_id"]?>"/></td>
                
            </tr>
            <?php
                    }
                }
            ?>
    </tbody>
    </table>

    <input type="hidden" id="s_rows" name="s_row" value="<? echo count($access_group['member']);?>">
    <input type="hidden" id="s_user_id" name="s_user_id" value="">
    <input type="hidden" id="s_access_group_id" name="s_access_group_id" value="<?=$access_group["access_group_id"]?>">
    <input type="hidden" id="sss_member" name="sss_member" value="">
</div>