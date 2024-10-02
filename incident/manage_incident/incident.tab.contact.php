<div style="overflow-y: auto;">
			<br>
            <table width="98%" border="0" cellpadding="0" cellspacing="1" align="center">
                <tr style="height: 30px">
                    <td>
                        <span class="styleBlue">CONTACT</span><span class="styleGray"> INFORMATION</span>
                    </td>
                </tr>
            </table>
            <table width="75%" border="0" cellpadding="0" cellspacing="3" align="center">
                <tr>
                    <td class="tr_header" style="width: 40%;" >First Name </td>
                    <td><input type="text" name="con_firstname"  maxlength="20" description="Tab Contact:Contact firstname" value="<?=$incident["con_firstname"]?>"/></td>
                </tr>
                <tr>
                    <td class="tr_header">Last Name</td>
                    <td><input type="text" name="con_lastname" maxlength="50" description="Tab Contact:Contact lastname" value="<?=htmlspecialchars($incident["con_lastname"])?>"/></td>
                </tr>
                <tr>
                    <td class="tr_header">Phone Number</td>
                    <td><input type="text" name="con_phone" maxlength="50" description="Tab Contact:Contact phone" value="<?=htmlspecialchars($incident["con_phone"])?>"/></td>
                </tr>
                <tr>
                    <td class="tr_header">IP Address</td>
                    <td><input type="text" name="con_ipaddr" description="Tab Contact:Contact ip address"  value="<?=$incident["con_ipaddr"]?>"/></td>
                </tr>
                <tr>
                    <td class="tr_header">E-mail</td>
                    <td><input type="text" name="con_email" description="Tab Contact:Contact email" value="<?=$incident["con_email"]?>"/></td>
                </tr>
                <tr>
                    <td class="tr_header">Place</td>
                    <td><input type="text" name="con_place"  description="Tab Contact:Contact place" value="<?=$incident["con_place"]?>"/></td>
                </tr>
            </table>
</div>
