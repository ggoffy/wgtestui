<!-- Header -->
<{include file='db:wgtestui_admin_header.tpl' }>

<{if $error|default:''}>
    <div class="errorMsg"><strong><{$error|default:false}></strong></div>
<{/if}>

<!-- Section import from file -->
<{if $form_import|default:false}>
    <{$form_import|default:false}>
<{/if}>

<!-- Section import from list -->
<{if $form_importlist|default:false}>
    <{$form_importlist|default:false}>
<{/if}>

<!-- Section export to file -->
<{if $form_export|default:false}>
    <{$form_export|default:false}>
<{/if}>

<!-- Footer -->
<{include file='db:wgtestui_admin_footer.tpl' }>
