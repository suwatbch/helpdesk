<?php
    include_once "../../include/class/db/db.php";
    include_once "../../include/function.php";
    include_once "../../include/class/util/strUtil.class.php";
    include_once "../../include/class/model/access_group.class.php";

    $access_group_id = $_REQUEST["access_group_id"];

    $ag = new access_group($db);
    $permission = $ag->getPermission($access_group_id);
    
    $db->close();
?>
<html>
    <head>
        <link type="text/css" rel="stylesheet" href="../../include/css/cctstyles.css"/>
        <style type="text/css">
            html, body{
                /*background-color: #E5F2FF;*/
            }

            td{
                font-size: 12px;
            }
        </style>

        <script type="text/javascript" src="../../include/js/jquery/jquery-1.5.1.js"></script>
        <script type="text/javascript" src="../../include/js/tree-view/js/ua.js"></script>
        <script type="text/javascript" src="../../include/js/tree-view/js/ftiens4.js"></script>
        <script type="text/javascript">
            function getValues(){
                var arr = new Array();
                $("input[type=checkbox]").each(function(){
                    if ($(this).is(":checked")){
                        arr.push($(this).val());
                    }
                });
                return arr;
            }
        </script>
    </head>
    <body>
    <br><br>
   
        <a style="display: none" href="http://www.treemenu.net/"></a>
        <script type="text/javascript">
            ICONPATH = "<?=$application_path_js?>/tree-view/img/";
            USETEXTLINKS = 1;
            STARTALLOPEN = 0;
            HIGHLIGHT = 0;
            PRESERVESTATE = 1;
            USEICONS = 0;
            BUILDALL = 1;

            foldersTree = gFld("", "");
            foldersTree.treeID = "checkboxTree";

            var aux1 = null;
            var newObj = null;

            <?php
                foreach ($permission as $p) {
                    if (strUtil::isEmpty($p["ref_menu_id"])){
            ?>
            aux1 = insFld(foldersTree, gFld("<input type=\"checkbox\" id=\"chk<?=$p["menu_id"]?>\" style=\"border: 0px;\" value=\"<?=$p["menu_id"]?>\" <?=checked("1", $p["has_perm"])?>/><b><?=$p["menu_code"]." : ".$p["menu_name"]?></b>", ""));
            <?php
                    } else {
            ?>
            newObj = insDoc(aux1, gLnk("R", "<?=$p["menu_code"]." : ".$p["menu_name"]?>", "javascript:parent.op()"));
            newObj.prependHTML = "<td valign=\"middle\"><input type=\"checkbox\" id=\"chk<?=$p["menu_id"]?>\" ref=\"<?=$p["ref_menu_id"]?>\" style=\"border: 0px;\" value=\"<?=$p["menu_id"]?>\" <?=checked("1", $p["has_perm"])?>/></td>";
            <?php
                    }
                }
            ?>
            initializeDocument();

            $(document).ready(function(){
                $(":checkbox").filter(function(){
                    return $(this).attr("ref") == undefined;
                }).change(function(){
                    var checked = $(this).attr("checked");
                    $("input[ref=" +  $(this).val() + "]").each(function(){
                        $(this).attr("checked", checked)
                    });
                });
            });
        </script>
    </body>
</html>
