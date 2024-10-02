<?php
/**
 * @filesource modules/eleave/views/totalreport.php
 *
 * @copyright 2016 Goragod.com
 * @license https://www.kotchasan.com/license/
 *
 * @see https://www.kotchasan.com/
 */

namespace Eleave\Totalreport;

use Kotchasan\DataTable;
use Kotchasan\Date;
use Kotchasan\Http\Request;
use Kotchasan\Language;

/**
 * module=totalreport
 *
 * @author Goragod Wiriya <admin@goragod.com>
 *
 * @since 1.0
 */
class View extends \Gcms\View
{
    /**
     * @var object
     */
    private $leavetype;
    /**
     * @var array
     */
    private $leave_period;
    /**
     * @var int
     */
    private $days = 0;

    /**
     * แสดงรายการลา (แอดมิน)
     *
     * @param Request $request
     * @param array $params
     * @param array $login
     *
     * @return string
     */
    public function render(Request $request, $params, $login)
    {
        // Leave type
        $this->leavetype = \Eleave\Leavetype\Model::init();
        $this->leave_period = Language::get('LEAVE_PERIOD');
        // URL สำหรับส่งให้ตาราง
        $uri = $request->createUriWithGlobals(WEB_URL.'index.php');
        // ตาราง
        $table = new DataTable(array(
            /* Uri */
            'uri' => $uri,
            /* Model */
            'model' => \Eleave\Totalreport\Model::toDataTable($params),
            /* รายการต่อหน้า */
            'perPage' => $request->cookie('eleaveTotalreport_perPage', 30)->toInt(),
            /* เรียงลำดับ */
            'sort' => $request->cookie('eleaveTotalreport_sort', 'start_date DESC')->toString(),
            /* ฟังก์ชั่นจัดรูปแบบการแสดงผลแถวของตาราง */
            'onRow' => array($this, 'onRow'),
            /* ฟังก์ชั่นแสดงผล Footer */
            'onCreateFooter' => array($this, 'onCreateFooter'),
            /* คอลัมน์ที่ไม่ต้องแสดงผล */
            'hideColumns' => array('id', 'start_period', 'end_date', 'end_time', 'end_period', 'member_id', 'times'),
            /* คอลัมน์ที่สามารถค้นหาได้ */
            'searchColumns' => array('name'),
            /* ตัวเลือกการแสดงผลที่ส่วนหัว */
            'filters' => array(
                array(
                    'name' => 'from',
                    'type' => 'date',
                    'text' => '{LNG_from}',
                    'value' => $params['from']
                ),
                array(
                    'name' => 'to',
                    'type' => 'date',
                    'text' => '{LNG_to}',
                    'value' => $params['to']
                ),
            ),
            /* ส่วนหัวของตาราง และการเรียงลำดับ (thead) */
            'headers' => array(
                'create_date' => array(
                    'text' => '{LNG_Transaction date}',
                    'sort' => 'create_date'
                ),
                'name' => array(
                    'text' => '{LNG_Name}',
                    'sort' => 'name'
                ),
                'leave_id' => array(
                    'text' => '{LNG_Leave type}',
                    'sort' => 'leave_id'
                ),
                'start_date' => array(
                    'text' => '{LNG_Date of leave}',
                    'sort' => 'start_date'
                ),
                'days' => array(
                    'text' => '{LNG_Date time}',
                    'class' => 'left',
                    'sort' => 'days'
                ),
                'start_time' => array(
                    'text' => '{LNG_Time}',
                    'class' => 'left',
                    'sort' => 'start_time'
                ),
                'communication' => array(
                    'text' => '{LNG_Communication}',
                    'sort' => 'communication'
                ),
                'detail' => array(
                    'text' => '{LNG_Detail}'
                ),
                'status' => array(
                    'text' => '{LNG_Status}',
                    'class' => 'left',
                    'sort' => 'status'
                ),
                'cancel_date' => array(
                    'text' => 'วันที่ยกเลิก',
                    'sort' => 'cancel_date'
                ),
            ),
        ));
        $params['sort'] = $table->sort;
        $table->actions[] = array(
            'class' => 'button icon-excel orange',
            'text' => '{LNG_Download} CSV (UTF-8)',
            'href' => 'export.php?module=eleave-export&amp;typ=csv&amp;'.http_build_query($params),
            'target' => 'export'
        );
        // save cookie
        setcookie('eleaveTotalreport_perPage', $table->perPage, time() + 2592000, '/', HOST, HTTPS, true);
        setcookie('eleaveTotalreport_sort', $table->sort, time() + 2592000, '/', HOST, HTTPS, true);
        // คืนค่า HTML
        return $table->render();
    }

    /**
     * จัดรูปแบบการแสดงผลในแต่ละแถว
     *
     * @param array  $item ข้อมูลแถว
     * @param int    $o    ID ของข้อมูล
     * @param object $prop กำหนด properties ของ TR
     *
     * @return array
     */
    public function onRow($item, $o, $prop)
    {
        $this->days += $item['days'];
        $this->times += $item['times'];
        $item['create_date'] = Date::format($item['create_date'], 'd M Y');
        $item['leave_id'] = $this->leavetype->get($item['leave_id']);
        if ($item['start_date'] == $item['end_date']) {
            $item['start_date'] = Date::format($item['start_date'], 'd M Y').' '.$this->leave_period[$item['start_period']];
        } else {
            $item['start_date'] = Date::format($item['start_date'], 'd M Y').' '.$this->leave_period[$item['start_period']].($item['start_period'] ? '' : ' - '.Date::format($item['end_date'], 'd M Y').' '.$this->leave_period[$item['end_period']]);
        }
        $item['days'] = \Gcms\Functions::gettimeleave($item['days'],$item['times']);
        $item['start_time'] = \Gcms\Functions::showtime($item['start_time'],$item['end_time']);
        $item['status'] = self::leave_status($item['status']) ? '<span class=status'.self::status_adap($item['status']).'>{LNG_'.self::leave_status($item['status']).'}</span>' : '';
        $item['cancel_date'] = Date::format($item['cancel_date'], 'd M Y');
        return $item;
    }

    /**
     * ฟังก์ชั่นสร้างแถวของ footer
     * 
     * @return string
     */
    public function onCreateFooter()
    {
        return '<tr><td></td><td class=right colspan=4>{LNG_Total}</td><td class=left>'.\Gcms\Functions::getttotalleave($this->days,$this->times).'</td><td colspan="2"></td></tr>';
    }
    
    /**
     * @param int $id
     * @return string
     */
    public static function leave_status($id)
    {
        $res = "";
        $status = Language::get('LEAVE_STATUS');
        foreach ($status as $k => $value) {
            if ($k == $id) {
                $res = $value;
                break;
            }
        }
        return $res;
    }

    /**
     * @param int $id
     * @return string
     */
    public static function status_adap($id)
    {
        $res = 0;
        if ($id == 4){
            $res = 1;
        } else if ($id == 1) {
            $res = 0;
        } else {
            $res = 2;
        }
        return $res;
    }
}
