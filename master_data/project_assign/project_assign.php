<?php
    include_once "project.action.php";
?>
<link type="text/css" rel="stylesheet" href="../../include/js/tabber/example.css"/>
<script type="text/javascript" src="../../include/js/tabber/tabber.js"></script>
<script type="text/javascript">

</script>


<?php include_once "project.member.php";?>

<input type="hidden" name="access_group_id" id="access_group_id" value="<?=$_REQUEST["access_group_id"]?>"/>
<input type="hidden" name="member" id="member"/>
<input type="hidden" name="permission" id="permission"/>
<input type="hidden" name="ss_search_user" id="ss_search_user"/>