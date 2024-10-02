<?php
    include_once "../../include/function.php";
    include_once "../../include/error_message.php";
    include_once "../../include/class/user_session.class.php";
    include_once "../../include/class/util/strUtil.class.php";
    include_once "../../include/class/util/dateUtil.class.php";
    include_once "../../include/class/db/db.php";
    include_once "../../include/class/model/menu.class.php";
    include_once "../../include/class/dropdown.class.php";
    include_once "../../include/handler/action_handler.php";

    function unspecified() {
        global $db, $menu;

        $menu_id = $_REQUEST["menu_id"];

        if (strUtil::isNotEmpty($menu_id)){
            $m = new menu($db);
            $menu = $m->getById($menu_id);
        }
    }

    function finalize(){
        global $db, $menu, $dd_parents;

        $dd_parents = dropdown::loadMenu($db, "ref_menu_id", "style=\"width: 100%;\"", $menu["ref_menu_id"]);

        $db->close();
    }

    function save(){
        global $db, $menu;

        # get input
        $menu = array(
            "menu_id" => $_REQUEST["menu_id"]
            , "menu_code" => $_REQUEST["menu_code"]
            , "menu_name" => $_REQUEST["menu_name"]
            , "ref_menu_id" => strUtil::nvl($_REQUEST["ref_menu_id"], "NULL")
            , "href" => $_REQUEST["href"]
            , "icon" => $_REQUEST["icon"]
            , "status" => $_REQUEST["status"]
            , "created_by" => $_REQUEST["created_by"]
            , "created_date" => dateUtil::date_ymdhms($_REQUEST["created_date"])
            , "modified_by" => $_REQUEST["modified_by"]
            , "modified_date" => dateUtil::date_ymdhms($_REQUEST["modified_date"])
            , "action_date" => dateUtil::current_date_time()
            , "action_by" => user_session::get_sale_id()
        );
            # save
            $db->begin_transaction();

            $m = new menu($db);

            if (strUtil::isEmpty($menu["menu_id"])){
                $result = $m->insert($menu);
            } else {
                $result = $m->update($menu);
            }

            $db->end_transaction($result);

            if ($result){
                $menu = $m->getById($menu["menu_id"]);
                alert_message_simple("Save Completed !! ", "back_master();");
            }
    }
?>
