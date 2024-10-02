<?php
    include_once "../include/class/util/strUtil.class.php";
    include_once "../include/class/util/dateUtil.class.php";
    include_once "../include/class/db/db.php";
    include_once "../include/class/model/activity.class.php";
    include_once "../include/handler/action_handler.php";

    $activity_id = $_REQUEST["id"];

    $activity = new activity($db);
    $activity = $activity->getById($activity_id);

    $db->close();
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/strict.dtd">
<html>
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
        <title>Activity</title>
        <link type="text/css" rel="stylesheet" href="../include/css/cctstyles.css"/>
        <style type="text/css">
            tr{
                height: 20px;
            }
            
            td{
                padding-left: 2px;
            }

            td:first-child {
                width: 130px;
                background-color: #CCCCFF;
                font-weight: bold;
            }

            td+td{
                background-color: #E7E8DF;
            }
        </style>
        <script type="text/javascript" src="../function/function.js"></script>
    </head>
    <body>
        <table width="100%" border="0" cellpadding="0" cellspacing="1">
            <tr>
                <td>Customer</td>
                <td><?=$activity["customer_name"]?></td>
            </tr>
            <tr>
                <td>Project Name</td>
                <td><?=$activity["project_name"]?></td>
            </tr>
            <tr>
                <td>Activity Date</td>
                <td>
                    <?=dateUtil::date_dmy($activity["activity_date"])?>
                     Time
                    <?php
                        if (strUtil::isNotEmpty($activity["start_time"]) && strUtil::isNotEmpty($activity["end_time"])){
                            $d1 = $activity["activity_date"].str_replace(":", "", $activity["start_time"]);
                            $d2 = $activity["activity_date"].str_replace(":", "", $activity["end_time"]);
                            $diff = dateUtil::dateDiff($d1, $d2, dateUtil::DIFF_IN_MINUTES);
                            $h = floor($diff / 60);
                            $m = $diff % 60;

                            if ($h > 0) $duration .= "$h Hours ";
                            if ($m > 0) $duration .= "$m Minutes";
                            if ($duration != "") $duration = " (".trim($duration).")";

                            echo $activity["start_time"]." - ".$activity["end_time"].$duration;

                        } else {
                            echo " : ".$activity["duration_time"]." ".$activity["unit_of_time"];
                        }
                    ?>
                </td>
            </tr>
            <tr>
                <td>Place</td>
                <td><?=htmlspecialchars($activity["place"])?></td>
            </tr>
            <tr>
                <td>Objective</td>
                <td><?=htmlspecialchars($activity["objective_name"])?></td>
            </tr>
            <tr>
                <td>Next Step</td>
                <td><?=htmlspecialchars($activity["next_step_name"])?></td>
            </tr>
            <tr>
                <td>Contact Person</td>
                <td><?=htmlspecialchars($activity["contact_person"])?></td>
            </tr>
            <tr>
                <td valign="top">Activities</td>
                <td valign="top"><div style="height: 100px; overflow: auto;"><?=str_replace("\n", "<br>", htmlspecialchars($activity["activity"]))?></div></td>
            </tr>
            <tr>
                <td>Expenses</td>
                <td><?=$activity["expenes"]?></td>
            </tr>
            <tr>
                <td>Sent Date</td>
                <td>
                    <?php
                        $sent_date = $activity["sent_date"];
                        $activity_date = $activity["activity_date"];

                        if (substr($sent_date, 0, 8) > $activity_date){
                            if (date("Ymd", strtotime("$activity_date +1day")) == date("Ymd", strtotime($sent_date)) && substr($sent_date, 8, 2) < "09") {
                                $desc = "";
                            } else {
                                $desc = " (late ".number_format(dateUtil::dateDiff($sent_date, $activity_date))." days)";
                            }                            
                        }

                         echo dateUtil::date_dmyhms($sent_date).$desc;
                    ?>
                </td>
            </tr>
            <tr>
                <td>Created By</td>
                <td><?=$activity["created_by"]?></td>
            </tr>
            <tr>
                <td>Created Date</td>
                <td><?=dateUtil::date_dmyhms($activity["created_date"])?></td>
            </tr>
            <tr>
                <td>Modified By</td>
                <td><?=$activity["modified_by"]?></td>
            </tr>
            <tr>
                <td>Modified Date</td>
                <td><?=dateUtil::date_dmyhms($activity["modified_date"])?></td>
            </tr>
        </table>
    </body>
</html>