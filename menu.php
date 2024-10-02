
<!--        <link type="text/css" rel="stylesheet" href="include/css/cctstyles.css"/>
        <script type="text/javascript" src="include/js/function.js"></script>
        <script type="text/javascript" src="include/js/tree-menu/js/dtree.js"></script>
        <script type="text/javascript" src="include/js/tree-menu/js/dtree_dyn.js"></script>
        <script type="text/javascript" src="include/js/tree-menu/js/dtree_menu.js"></script>-->
<link type="text/css" rel="stylesheet" href="include/css/cctstyles.css"/>
<script type="text/javascript" src="include/js/tree-menu/js/dtree.js"></script>
<script type="text/javascript" src="include/js/tree-menu/js/dtree_dyn.js"></script>
<script type="text/javascript" src="include/js/tree-menu/js/dtree_menu.js"></script>
<!--<script type="text/javascript" src="include/js/jquery/jquery-1.5.1.js"></script>-->

<style type="text/css">
    body, html{
        background-color: #FFFFFF/*#EEE9E9*/;
    }

    .divmenu{
        padding: 5px 0px 0px 5px;
    }
</style>
<div class="divmenu">
<script type="text/javascript">
        tpathPrefix_img = "<?=$application_path_images?>/";
        tWorkPath = "<?="$application_path_js/tree-menu/js/"?>";


<?php
    include_once "include/config.inc.php";
    include_once "include/class/db/db.php";
    include_once "include/class/user_session.class.php";
    include_once "include/class/util/strUtil.class.php";
    include_once "include/class/model/menu.class.php";
    include_once "include/class/model/incident_list.class.php";


    $menu = new menu($db);
    $menu = $menu->listByTree(user_session::get_user_id());
//            $db->close();

//            $div = drawMenu($menu);

//             $div = "<div class=\"divmenu\">\n"
//                     . "   <script type=\"text/javascript\">\n"
//                     . "      tpathPrefix_img = \"$application_path_images/\";\n"
//                     . "      tWorkPath = \"$application_path_js/tree-menu/js/\";\n"
//                     . "      tmenuItems = [".tree_menu($menu)."];\n"
//                     . "      dtree_init();\n"
//                    . "   </script>\n"
//                    . "</div>";

    $div = tree_menu($menu);
//            echo $div;

    function tree_menu($menu, $level = 0){
        if (count($menu) > 0){
            foreach ($menu as $m) {
                if (strUtil::isEmpty($m["ref_menu_id"])){
                    $item .= "[\"+&nbsp;{$m["menu_name"]}\",\"\", \"".strUtil::nvl($m["icon"], "blank.gif")."\", \"\", \"\", \"\", \"\", \"\", \"\", \"\", ],\n";
                } else {
                    if ($m["ref_menu_id"] == '43'){
                        $mode = "";
                        $text = split("mode=", $m["href"]);
                        if ($text[1]){
                            $mode = $text[1];
                        }

                        $menu_id = "inc_".$mode;
                        $menu_name = $m["menu_name"]."<span id='$menu_id'></span>";

//                                $menu_name = countIncident($mode);
//                                $menu_name = $m["menu_name"]."[".$menu_name."]";

                        $item .= "[\"".str_pad("", $level, "|")."{$menu_name}\",\"{$m["href"]}\", \"".strUtil::nvl($m["icon"], "pin_blue.png")."\", \"\", \"\", \"\", \"main\", \"0\", \"\", \"\", ],\n";
                    }else{
                        $item .= "[\"".str_pad("", $level, "|")."{$m["menu_name"]}\",\"{$m["href"]}\", \"".strUtil::nvl($m["icon"], "pin_blue.png")."\", \"\", \"\", \"\", \"main\", \"0\", \"\", \"\", ],\n";
                    }
                }

                $item .= tree_menu($m["child_menu"], $level + 1);
            }
        }

        return $item;
    }



    function countIncident($mode){
        global $db, $incident_list, $count;

        $cratiria = array(
             "user_id" => user_session::get_user_id()
            ,"user_subgrp_id" => user_session::get_user_subgrp_id() 
            ,"user_subgrp_id_spec" => user_session::get_subgrp_id_spec_arr() 
            ,"mode" => $mode
        );

        $incident_list = new incident_list($db);
        $count = $incident_list->search($cratiria);

        if ($count){
            return $count["total_row"];
        }else{
            return 0;
        }

    }
?>
    tmenuItems = [<?=$div?>];
    dtree_init();  


    function incident_count(inc_mode){
        $("#inc_" + inc_mode).html("<img src=\"images/loading_tiny.gif\" align=\"absmiddle\"/>");
        
        $.ajax({
            type: "GET"
           , url: "menu_main_incident_count.php"
           , data: "mode=" + inc_mode
           , success: function(data){
//               alert("#inc_" + inc_mode + " : " + data);
               if (data != "")
               {
                    $("#inc_" + inc_mode).html(" [" + data + "]");
               }
               else
               {
                   $("#inc_" + inc_mode).html("");
               }
            }
        });
    }

    function refresh_incident()
    {
        incident_count("1");//My Incident
        incident_count("2");//My Group
        incident_count("3");//My Group(unassigned)
        incident_count("4");//All Group(unassigned)
        incident_count("");//All Group
    }

    $(document).ready(function(){
        refresh_incident();
        setTimeout('refresh_incident();', 60000);//1000 = 1 sec.
    });
</script>
</div>
   