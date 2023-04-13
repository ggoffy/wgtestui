<!-- Header -->
<{include file='db:wgtestui_admin_header.tpl' }>

<!-- Index Page -->
<div class="">
    <h3><{$smarty.const._AM_WGTESTUI_HELPER_SMARTY3}></h3>
    <p><{$smarty3_info1|default:false}></p>
    <p><{$smarty3_info2|default:false}></p>
    <p><a style="padding:5px 10px;border:1px solid #ccc;border-radius: 5px;color:#fff;background-color: #0a6ebd" href="tools.php?op=updatesmarty3"><{$smarty.const._AM_WGTESTUI_EXEC_CODETOOL}></a></p>
</div>

<!-- Footer -->
<{include file='db:wgtestui_admin_footer.tpl' }>
