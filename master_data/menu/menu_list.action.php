<?php
    include_once "../../include/class/db/db.php";
    include_once "../../include/class/util/strUtil.class.php";
    include_once "../../include/class/model/menu.class.php";
    include_once "../../include/handler/action_handler.php";

    function unspecified() {
        search();
    }

    function finalize(){
        global $db;
        $db->close();
    }

    function delete(){
        global $db;

        $menu_id = $_GET["menu_id"];
        if (strUtil::isNotEmpty($menu_id)){
            $db->begin_transaction();

            $p = new menu($db);
            $result = $p->delete($menu_id);

            $db->end_transaction($result);
        }

        unspecified();
    }
    
    function restore(){
        global $db;

        $objective = $_GET["menu_id"];
        if (strUtil::isNotEmpty($objective)){
            $db->begin_transaction();

            $p = new menu($db);
            $result = $p->restore_master($objective);

            $db->end_transaction($result);
        }

        unspecified();
    }

    function search(){
        global $db, $total_row, $menus;

        $p = new menu($db);

        $page = strUtil::nvl($_REQUEST["page"], "1");
        $menus = $p->search($cratiria, $page);

        $total_row = $menus["total_row"];
        $menus = $menus["data"];
    }
?>
