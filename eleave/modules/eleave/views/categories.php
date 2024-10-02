<?php
/**
 * @filesource modules/eleave/views/categories.php
 *
 * @copyright 2016 Goragod.com
 * @license https://www.kotchasan.com/license/
 *
 * @see https://www.kotchasan.com/
 */

namespace Eleave\Categories;

use Kotchasan\DataTable;
use Kotchasan\Form;
use Kotchasan\Html;
use Kotchasan\Http\Request;
use Kotchasan\Language;

/**
 * module=eleave-categories
 *
 * @author Goragod Wiriya <admin@goragod.com>
 *
 * @since 1.0
 */
class View extends \Gcms\View
{
    /**
     * หมวดหมู่แยกตามภาษา
     *
     * @var bool
     */
    private $multiple_language = false;
    /**
     * @var array
     */
    private $installedlanguage;

    /**
     * รายการหมวดหมู่
     *
     * @param Request $request
     * @param array $params
     *
     * @return string
     */
    public function render(Request $request, $params)
    {
        // ภาษาที่ติดตั้ง
        $this->installedlanguage = Language::installedLanguage();
        // form
        $form = Html::create('form', array(
            'id' => 'setup_frm',
            'class' => 'setup_frm',
            'autocomplete' => 'off',
            'action' => 'index.php/eleave/model/categories/submit',
            'onsubmit' => 'doFormSubmit',
            'ajax' => true,
            'token' => true
        ));
        $fieldset = $form->add('fieldset', array(
            'titleClass' => 'icon-menus',
            'title' => '{LNG_Details of} '.$params['categories'][$params['type']]
        ));
        // ตารางหมวดหมู่
        $table = new DataTable(array(
            /* ข้อมูลใส่ลงในตาราง */
            'datas' => \Eleave\Categories\Model::toDataTable($params['type'], $this->multiple_language),
            /* ฟังก์ชั่นจัดรูปแบบการแสดงผลแถวของตาราง */
            'onRow' => array($this, 'onRow'),
            'border' => true,
            'responsive' => true,
            'pmButton' => true,
            'showCaption' => false,
            'headers' => array(
                'category_id' => array(
                    'text' => '{LNG_ID}'
                )
            )
        ));
        if (!$this->multiple_language) {
            $table->headers['topic'] = array(
                'text' => '{LNG_Detail}'
            );
        }
        $fieldset->add('div', array(
            'class' => 'item',
            'innerHTML' => $table->render()
        ));
        $fieldset = $form->add('fieldset', array(
            'class' => 'submit'
        ));
        // submit
        $fieldset->add('submit', array(
            'class' => 'button save large icon-save',
            'value' => '{LNG_Save}'
        ));
        // type
        $fieldset->add('hidden', array(
            'id' => 'type',
            'value' => $params['type']
        ));
        // คืนค่า HTML
        return $form->render();
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
        $item['category_id'] = Form::text(array(
            'name' => 'category_id[]',
            'labelClass' => 'g-input',
            'size' => 2,
            'value' => $item['category_id']
        ))->render();
        if (isset($item['topic'])) {
            $item['topic'] = Form::text(array(
                'name' => 'topic[]',
                'labelClass' => 'g-input',
                'value' => $item['topic']
            ))->render();
        } else {
            foreach ($this->installedlanguage as $lng) {
                $item[$lng] = Form::text(array(
                    'name' => $lng.'[]',
                    'labelClass' => 'g-input',
                    'value' => isset($item[$lng]) ? $item[$lng] : $item[''],
                    'style' => 'background-image:url(../language/'.$lng.'.gif)'
                ))->render();
            }
        }
        return $item;
    }
}
