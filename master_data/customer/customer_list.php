<?php
    include_once "../../include/config.inc.php";
    include_once "customer_list.action.php";
?>
<style type="text/css" media="screen">
    
        @import "<?=$application_path_js?>/tablesorter-filter/css/demo_table.css";
        .dataTables_info { padding-top: 0; }
        .dataTables_paginate { padding-top: 0; }
        .css_right { float: right; }
        #example_wrapper .fg-toolbar { font-size: 0.8em }
        #theme_links span { float: left; padding: 2px 10px; }
        
</style>
<style>
        .Head{
            color: #cfdce7;
        }
        #example tr:nth-child(even){background-color: white; }
        #example tr:nth-child(odd) {background: #ecf2f6}
        #example td:first-child {background: #B0BED9; opacity:0.4;}
</style>
<script type="text/javascript">
     function validate_delete(){
        $.ajax({
                type: "GET",
                url: "../common/validate_delete.php",
                data: "action=customer&code_cus=" + $("#code_cus").val(),
                success: function(respone){
                    //alert(respone);
                    if(respone == 1){ 
                        jAlert('error', 'Cannot delete because this data was used to process', 'Helpdesk System : Messages');
                        return false;
                   }else{
                        page_delete("index.php?action=customer_list.php&cus_id="+ $("#cus_id").val(), 'delete');
                      }
                }
            });
           
    }
    $(function(){
        $("img[alt=delete]").live('click', function() {
          var data_object = $(this).attr("value");
            var arr_object = data_object.split('|');
            $("#cus_id").val(arr_object['0']);
            $("#code_cus").val(arr_object['1']);
            validate_delete();
        });
        $("#search").click(function(){
            $("#page").val(1);
            page_submit("index.php?action=customer_list.php", "search");
        });
    });
</script>
    <table width="100%" border="0" cellpadding="0" cellspacing="0">
        <tr>
            <td colspan="2" align="right">
                <b>Search :</b> <input type="text" name="search_customer" style="width: 150px;" value="<?=$_REQUEST["search_customer"]?>"/>&nbsp;&nbsp;
                <img id="search" src="../../images/search.png" style="cursor: pointer; border: none;"/>
            </td>
        </tr>
                <tr height="25">
                    <td width="50%" align="left">Total <?=number_format($total_row)?> Records</td>
                    <td width="50%" align="right"><?php include("../../include/page_control.php");?></td>
                </tr>
            </table>
<!--<div class="full_width" style="overflow: auto; height: 510px; ">-->
 <table cellpadding="0" cellspacing="0" border="0" class="display" id="example" style="width:100%;">
    <thead>
        <tr>
            <th width="2%"><span class="Head">No.</span></th>
            <th><span class="Head">Customer ID</span></th>
            <th><span class="Head">first Name</span></th>
            <th><span class="Head">Last Name</span></th>
            <th><span class="Head">Company</span></th>
            <th width="8%"><span class="Head">Action</span></th>
        </tr>
    </thead>
    <tbody>
    <?php
           
           if (count($s_customer) > 0){
               
               $index = get_first_reccord($page, $page_size);
               foreach ($s_customer as $ss_customer) {
    ?>
        <tr>
                        <td align="center" style=" color: black;"><?=$index?></td>
                        <td align="left"><?=$ss_customer["code_cus"]?></td>
                        <td align="left"><?=$ss_customer["firstname_cus"]?></td>
                        <td align="left"><?=$ss_customer["lastname_cus"]?></td>
                        <td align="left"><?=$ss_customer["cus_company_name"]?></td>
                        <td>
                            <? if($ss_customer['status_customer']=='I'){  ?>
                            <img src="../../images/restore2.jpg" id="restore" style="cursor: pointer;" onclick="page_delete('index.php?action=customer_list.php&cus_id=<?=$ss_customer["cus_id"]?>', 'restore', 'Do you want restore ?');"/>
                            <?  } else { ?>
                            <a href="index.php?action=customer.php&action_master=1&c_cus_id=<?=$ss_customer["cus_id"]?>"><img src="../../images/copy.png" style="cursor: pointer;"></a> 
                            <a href="index.php?action=customer.php&action_master=1&cus_id=<?=$ss_customer["cus_id"]?>"><img src="../../images/edit_inline.png" style="cursor: pointer;"></a> 
                            <!--<img src="../../images/close_inline.png" id="delete" style="cursor: pointer;" onclick="page_delete('index.php?action=customer_list.php&cus_id=<?=$ss_customer["cus_id"]?>', 'delete');"/>-->
                            <img id="delete" name="delete" alt="delete" src="<?=$application_path_images;?>/close_inline.png" title="delete" style="cursor: pointer; border: none;" value="<?=$ss_customer["cus_id"]."|".$ss_customer["code_cus"]?>" />                        
                                <? } ?>
                        </td>
        </tr>
                 <?php
                 $index++;
               }//end foreach
           } //end if
		 ?>
    </tbody>
</table>
<input type="hidden" id="cus_id" name="cus_id">
<input type="hidden" id="code_cus" name="code_cus">
<!--</div>-->




    


