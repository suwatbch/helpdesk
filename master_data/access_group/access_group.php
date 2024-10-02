<?php
    include_once "access_group.action.php";
?>
<link type="text/css" rel="stylesheet" href="../../include/js/tabber/example.css"/>
<script type="text/javascript" src="../../include/js/tabber/tabber.js"></script>
<script type="text/javascript">
        function validate_access_group(){
        if($("#access_group_code").val() == ""){
            jAlert('error', 'Please input Access Group Code', 'Helpdesk System : Messages');
            $("#access_group_code").focus();
            return false;   
        }else if($("#access_group_name").val() == ""){
            jAlert('error', 'Please input Access Group Name', 'Helpdesk System : Messages');
            $("#access_group_name").focus();
            return false;   
        }else{
            return true;
        }
    }
    function validate_de_access_group(){
        $.ajax({
                type: "GET",
                url: "../common/validate_detail.php",
                data: "action=access_group&access_group_code=" + $("#access_group_code").val() + "&access_group_name=" + $("#access_group_name").val() + "&access_group_id=" + $("#access_group_id").val(),
                success: function(respone){
                    //alert(respone);
                    if(respone == 1){ 
                        jAlert('error', 'Group Code Duplicate !!', 'Helpdesk System : Messages');
                        return false;
                   }else if(respone == 2){ 
                        jAlert('error', 'Group Name Duplicate !!', 'Helpdesk System : Messages');
                        return false;
                   }else{

                        $("#permission").val(perm.getValues());
                        page_submit("index.php?action=access_group.php", "save");
                      }
                }
            });
           
    }
    $(function(){
        $("#save").click(function(){
            if (validate_access_group()){
                validate_de_access_group();
            }            
        });

        $("#undo").click(function(){
            page_submit("index.php?action=access_group.php&action_master=1");
        });

        $("#cancel").click(function(){
            page_submit("index.php?action=access_group_list.php");
        });

        $("#perm").attr("src", "access_group.permission.php?access_group_id=<?=$access_group["access_group_id"]?>");
        $("#div").css("display", "block");
               
    });
    
    function back_master(){
        <?
            $_SESSION["current"] = "master_data/access_group/index.php?action=access_group_list.php";
            
        ?>
            top.location.href= "../../home.php";
    }
</script>
<? $search_user = $_REQUEST["s_access_group_id"];?>
<div id="div"  style="display: none;">
    <div class="tabber">
        <div align="left" class="<?if($search_user==''){ echo "tabbertab tabbertabdefault";}else{ echo "tabbertab"; }?> " title="General" style="height: 280px;">
            <?php include_once "access_group.general.php";?>
        </div>
        <div align="left" class="tabbertab" title="Permission" style="height: 280px;">
            <iframe name="perm" id="perm" frameborder="0" style="height: 100%; width: 100%;"></iframe>
        </div>
        <? if(strUtil::isNotEmpty($access_group["access_group_id"])){ ?>
        <div align="left" class="<?if($search_user!=""){ echo "tabbertab tabbertabdefault";}else{ echo "tabbertab"; }?>" title="Member" style="height: 280px;">
            <?php include_once "access_group.member.php";?>
        </div>
        <? } ?>
</div>
<input type="hidden" name="access_group_id" id="access_group_id" value="<?=$_REQUEST["access_group_id"]?>"/>
<input type="hidden" name="member" id="member"/>
<input type="hidden" name="permission" id="permission"/>
<input type="hidden" name="ss_search_user" id="ss_search_user"/>