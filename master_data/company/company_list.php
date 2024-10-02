<?php
    include_once "../../include/config.inc.php";
    include_once "company_list.action.php";
    include_once "../common/tablesorter_header.php";
?>
<script type="text/javascript">
     function validate_delete(){
        $.ajax({
                type: "GET",
                url: "../common/validate_delete.php",
                data: "action=company&company_id=" + $("#company_id").val(),
                success: function(respone){
                    //alert(respone);
                    if(respone == 1){ 
                        jAlert('error', 'Cannot delete because this data was used to process', 'Helpdesk System : Messages');
                        return false;
                   }else{
                       page_delete("index.php?action=company_list.php&company_id="+ $("#company_id").val(), 'delete');
                      }
                }
            });
           
    }
    $(function(){
        $("img[alt=delete]").live('click', function() {
          $("#company_id").val($(this).attr("value"));
          validate_delete();
        });
    });
</script>
<div class="full_width" style="overflow: auto; height: 540px; ">
    <table cellpadding="0" cellspacing="0" border="0" class="display" id="example" style="width:100%">
    
    <thead>
        <tr>
            <!--<th width="5%"></th>-->
            <th width="2%"><span class="Head">No.</span></th>
            <th><span class="Head">Company</span></th>
            <th width="8%"><span class="Head">Action</span></th>
        </tr>
    </thead>
    <tbody>
    <?php
            $index=1;
           if (count($companys) > 0){
               foreach ($companys as $company) {
    ?>
        <tr>
            <td align="center"><?=$index++;?></td>
            <td align="left"><?=$company["company_name"]?></td>
                        <td>
                            <? //if($company['status_company']=='D'){  ?>
<!--                            <img src="../../images/application_restore.png" id="restore" style="cursor: pointer;" onclick="page_delete('index.php?action=company_list.php&company_id=////<?=$company["company_id"]?>', 'restore', 'Do you want restore ?');"/>-->
                            <? // } else { ?>
                            <a href="index.php?action=company.php&action_master=1&company_id=<?=$company["company_id"]?>"><img src="../../images/edit_inline.png" style="cursor: pointer;"></a> 
                            <!--<img src="../../images/close_inline.png" id="delete" onclick="page_delete('index.php?action=company_list.php&company_id=<?=$company["company_id"]?>', 'restore');"style="cursor: pointer;"/>-->
                            <img id="delete" name="delete" alt="delete" src="<?=$application_path_images;?>/close_inline.png" title="delete" style="cursor: pointer; border: none;" value="<?=$company["company_id"]?>" />
                             
                                <?// } ?>
                            
                        </td>
        </tr>
          <?php 		
		 		 }//end foreach
		 	} //end if
		 ?>
    </tbody>
</table>
<input type="hidden" name="company_id" id="company_id"/>
</div>



    


