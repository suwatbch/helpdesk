<?php
    $page = (int)$_REQUEST["page"];
    $total_page = ceil($total_row/$page_size);

    if ($page == 0){
        $page = 1;
    }else if ($page > $total_page){
        $page = $total_page;
    }

     function get_first_reccord($page, $page_size){
        return ($page -1) * $page_size + 1;
    }
?>
<script type="text/javascript">
    function page_onkeypress(evt){
        evt = (evt) ? evt : window.event
        var charCode = (evt.which) ? evt.which : evt.keyCode
        if (charCode > 31 && (charCode < 48 || charCode > 57)){
            return false;
        }else if (charCode == 13){
            var page = parseInt(document.getElementById("goto_page").value);
            goto_page(page);
        }

        return true;
    }

    function goto_page(page){
        var total_page = parseInt(document.getElementById("total_page").value)

        if (page > 0 && total_page > 0){
            if (page > total_page){
                page = total_page;
            }

            document.getElementById("page").value = page;

            //var frm = document.forms[0];
            //frm.action = "http://<?//=$_SERVER["HTTP_HOST"].$_SERVER["PHP_SELF"]?>";
            //frm.action = "";
            //frm.submit();
            page_submit("?action=<?=$_SESSION["current_action"] ?>", "<?=$_REQUEST["action_name"]?>")
        }
    }

    function next_page(){
        var page = parseInt(document.getElementById("page").value);
        var total_page = parseInt(document.getElementById("total_page").value);

        if (page < total_page){
            goto_page(page + 1);
        }
    }

    function prev_page(){
        var page = parseInt(document.getElementById("page").value);

        if (page > 1){
            goto_page(page - 1);
        }
    }

    function first_page(){
        var page = parseInt(document.getElementById("page").value);
        if (page > 1){
            goto_page(1);
        }
    }

    function last_page(){
        var page = parseInt(document.getElementById("page").value);
        var total_page = parseInt(document.getElementById("total_page").value);
        if (page < total_page){
            goto_page(total_page);
        }
    }
</script>
<?php
    if ($total_page == 0){
        $page = 0;
    }
?>
<table border="0" cellpadding="0" cellspacing="0" width="100%" style="position: relative; height: 20px;">
    <tr>
        <td align="right" valign="middle" style="font-size: 12px;">
            <img src="<?=$application_path_images?>/start_off.png" style="cursor: pointer;" align="absmiddle" alt="First Page" onclick="return first_page();"/><img src="<?=$application_path_images?>/previous_off.png" style="cursor: pointer;" align="absmiddle" alt="Previous Page" onclick="return prev_page();"/>
            <input name="goto_page" id="goto_page" type="text" size="4" maxlength="4" style="text-align: center;" onkeypress="return page_onkeypress(event)" value="<?=$page?>"/> / <?=$total_page?>
            <img src="<?=$application_path_images?>/next.png" style="cursor: pointer;" align="absmiddle" alt="Next Page" onclick="return next_page();"/><img src="<?=$application_path_images?>/end.png" style="cursor: pointer;" align="absmiddle" alt="Last Page" onclick="return last_page();"/>
        </td>
    </tr>
</table>
<input type="hidden" name="page" id="page" value="<?=$page?>"/>
<input type="hidden" name="total_page" id="total_page" value="<?=$total_page?>"/>
