<?php
    include_once "../../include/config.inc.php";
    include_once "customer_company_list.action.php";
    include_once "../common/tablesorter_header.php";
?>
<script type="text/javascript">
     function validate_delete(){
        $.ajax({
                type: "GET",
                url: "../common/validate_delete.php",
                data: "action=cus_company&cus_company_id=" + $("#cus_company_id").val(),
                success: function(respone){
                    //alert(respone);
                    if(respone == 1){ 
                        jAlert('error', 'Cannot delete because this data was used to process', 'Helpdesk System : Messages');
                        return false;
                   }else{
                       page_delete("index.php?action=customer_company_list.php&cus_company_id="+ $("#cus_company_id").val(), 'delete');
                      }
                }
            });
           
    }
    $(function(){
        $("img[alt=delete]").live('click', function() {
          $("#cus_company_id").val($(this).attr("value"));
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
            <th><span class="Head">Customer Company</span></th>
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
                        <td align="center"><?=$index++?></td>
                        <td align="left"><?=$company["cus_company_name"]?></td>
                        <td>
                            <? if($company['status']=='D'){  ?>
                            <img src="../../images/application_restore.png" id="restore" style="cursor: pointer;" onclick="page_delete('index.php?action=customer_company_list.php&cus_company_id=<?=$company["cus_company_id"]?>', 'restore', 'Do you want restore ?');"/>
                            <?  } else { ?>
                            <a href="index.php?action=customer_company.php&action_master=1&cus_company_id=<?=$company["cus_company_id"]?>"><img src="../../images/edit_inline.png" style="cursor: pointer;"></a> 
<!--                            <img src="../../images/close_inline.png" id="delete" style="cursor: pointer;" onclick="page_delete('index.php?action=customer_company_list.php&cus_company_id=<?=$company["cus_company_id"]?>', 'restore');"/>-->
                            <img id="delete" name="delete" alt="delete" src="<?=$application_path_images;?>/close_inline.png" title="delete" style="cursor: pointer; border: none;" value="<?=$company["cus_company_id"]?>" />                        
    <? } ?>
                            
                        </td> 
        </tr>
        <?php 		
		 		 }//end foreach
		 	} //end if
		 ?>
    </tbody>
</table>
<input type="hidden" name="cus_company_id" id="cus_company_id"/>
</div>



    


