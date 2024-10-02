<script type="text/javascript">
    $(function(){
         $("<div id=\"dialog\"  title=\"Member\"></div>")
        .appendTo("form")
        .dialog({
            width: 625
            , height: 400
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

            $("#ifr").attr("src", "member_dialog.php");
            $("#dialog").dialog("open");
        });

        bind_action();
    });

    function bind_action(){
        $("img[alt=Delete]").click(function(){
            if (confirm_delete()){
                $(this).parent().parent().remove();

                var index = 1;
                $("#tblmember tbody tr").each(function(){
                    $(this).find("td").eq(0).html(index++);
                });
            }
        });
    }

    function getMembers(){
        var member = "";
        $("#tblmember tr").each(function(){
            if (member != "") {
                member += ", ";
            }

            member += $(this).attr("value");
        });

        return member;
    }
    
    function member_onselected(member){
        var index = $("#tblmember tbody tr").length;
        for (var i = 0; i < member.length; i++){
            var content = "";
            content += "<tr value=\"" + member[i].sale_id + "\">\n";
            content += "   <td width=\"5%\" align=\"center\">" + (++index) + "</td>\n";
            content += "   <td width=\"15%\" align=\"center\">" + member[i].employee_code + "</td>\n";
            content += "   <td width=\"52%\" align=\"left\">" + member[i].employee_name + "</td>\n";
            content += "   <td width=\"20%\" align=\"left\">" + member[i].position_name + "</td>\n";
            content += "   <td width=\"8%\" align=\"center\"><img src=\"../../images/close_inline.png\" alt=\"Delete\" style=\"cursor: pointer;\"/></td>\n";
            content += "</tr>\n";

            $("#tblmember tbody").append(content);
        }

        $("img[alt=Delete]").unbind("click");
        bind_action();

        $("#ifr").attr("src", "blank.php");
        $("#dialog").dialog("close");
    }
</script>
<div style="text-align: right; margin: 0px 22px 2px 0px;">
    <input type="button" id="add_member" value="Add Member" class="input-button" style="width: 100px;"/>
</div>
<table width="764px" border="0" cellpadding="0" cellspacing="1" class="data-table">
    <thead>
        <tr>
            <td width="5%" align="center">No.</td>
            <td width="15%" align="center">Employee Code</td>
            <td width="52%" align="left">Sale Name</td>
            <td width="20%" align="left">Position</td>
            <td width="8%" align="center">Action</td>
        </tr>
    </thead>
</table>
<div style="overflow: auto; height: 220px; ">
    <table id="tblmember" width="764px" border="0" cellpadding="0" cellspacing="1" class="data-table">
        <tbody>
            <?php
                if (count($access_group["member"]) > 0){
                    $index = 1;
                    foreach ($access_group["member"] as $m) {
            ?>
            <tr value="<?=$m["sale_id"]?>">
                <td width="5%" align="center"><?=$index++?></td>
                <td width="15%" align="center"><?=$m["employee_code"]?></td>
                <td width="52%" align="left"><?=$m["sale_name"]?></td>
                <td width="20%" align="left"><?=$m["position_name"]?></td>
                <td width="8%" align="center"><img src="../../images/close_inline.png" alt="Delete" style="cursor: pointer;"/></td>
            </tr>
            <?php
                    }
                }
            ?>
        </tbody>
    </table>
</div>
