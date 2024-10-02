<?php
   include_once "import_cus.action.php";
?>
<html>
<head>
<title></title>
<script type="text/javascript">
function validate_import(){
        if($("#fileCSV").val() == ""){
            jAlert('error', 'Please Select File CSV to upload', 'Helpdesk System : Messages');
            $("#fileCSV").focus();
            return false;   
        }else if($("#cus_company_id").val() == ""){
            jAlert('error', 'Please Select Company', 'Helpdesk System : Messages');
            $("#cus_company_id").focus();
            return false;   
        }else if($("#cus_org_id").val() == ""){
            jAlert('error', 'Please Select Organization', 'Helpdesk System : Messages');
            $("#cus_org_id").focus();
            return false;   
        }else{
            return true;
        }
}
function check_file_csv(){
    var fileName = $("#fileCSV").val();
    var ext = fileName.substring(fileName.lastIndexOf('.') + 1);
    if(ext == "csv"){
        return true;
    }else{
        jAlert('error', 'Please Upload File Type CSV', 'Helpdesk System : Messages');
        $("#org_cus").focus();
        return false;
    }
}  
$(function(){
        $("#btnSubmit").click(function(){
            if(validate_import()){
                if(check_file_csv()){
                page_submit("index.php?action=import_cus.php","save");
                }
            }
        });
});
        
        
</script>
<script type="text/javascript">
   $(document).ready(function () {   
    
	$("#cus_company_id").change(function(){
           var cus_company_id = $(this).val();

            $.ajax({
                type: "GET",
                url: "../common/dropdown.cus_org.php",
                data: "cus_company_id=" + cus_company_id,
                success: function(respone){
                   // alert(respone);
                    $("#cus_org_id").replaceWith(respone);
                }
            }); 
       });
    
   });   
    
</script> 
</head>
<body>
    <br><br><br>
  <table width="80%" border="0" cellpadding="0" cellspacing="5" align="center">
  <tr>
        <td class="tr_header">Company <span class="required">*</span></td>
        <td><?=$dd_company_cus;?>
        </td>
    </tr>
    <tr>
        <td class="tr_header">Organization <span class="required">*</span></td>
        <td><?=$dd_org_cus;?>
        </td> 
    </tr>
    <tr>
        <td class="tr_header">Attach File <span class="required">*</span></td>
        <td><input name="fileCSV" type="file" id="fileCSV" style=" width: 100%;"></td>
    </tr>
    <tr><td>&nbsp;</td> <td>&nbsp;</td></tr>
    <tr>
        <td colspan="2" align="center"><input type="button" id="btnSubmit" style="border: 1px #788480 solid; width: 120px; height: 25px;" value="Import File CSV"></td>
    </tr>
  </table>
</body>
</html>