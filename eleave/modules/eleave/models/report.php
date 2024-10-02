<?php
/**
 * @filesource modules/eleave/models/report.php
 *
 * @copyright 2016 Goragod.com
 * @license https://www.kotchasan.com/license/
 *
 * @see https://www.kotchasan.com/
 */

namespace Eleave\Report;

use Gcms\Login;
use Kotchasan\Database\Sql;
use Kotchasan\File;
use Kotchasan\Http\Request;
use Kotchasan\Language;

/**
 * module=eleave-report
 *
 * @author Goragod Wiriya <admin@goragod.com>
 *
 * @since 1.0
 */
class Model extends \Kotchasan\Model
{
    /**
     * Query ข้อมูลสำหรับส่งให้กับ DataTable
     *
     * @param array $params
     *
     * @return \Kotchasan\Database\QueryBuilder
     */
    public static function toDataTable($params)
    {
        $setsionlogin = $_SESSION['login'];
        $where = array(
            array('F.status', $params['status'])
        );
        if ($setsionlogin['status'] != 1) {
            // $where[] = array('F.department', $setsionlogin['department'][0]);
            if ($params['status']==0) {
                $sql = "(F.`member_id_m1`='$setsionlogin[id]' AND F.`status_m1`='$params[status]')";
            } else {
                $sql = "(F.`member_id_m1`='$setsionlogin[id]' AND (F.`status_m1`='$params[status]' OR F.`status`='$params[status]'))";
            }
            $sql .= " OR (F.`member_id_m2`='$setsionlogin[id]' AND F.`status_m2`='$params[status]' AND F.`status_m1`>'$params[status]' AND F.`status`='$params[status]')";
            $where[] = Sql::create($sql);
        }
        if (!empty($params['department'])) {
            $where[] = array('F.department', $params['department']);
        }
        if (!empty($params['member_id'])) {
            $where[] = array('F.member_id', $params['member_id']);
        }
        if (!empty($params['leave_id'])) {
            $where[] = array('F.leave_id', $params['leave_id']);
        }
        if (!empty($params['from']) || !empty($params['to'])) {
            if (empty($params['to'])) {
                $sql = "(F.`start_date`>='$params[from]')";
                $sql .= " OR ('$params[from]' BETWEEN F.`start_date` AND F.`end_date`)";
            } elseif (empty($params['from'])) {
                $sql = "(F.`start_date`<='$params[to]')";
                $sql .= " OR ('$params[to]' BETWEEN F.`start_date` AND F.`end_date`)";
            } else {
                $sql = "(F.`start_date`>='$params[from]' AND F.`start_date`<='$params[to]')";
                $sql .= " OR ('$params[from]' BETWEEN F.`start_date` AND F.`end_date` AND '$params[to]' BETWEEN F.`start_date` AND F.`end_date`)";
            }
            $where[] = Sql::create($sql);
        }
        $res = static::createQuery()
            ->select('F.id', 'F.create_date', 'U.name', 'F.leave_id', 'F.start_date',
                'F.days', 'F.start_time', 'F.end_time', 'F.times', 'F.start_period', 'F.end_date', 'F.end_period', 'F.member_id', 'F.communication', 'F.detail')
            ->from('leave_items F')
            ->join('user U', 'LEFT', array('U.id', 'F.member_id'))
            ->where($where);

        return $res;
    }

    /**
     * รับค่าจาก action
     *
     * @param Request $request
     */
    public function action(Request $request)
    {
        $ret = [];
        // session, referer, member
        if ($request->initSession() && $request->isReferer() && $login = Login::isMember()) {
            // ค่าที่ส่งมา
            $action = $request->post('action')->toString();
            // id ที่ส่งมา
            if (preg_match_all('/,?([0-9]+),?/', $request->post('id')->toString(), $match)) {
                if ($action == 'detail') {
                    // แสดงรายละเอียดคำขอลา
                    $index = \Eleave\View\Model::get((int) $match[1][0]);
                    if ($index) {
                        $ret['modal'] = Language::trans(\Eleave\View\View::create()->render($index));
                    }
                } elseif ($action == 'delete' && Login::checkPermission($login, 'can_approve_eleave')) {
                    // ลบรายการที่ยังไม่ได้อนุมัติ
                    $where = array(
                        array('id', $match[1])
                    );

                    $where[] = array('status', '!=', 1);
                    $where[] = array('status', '!=', 2); // แก้ไขเพิ่มเติม
                    $where[] = array('status', '!=', 0); // แก้ไขเพิ่มเติม
                    // if ($login['status'] != 1) {
                    //     // แอดมิน ลบได้ทุกรายการ
                    //     $where[] = array('status', '!=', 1);
                    // }
                    $query = $this->db()->createQuery()
                        ->select('id')
                        ->from('leave_items')
                        ->where($where);
                    $ids = [];
                    foreach ($query->execute() as $item) {
                        $ids[] = $item->id;
                        // ลบไฟล์แนบ
                        File::removeDirectory(ROOT_PATH.DATA_FOLDER.'eleave/'.$item->id.'/');
                    }
                    if (!empty($ids)) {
                        // ลบ database
                        $this->db()->delete($this->getTableName('leave_items'), array('id', $ids), 0);
                        // log
                        \Index\Log\Model::add(0, 'eleave', 'Delete', '{LNG_Delete} {LNG_Report} {LNG_Request for leave} ID : '.implode(', ', $ids), $login['id']);
                    }
                    // reload
                    $ret['location'] = 'reload';
                }
            }
        }
        if (empty($ret)) {
            $ret['alert'] = Language::get('Unable to complete the transaction');
        }
        // คืนค่าเป็น JSON
        echo json_encode($ret);
    }
}
