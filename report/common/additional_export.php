<?php
include_once '../../include/config.inc.php';
include_once "../../include/class/user_session.class.php";

?>
<br><br>
<div name="additional">
    <span><b><? echo $subject_add;?></b></span><br><br><br>
    <table>
        <tr><td colspan="5" style="width: 90%; background-color: #ffc4c4; font-weight: bold; font-size: 12.5px; border: gray solid thin; padding-left: 10px;">ด้านพัฒนาบุคคลากร CBS</td></tr>
    </table><br>
    <table style="border: gray solid thin; color: black; font-size: 12px;" width="90%">
        <tr style="border: gray solid thin;">
            <th style="border: gray solid thin; background-color: #C3C7D3; color: #444444;" width="5%">ลำดับ</th>
            <th style="border: gray solid thin; background-color: #C3C7D3; color: #444444;" width="35%">ระบบงานที่ควรพัฒนาบุคคลากร</th>
            <th style="border: gray solid thin; background-color: #C3C7D3; color: #444444;" width="15%">% สถิติการแจ้ง SPIES ทั้งหมด</th>
            <th style="border: gray solid thin; background-color: #C3C7D3; color: #444444;" width="30%">เขตการไฟฟ้าที่ควรเข้ารับการพัฒนาบุคคลากร</th>
            <th style="border: gray solid thin; background-color: #C3C7D3; color: #444444;" width="15%">% สถิติการแจ้ง SPIES เทียบกับเขตอื่นๆ</th>
        </tr>
        <tr style="border: gray solid thin;">
            <td style="border: gray solid thin; text-align: center; vertical-align: top;"><?=nl2br($additional_text["text1"]);?></td>
            <td style="border: gray solid thin; vertical-align: top;"><?=nl2br($additional_text["text2"]);?></td>
            <td style="border: gray solid thin; text-align: center; vertical-align: top;"><?=nl2br($additional_text["text3"]);?></td>
            <td style="border: gray solid thin; vertical-align: top;"><?=nl2br($additional_text["text4"]);?></td>
            <td style="border: gray solid thin; text-align: center; vertical-align: top;"><?=nl2br($additional_text["text5"]);?></td>
        </tr>
        <tr>
            <td colspan="5" style="border: none;"><b>ข้อเสนอแนะ</b></td>
        </tr>
        <tr>
            <td colspan="5" style="width: 100%; height: auto; border: none;  vertical-align: top;"><?= nl2br($additional_text["text6"]);?></td>
        </tr>
    </table>
    <br>
    <table>
        <tr><td colspan="5" style="width: 90%; background-color: #F36C00; font-weight: bold; font-size: 12.5px; border: gray solid thin; padding-left: 10px;">ด้านพัฒนาบุคคลากร BPM</td></tr>
    </table><br>
    <table style="border: gray solid thin; color: black; font-size: 12px;" width="90%">
        <tr style="border: gray solid thin;">
            <th style="border: gray solid thin; background-color: #C3C7D3; color: #444444;" width="5%">ลำดับ</th>
            <th style="border: gray solid thin; background-color: #C3C7D3; color: #444444;" width="35%">ระบบงานที่ควรพัฒนาบุคคลากร</th>
            <th style="border: gray solid thin; background-color: #C3C7D3; color: #444444;" width="15%">% สถิติการแจ้ง SPIES ทั้งหมด</th>
            <th style="border: gray solid thin; background-color: #C3C7D3; color: #444444;" width="30%">เขตการไฟฟ้าที่ควรเข้ารับการพัฒนาบุคคลากร</th>
            <th style="border: gray solid thin; background-color: #C3C7D3; color: #444444;" width="15%">% สถิติการแจ้ง SPIES เทียบกับเขตอื่นๆ</th>
        </tr>
        <tr style="border: gray solid thin;">
            <td style="border: gray solid thin; text-align: center; vertical-align: top;"><?=nl2br($additional_text["BPM_text1"]);?></td>
            <td style="border: gray solid thin; vertical-align: top;"><?=nl2br($additional_text["BPM_text2"]);?></td>
            <td style="border: gray solid thin; text-align: center; vertical-align: top;"><?=nl2br($additional_text["BPM_text3"]);?></td>
            <td style="border: gray solid thin; vertical-align: top;"><?=nl2br($additional_text["BPM_text4"]);?></td>
            <td style="border: gray solid thin; text-align: center; vertical-align: top;"><?=nl2br($additional_text["BPM_text5"]);?></td>
        </tr>
        <tr>
            <td colspan="5" style="border: none;"><b>ข้อเสนอแนะ</b></td>
        </tr>
        <tr>
            <td colspan="5" style="width: 100%; height: auto; border: none;  vertical-align: top;"><?= nl2br($additional_text["BPM_text6"]);?></td>
        </tr>
    </table>
    <br>
    <br>
    
    <table>
        <tr><td colspan="5" style="width: 90%; background-color: #ffc4c4; font-weight: bold; font-size: 12.5px; border: gray solid thin; padding-left: 10px;">ด้านการปรับปรุง ป้องกันระบบงาน IT และกระบวนการปฎิบัติงาน CBS</td></tr>
    </table><br>
    <div style="width: 90%;">
        <table style="width: 100%; border: gray solid thin; color: black; font-size: 12px;">
            <tr style="border: gray solid thin;">
                <th style="border: gray solid thin; background-color: #C3C7D3; color: #444444;" width="5%">ลำดับ</th>
                <th style="border: gray solid thin; background-color: #C3C7D3; color: #444444;" width="30%">ระบบงาน IT ที่ควรปรับปรุงป้องกัน</th>
                <th style="border: gray solid thin; background-color: #C3C7D3; color: #444444;" width="20%">%สถิติการแจ้ง SPIES ทั้งหมด</th>
                <th style="border: gray solid thin; background-color: #C3C7D3; color: #444444;" width="45%">ข้อเสนอแนะ</th>
            </tr>
            <tr style="border: gray solid thin;">
                <td style="width: 100%; border: gray solid thin; text-align: center; vertical-align: top;"><?= nl2br($additional_text["text7"]);?></td>
                <td style="width: 100%; border: gray solid thin; vertical-align: top;"><?=nl2br($additional_text["text8"]);?></td>
                <td style="width: 100%; border: gray solid thin; text-align: center; vertical-align: top;"><?=nl2br($additional_text["text9"]);?></td>
                <td style="width: 100%; border: gray solid thin; vertical-align: top;"><?=nl2br($additional_text["text10"]);?></td>
            </tr>                
        </table><br>
        <table style="width: 100%; border: gray solid thin; color: black; font-size: 12px;">
            <tr style="border: gray solid thin;">
                <th style="border: gray solid thin; background-color: #C3C7D3; color: #444444;" width="30%">เขตการไฟฟ้าที่ควรปรับปรุงการปฏิบัติงาน</th>
                <th style="border: gray solid thin; background-color: #C3C7D3; color: #444444;" width="20%">%สถิติการแจ้ง SPIES ทั้งหมด</th>
                <th style="border: gray solid thin; background-color: #C3C7D3; color: #444444;" width="50%">ข้อเสนอแนะ</th>
            </tr>
            <tr style="border: gray solid thin;">
                <td style="width: 100%; border: gray solid thin; vertical-align: top;"><?=nl2br($additional_text["text11"]);?></td>
                <td style="width: 100%; border: gray solid thin; text-align: center; vertical-align: top;"><?=nl2br($additional_text["text12"]);?></td>
                <td style="width: 100%;border: gray solid thin; vertical-align: top;"><?=nl2br($additional_text["text13"]);?></td>
            </tr>
        </table>
        <br>
        <table>
        <tr><td colspan="5" style="width: 90%; background-color: #F36C00; font-weight: bold; font-size: 12.5px; border: gray solid thin; padding-left: 10px;">ด้านการปรับปรุง ป้องกันระบบงาน IT และกระบวนการปฎิบัติงาน BPM</td></tr>
    </table><br>
    <div style="width: 90%;">
        <table style="width: 100%; border: gray solid thin; color: black; font-size: 12px;">
            <tr style="border: gray solid thin;">
                <th style="border: gray solid thin; background-color: #C3C7D3; color: #444444;" width="5%">ลำดับ</th>
                <th style="border: gray solid thin; background-color: #C3C7D3; color: #444444;" width="30%">ระบบงาน IT ที่ควรปรับปรุงป้องกัน</th>
                <th style="border: gray solid thin; background-color: #C3C7D3; color: #444444;" width="20%">%สถิติการแจ้ง SPIES ทั้งหมด</th>
                <th style="border: gray solid thin; background-color: #C3C7D3; color: #444444;" width="45%">ข้อเสนอแนะ</th>
            </tr>
            <tr style="border: gray solid thin;">
                <td style="width: 100%; border: gray solid thin; text-align: center; vertical-align: top;"><?= nl2br($additional_text["BPM_text7"]);?></td>
                <td style="width: 100%; border: gray solid thin; vertical-align: top;"><?=nl2br($additional_text["BPM_text8"]);?></td>
                <td style="width: 100%; border: gray solid thin; text-align: center; vertical-align: top;"><?=nl2br($additional_text["BPM_text9"]);?></td>
                <td style="width: 100%; border: gray solid thin; vertical-align: top;"><?=nl2br($additional_text["BPM_text10"]);?></td>
            </tr>                
        </table><br>
        <table style="width: 100%; border: gray solid thin; color: black; font-size: 12px;">
            <tr style="border: gray solid thin;">
                <th style="border: gray solid thin; background-color: #C3C7D3; color: #444444;" width="30%">เขตการไฟฟ้าที่ควรปรับปรุงการปฏิบัติงาน</th>
                <th style="border: gray solid thin; background-color: #C3C7D3; color: #444444;" width="20%">%สถิติการแจ้ง SPIES ทั้งหมด</th>
                <th style="border: gray solid thin; background-color: #C3C7D3; color: #444444;" width="50%">ข้อเสนอแนะ</th>
            </tr>
            <tr style="border: gray solid thin;">
                <td style="width: 100%; border: gray solid thin; vertical-align: top;"><?=nl2br($additional_text["BPM_text11"]);?></td>
                <td style="width: 100%; border: gray solid thin; text-align: center; vertical-align: top;"><?=nl2br($additional_text["BPM_text12"]);?></td>
                <td style="width: 100%;border: gray solid thin; vertical-align: top;"><?=nl2br($additional_text["BPM_text13"]);?></td>
            </tr>
        </table>
            
    <br><br>
    <table>
        <tr><td colspan="5" style="width: 90%; background-color: #ffc4c4; font-weight: bold; font-size: 12.5px; border: gray solid thin; padding-left: 10px;">ประเด็นติดตามจากเดือนก่อนหน้า CBS</td></tr>
    </table><br>
    <table  style="width: 90%; border: gray solid thin; color: black; font-size: 12px;">
        <tr style="border: gray solid thin;">
            <th style="border: gray solid thin; background-color: #C3C7D3; color: #444444;" width="5%">ลำดับ</th>
            <th style="border: gray solid thin; background-color: #C3C7D3; color: #444444;" width="35%">ประเด็นที่ติดตาม</th>
            <th style="border: gray solid thin; background-color: #C3C7D3; color: #444444;" width="10%">เขตการไฟฟ้า</th>
            <th style="border: gray solid thin; background-color: #C3C7D3; color: #444444;" width="40%">แนวทางการแก้ไข</th>
            <th style="border: gray solid thin; background-color: #C3C7D3; color: #444444;" width="10%">ผลการปรับปรุง</th>
        </tr>
        <tr style="border: gray solid thin;">
            <td style="width: 100%; border: gray solid thin; text-align: center; vertical-align: top;"><?=nl2br($additional_text["text14"]);?></td>
            <td style="width: 100%; border: gray solid thin; vertical-align: top;" ><?=nl2br($additional_text["text15"]);?></td>
            <td style="width: 100%; border: gray solid thin; vertical-align: top;"><?=nl2br($additional_text["text16"]);?></td>
            <td style="width: 100%; border: gray solid thin; vertical-align: top;"><?=nl2br($additional_text["text17"]);?></td>
            <td style="width: 100%; border: gray solid thin; vertical-align: top;"><?=nl2br($additional_text["text18"]);?></td>
            
        </tr>
    </table>  <br>
    <table>
        <tr><td colspan="5" style="width: 90%; background-color: #F36C00; font-weight: bold; font-size: 12.5px; border: gray solid thin; padding-left: 10px;">ประเด็นติดตามจากเดือนก่อนหน้า BPM</td></tr>
    </table><br>
    <table  style="width: 90%; border: gray solid thin; color: black; font-size: 12px;">
        <tr style="border: gray solid thin;">
            <th style="border: gray solid thin; background-color: #C3C7D3; color: #444444;" width="5%">ลำดับ</th>
            <th style="border: gray solid thin; background-color: #C3C7D3; color: #444444;" width="35%">ประเด็นที่ติดตาม</th>
            <th style="border: gray solid thin; background-color: #C3C7D3; color: #444444;" width="10%">เขตการไฟฟ้า</th>
            <th style="border: gray solid thin; background-color: #C3C7D3; color: #444444;" width="40%">แนวทางการแก้ไข</th>
            <th style="border: gray solid thin; background-color: #C3C7D3; color: #444444;" width="10%">ผลการปรับปรุง</th>
        </tr>
        <tr style="border: gray solid thin;">
            <td style="width: 100%; border: gray solid thin; text-align: center; vertical-align: top;"><?=nl2br($additional_text["BPM_text14"]);?></td>
            <td style="width: 100%; border: gray solid thin; vertical-align: top;" ><?=nl2br($additional_text["BPM_text15"]);?></td>
            <td style="width: 100%; border: gray solid thin; vertical-align: top;"><?=nl2br($additional_text["BPM_text16"]);?></td>
            <td style="width: 100%; border: gray solid thin; vertical-align: top;"><?=nl2br($additional_text["BPM_text17"]);?></td>
            <td style="width: 100%; border: gray solid thin; vertical-align: top;"><?=nl2br($additional_text["BPM_text18"]);?></td>
            
        </tr>
    </table>  
</div><br><br>