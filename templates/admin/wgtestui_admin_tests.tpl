<!-- Header -->
<{include file='db:wgtestui_admin_header.tpl' }>

<{if $statistics|default:false}>
    <table class='table table-bordered' style="margin-bottom:20px">
        <thead>
        <tr class='head'>
            <th class="center"><{$smarty.const._AM_WGTESTUI_TEST_MODULE}></th>
            <th class="center"><{$smarty.const._AM_WGTESTUI_TEST_STATS_TESTS}></th>
            <th class="center"><{$smarty.const._AM_WGTESTUI_TEST_STATS_STATUS200}></th>
            <th class="center"><{$smarty.const._AM_WGTESTUI_TEST_STATS_INFO}></th>
            <th class="center">&nbsp;</th>
        </tr>
        </thead>
        <tbody>
        <{foreach item=statistic from=$statistics}>
            <tr class='<{cycle values='odd, even'}>'>
                <td class='center'><{$statistic.module}></td>
                <td class='center'><{$statistic.tests}></td>
                <td class='center'>
                    <{$statistic.status200}>
                    <{if $statistic.status200ok|default:false}>
                        <img src="<{$wgtestui_icons_url_16}>/ok.png" alt="<{$smarty.const._AM_WGTESTUI_OK}>" title="<{$smarty.const._AM_WGTESTUI_OK}>">
                    <{else}>
                        <img src="<{$wgtestui_icons_url_16}>/warning.png" alt="<{$smarty.const._AM_WGTESTUI_NOTOK}>" title="<{$smarty.const._AM_WGTESTUI_NOTOK}>">
                    <{/if}>
                </td>
                <td class='center'>
                    <{$statistic.info}>
                    <{if $statistic.info|default:0 > 0}>
                        <img src="<{$wgtestui_icons_url_16}>/warning.png" alt="<{$smarty.const._AM_WGTESTUI_NOTOK}>" title="<{$smarty.const._AM_WGTESTUI_NOTOK}>">
                    <{else}>
                        <img src="<{$wgtestui_icons_url_16}>/ok.png" alt="<{$smarty.const._AM_WGTESTUI_OK}>" title="<{$smarty.const._AM_WGTESTUI_OK}>">
                    <{/if}>
                </td>
                <td class='center'>
                    <{if $statistic.show_details|default:false}>
                        <a href="tests.php?op=list&amp;module=<{$statistic.module}>" title="<{$smarty.const._AM_WGTESTUI_TEST_DETAILS}>"><img src="<{$wgtestui_icons_url_16}>/view.png" alt="<{$smarty.const._AM_WGTESTUI_TEST_DETAILS}>" ></a>
                    <{/if}>
                </td>
            </tr>
            <{/foreach}>
        </tbody>
    </table>
<{/if}>

<{if $tests_list|default:''}>
    <h3 class="center"><{$smarty.const._AM_WGTESTUI_LIST_TESTS}></h3>
    <table class='table table-bordered'>
        <thead>
            <tr class='head'>
                <th class="center"><{$smarty.const._AM_WGTESTUI_TEST_ID}></th>
                <th class="center"><{$smarty.const._AM_WGTESTUI_TEST_URL}></th>
                <th class="center"><{$smarty.const._AM_WGTESTUI_TEST_MODULE}></th>
                <th class="center"><{$smarty.const._AM_WGTESTUI_TEST_AREA}></th>
                <th class="center"><{$smarty.const._AM_WGTESTUI_TEST_TYPE}></th>
                <th class="center"><{$smarty.const._AM_WGTESTUI_TEST_RESULTCODE}></th>
                <th class="center"><{$smarty.const._AM_WGTESTUI_TEST_INFOTEXT}></th>
                <th class="center"><{$smarty.const._AM_WGTESTUI_TEST_DATETEST}></th>
                <th class="center"><{$smarty.const._AM_WGTESTUI_TEST_DATECREATED}></th>
                <th class="center"><{$smarty.const._AM_WGTESTUI_TEST_SUBMITTER}></th>
                <th class="center width5"><{$smarty.const._AM_WGTESTUI_FORM_ACTION}></th>
            </tr>
        </thead>
        <{if $tests_count|default:''}>
        <tbody>
            <{foreach item=test from=$tests_list}>
            <tr class='<{cycle values='odd, even'}>'>
                <td class='center'><{$test.id}></td>
                <td class='center'><{$test.url}></td>
                <td class='center'><{$test.module}></td>
                <td class='center'><{$test.area_text}></td>
                <td class='center'><{$test.type_text}></td>
                <td class='center'><{$test.resultcode}> <{$test.resulttext}></td>
                <td class='center'>
                    <{if $test.infotext|default:'' != ''}>
                    <img class="tooltip wgt-tooltip-img" onclick="display_dialog('<{$test.id}>', true, true, 'slide', 'slide', 300, '80%');"
                         src="<{$wgtestui_icons_url_32}>/display.png" alt="<{$smarty.const._AM_WGTESTUI_TEST_DETAILS}>" title="<{$smarty.const._AM_WGTESTUI_TEST_DETAILS}>">
                    <div id="dialog<{$test.id}>" title="<{$smarty.const._AM_WGTESTUI_TEST_DETAILS}>" style='display:none;'>
                        <p class="wgt-tooltip-header"><{$smarty.const._AM_WGTESTUI_TEST_RESULTS}> <{$test.url}></p>
                        <p><{$test.infotext_br}></p>
                    </div>
                    <{/if}>
                    <{$test.infotext_short}>
                </td>
                <td class='center'><{$test.datetest_text}></td>
                <td class='center'><{$test.datecreated_text}></td>
                <td class='center'><{$test.submitter_text}></td>
                <td class="center  width5">
                    <a href="tests.php?op=edit&amp;id=<{$test.id}>&amp;start=<{$start}>&amp;limit=<{$limit}>" title="<{$smarty.const._EDIT}>"><img src="<{$wgtestui_icons_url_16}>/edit.png" alt="<{$smarty.const._EDIT}> tests" ></a>
                    <a href="tests.php?op=clone&amp;test_id_source=<{$test.id}>" title="<{$smarty.const._CLONE}>"><img src="<{$wgtestui_icons_url_16}>/editcopy.png" alt="<{$smarty.const._CLONE}> tests" ></a>
                    <a href="tests.php?op=delete&amp;id=<{$test.id}>" title="<{$smarty.const._DELETE}>"><img src="<{$wgtestui_icons_url_16}>/delete.png" alt="<{$smarty.const._DELETE}> tests" ></a>
                </td>
            </tr>
            <{/foreach}>
        </tbody>
        <{/if}>
    </table>
    <div class="clear">&nbsp;</div>
    <{if $pagenav|default:''}>
        <div class="xo-pagenav floatright"><{$pagenav|default:false}></div>
        <div class="clear spacer"></div>
    <{/if}>
<{/if}>
<{if $showInfoExecute|default:false}>
    <div class="wgt-info-execute">
        <h5><{$smarty.const._AM_WGTESTUI_TEST_INFO_EXEC1}></h5>
        <ul>
            <li><{$smarty.const._AM_WGTESTUI_TEST_INFO_EXEC2}></li>
            <li><{$smarty.const._AM_WGTESTUI_TEST_INFO_EXEC3}></li>
        </ul>
    </div>
<{/if}>
<{if $form|default:''}>
    <{$form|default:false}>
<{/if}>
<{if $error|default:''}>
    <div class="errorMsg"><strong><{$error|default:false}></strong></div>
<{/if}>

<!-- Footer -->
<{include file='db:wgtestui_admin_footer.tpl' }>
