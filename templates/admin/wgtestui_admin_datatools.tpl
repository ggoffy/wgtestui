<!-- Header -->
<{include file='db:wgtestui_admin_header.tpl' }>

<{if isset($error)}>
    <div class="errorMsg"><strong><{$error|default:false}></strong></div>
    <div class="wgt-divider"></div>
<{/if}>

<!-- Section import from list -->
<{if $form_generatemenu|default:false}>
    <{$form_generatemenu|default:false}>
    <{if $resultGenerate|default:false}>
        <h4><{$smarty.const._AM_WGTESTUI_DATATOOLS_GENERATE_MENU_RESULT}></h4>
        <{$resultGenerate|default:false}>
        <p><{$smarty.const._AM_WGTESTUI_DATATOOLS_GENERATE_MENU_COPY}></p>
    <{/if}>
<{/if}>
<div class="wgt-divider"></div>

<!-- Section import from list -->
<{if $form_importlist|default:false}>
    <{$form_importlist|default:false}>
<{/if}>
<div class="wgt-divider"></div>

<!-- Section import from file -->
<{if $form_import|default:false}>
    <{$form_import|default:false}>
<{/if}>
<div class="wgt-divider"></div>

<!-- Section export to file -->
<{if $form_export|default:false}>
    <{$form_export|default:false}>
<{/if}>

<!-- Footer -->
<{include file='db:wgtestui_admin_footer.tpl' }>
