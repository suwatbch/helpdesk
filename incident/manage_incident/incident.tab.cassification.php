<!--        <script type="text/javascript" src="../../include/js/mulifile/jquery-1.9.1.min.js"></script>-->
<script type="text/javascript" src="../../include/js/mulifile/jQuery.MultiFile.js"></script>
<script type="text/javascript" language="javascript">
    $(function() { // wait for document to load 
        $('#uploadfile_cass').MultiFile({
            list: '#show_file_cass'
        });
    });
</script>
<script type="text/javascript">
    $('document').ready(function() {
        $('a.delete_file').click(function() {
            if (confirm("Are you sure to delete")) {
                var del_id = $(this).parent().parent().attr('id');
                var parent = $(this).parent().parent();
                $.post('delete_file_cass.php', {
                    id: del_id
                }, function(data) {
                    parent.fadeOut('fast', function() {
                        $(this).remove();
                    });
                });
            }
        });
    });
</script>

<div id="cassification_tab" name="cassification_tab" style="overflow-y: auto;">
    <br>
    <table width="98%" border="0" cellpadding="0" cellspacing="3" align="center">
        <tr style="height: 30px">
            <td colspan="2">
                <span class="styleBlue">CLASSIFICATION</span><span class="styleGray"> INFORMATION</span>
            </td>

        </tr>
    </table>
    <table width="75%" border="0" cellpadding="0" cellspacing="3" align="center">
        <tr>
            <!--td class="tr_header" width="40%">Incident Type <span class="required">*</span></td> -->
            <td class="tr_header" width="40%">System ID<span class="required">*</span></td>
            <td colspan="2">
                <?= $dd_incident_type; ?>
            </td>
        </tr>
        <tr>
            <td class="tr_header">Project <span class="required">*</span></td>
            <td colspan="2"><?= $dd_project; ?></td>

        </tr>

    </table>

    <table width="75%" border="0" cellpadding="0" cellspacing="3" align="center">
        <tr>
            <td colspan="3" style="height: 30px"><span class="styleGray">PRODUCT CATEGORIZATION</span></td>
        </tr>
        <tr>
            <td class="tr_header" width="40%">Class 1 <span class="required">*</span></td>
            <td colspan="2">
                <?= $dd_prd_tier1; ?><input type="hidden" name="h_cas_prd_tier_id1" id="h_cas_prd_tier_id1" value="<?= $incident["cas_prd_tier_id1_name"]; ?>" /></td>
        </tr>
        <tr>
            <td class="tr_header">Class 2 <span class="required">*</span></td>
            <td colspan="2">
                <?= $dd_prd_tier2; ?><input type="hidden" name="h_cas_prd_tier_id2" id="h_cas_prd_tier_id2" value="<?= $incident["cas_prd_tier_id2_name"]; ?>" /></td>
        </tr>
        <tr>
            <td class="tr_header">Class 3 <span class="required">*</span></td>
            <td colspan="2">
                <?= $dd_prd_tier3; ?><input type="hidden" name="h_cas_prd_tier_id3" id="h_cas_prd_tier_id3" value="<?= $incident["cas_prd_tier_id3_name"]; ?>" /></td>
        </tr>
        <tr>
            <td colspan="3" style="height: 30px"><span class="styleGray">OPERATIONAL CATEGORIZATION</span></td>
        </tr>
        <tr>
            <td class="tr_header">Class 1 <span class="required">*</span></td>
            <td colspan="2"><?= $dd_opr_tier1; ?></td>
        </tr>
        <tr>
            <td class="tr_header">Class 2 <span class="required">*</span></td>
            <td colspan="2"><?= $dd_opr_tier2; ?></td>
        </tr>
        <tr>
            <td class="tr_header">Class 3</td>
            <td colspan="2"><?= $dd_opr_tier3; ?></td>
        </tr>
        <tr>
            <td>&nbsp;</td>
        </tr>
        <tr>
            <td class="tr_header">Attach File</td>
            <td>
                <input type="file" id="uploadfile_cass" name="uploadfile_cass[]" />
                <div id="show_file_cass" style="border:#999 solid 3px; padding:10px;">
                </div>
            </td>

            <!--                    <td class="tr_header">Attach File</td>
                    <td>
                        <div name="list_div_cass" id="list_div_cass" >
                                <select multiple name="file_list_cass" id="file_list_cass" size="4" style="height: 80px; width: 100%;"></select>
                        </div>
                        <div name="files_div_cass" id="files_div_cass" style="display:none">
                            <input type="file" name="userfile_cass[]" id="file_cass_0" size="30" onChange="javascript:add_file2(this.value);">
                            <input type="hidden" name="hd_file_name_cass[]" id="hd_file_name_cass"/>
                        </div>
                    </td>
                    <td valign="top" width="2%">
                        <img id="btnbrowse_cass" src="../../images/head_d/18.jpg" style="cursor: pointer;"><br><br><br>
                        <img id="remove_file_btn" src="../../images/head_d/19.jpg" style="cursor: pointer;" onClick="javascript:remove_file2();">
                    </td> -->
        </tr>

    </table>

    <table width="100%" border="0" cellpadding="0" cellspacing="1" align="center">
        <tr style="height: 30px">
            <td><span class="styleGray">&nbsp;&nbsp;Attachment</span></td>
        </tr>
        <tr>
            <td>
                <div style="overflow: auto;">
                    <table width="100%" cellpadding="0" cellspacing="1" class="data-table">

                        <thead>
                            <tr>
                                <td align="center">Name File</td>
                                <td width="20%" align="center">User</td>
                                <td width="20%" align="center">Date</td>
                                <?php if (count($incident["Workinfo"]) < 1) { ?>
                                    <td width="5%" align="center">Delete</td>
                                <?php } ?>
                            </tr>
                        </thead>
                        <tbody>
                            <?php

                            if (count($incident["file_cassification"]) > 0) {
                                foreach ($incident["file_cassification"] as $fetch_file) {
                                    $attach_cas = "Y";
                            ?>
                                    <tr id="<?= $fetch_file["attach_id"]; ?>">
                                        <td align="left"><a href="../../upload/temp_inc_cass/<?= $fetch_file["location_name"] ?>" target="_blank"> <?= htmlspecialchars($fetch_file["attach_name"]) ?></a></td>
                                        <td align="center"><a herf="#" style="cursor: pointer;"><?= $fetch_file["first_name"] . " " . $fetch_file["last_name"] ?></a>
                                        <td align="center"><?= dateUtil::date_dmyhms2($fetch_file["attach_date"]) ?></td>
                                        <?php if (count($incident["Workinfo"]) < 1) { ?>
                                            <td align="center"><a href="javascript:return(0);" class="delete_file"><img src="../../images/error.png" height="12px" width="12px" /></a></td>
                                        <?php } ?>
                                    </tr>
                            <?php
                                }
                            }  ?>
                        </tbody>
                    </table>
                </div>
            </td>
        </tr>
        <tr style="height: 45px">
            <td style="width: 180px"></td>
        </tr>
    </table>
</div>