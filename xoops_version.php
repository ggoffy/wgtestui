<?php

declare(strict_types=1);

/*
 You may not change or alter any portion of this comment or credits
 of supporting developers from this source code or any supporting source code
 which is considered copyrighted (c) material of the original comment or credit authors.

 This program is distributed in the hope that it will be useful,
 but WITHOUT ANY WARRANTY; without even the implied warranty of
 MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.
*/

/**
 * wgTestUI module for xoops
 *
 * @copyright    2023 XOOPS Project (https://xoops.org)
 * @license      GPL 2.0 or later
 * @package      wgtestui
 * @author       Goffy - XOOPS Development Team - Email:<webmaster@wedega.com> - Website:<https://xoops.wedega.com>
 */

// 
$moduleDirName      = \basename(__DIR__);
$moduleDirNameUpper = \mb_strtoupper($moduleDirName);
// ------------------- Informations ------------------- //
$modversion = [
    'name'                => \_MI_WGTESTUI_NAME,
    'version'             => '1.0.1',
    'module_status'       => 'RC1',
    'release'             => '2023-03-01', // format: yyyy-mm-dd
    'release_date'        => '2023/03/01', // format: yyyy/mm/dd
    'description'         => \_MI_WGTESTUI_DESC,
    'author'              => 'Goffy - XOOPS Development Team',
    'author_mail'         => 'webmaster@wedega.com',
    'author_website_url'  => 'https://xoops.wedega.com',
    'author_website_name' => 'XOOPS on Wedega',
    'credits'             => 'Goffy - XOOPS Development Team',
    'license'             => 'GPL 2.0 or later',
    'license_url'         => 'https://www.gnu.org/licenses/gpl-3.0.en.html',
    'help'                => 'page=help',
    'release_info'        => 'release_info',
    'release_file'        => \XOOPS_URL . '/modules/wgtestui/docs/release_info file',
    'manual'              => 'link to manual file',
    'manual_file'         => \XOOPS_URL . '/modules/wgtestui/docs/install.txt',
    'min_php'             => '7.0',
    'min_xoops'           => '2.5.10',
    'min_admin'           => '1.2',
    'min_db'              => ['mysql' => '5.6', 'mysqli' => '5.6'],
    'image'               => 'assets/images/logoModule.png',
    'dirname'             => \basename(__DIR__),
    'dirmoduleadmin'      => 'Frameworks/moduleclasses/moduleadmin',
    'sysicons16'          => '../../Frameworks/moduleclasses/icons/16',
    'sysicons32'          => '../../Frameworks/moduleclasses/icons/32',
    'modicons16'          => 'assets/icons/16',
    'modicons32'          => 'assets/icons/32',
    'demo_site_url'       => 'https://xoops.org',
    'demo_site_name'      => 'XOOPS Demo Site',
    'support_url'         => 'https://xoops.org/modules/newbb',
    'support_name'        => 'Support Forum',
    'module_website_url'  => 'www.xoops.org',
    'module_website_name' => 'XOOPS Project',
    'system_menu'         => 1,
    'hasAdmin'            => 1,
    'hasMain'             => 0,
    'adminindex'          => 'admin/index.php',
    'adminmenu'           => 'admin/menu.php',
    'onInstall'           => 'include/install.php',
    'onUninstall'         => 'include/uninstall.php',
    'onUpdate'            => 'include/update.php',
];
// ------------------- Templates ------------------- //
$modversion['templates'] = [
    // Admin templates
    ['file' => 'wgtestui_admin_about.tpl', 'description' => '', 'type' => 'admin'],
    ['file' => 'wgtestui_admin_header.tpl', 'description' => '', 'type' => 'admin'],
    ['file' => 'wgtestui_admin_index.tpl', 'description' => '', 'type' => 'admin'],
    ['file' => 'wgtestui_admin_tests.tpl', 'description' => '', 'type' => 'admin'],
    ['file' => 'wgtestui_admin_clone.tpl', 'description' => '', 'type' => 'admin'],
    ['file' => 'wgtestui_admin_footer.tpl', 'description' => '', 'type' => 'admin'],
    ['file' => 'wgtestui_admin_examples.tpl', 'description' => '', 'type' => 'admin'],
    ['file' => 'wgtestui_admin_examples_err.tpl', 'description' => '', 'type' => 'admin'],
    ['file' => 'wgtestui_admin_datatools.tpl', 'description' => '', 'type' => 'admin'],
    // User templates
    ['file' => 'wgtestui_header.tpl', 'description' => ''],
    ['file' => 'wgtestui_index.tpl', 'description' => ''],
    ['file' => 'wgtestui_breadcrumbs.tpl', 'description' => ''],
    ['file' => 'wgtestui_footer.tpl', 'description' => ''],
    ['file' => 'wgtestui_tests.tpl', 'description' => ''],
    ['file' => 'wgtestui_tests_list.tpl', 'description' => ''],
    ['file' => 'wgtestui_tests_item.tpl', 'description' => ''],
];
// ------------------- Mysql ------------------- //
$modversion['sqlfile']['mysql'] = 'sql/mysql.sql';
// Tables
$modversion['tables'] = [
    'wgtestui_tests',
];
// ------------------- Default Blocks ------------------- //
// Tests new
$modversion['blocks'][] = [
    'file'        => 'tests.php',
    'name'        => \_MI_WGTESTUI_TESTS_BLOCK_NEW,
    'description' => \_MI_WGTESTUI_TESTS_BLOCK_NEW_DESC,
    'show_func'   => 'b_wgtestui_tests_show',
    'edit_func'   => '',
    'template'    => 'wgtestui_block_tests.tpl',
    'options'     => 'new',
];
// ------------------- Config ------------------- //
// Editor : max characters admin area
$modversion['config'][] = [
    'name'        => 'editor_maxchar',
    'title'       => '\_MI_WGTESTUI_EDITOR_MAXCHAR',
    'description' => '\_MI_WGTESTUI_EDITOR_MAXCHAR_DESC',
    'formtype'    => 'textbox',
    'valuetype'   => 'int',
    'default'     => 50,
];
// Admin pager
$modversion['config'][] = [
    'name'        => 'adminpager',
    'title'       => '\_MI_WGTESTUI_ADMIN_PAGER',
    'description' => '\_MI_WGTESTUI_ADMIN_PAGER_DESC',
    'formtype'    => 'textbox',
    'valuetype'   => 'int',
    'default'     => 100,
];
// pattern OK
$modversion['config'][] = [
    'name'        => 'patterns_ok',
    'title'       => '\_MI_WGTESTUI_PATTERNS_OK',
    'description' => '\_MI_WGTESTUI_PATTERNS_OK_DESC',
    'formtype'    => 'textarea',
    'valuetype'   => 'text',
    'default'     => '<meta name="keywords"',
];
// patterns Error
$modversion['config'][] = [
    'name'        => 'patterns_fatalerror',
    'title'       => '\_MI_WGTESTUI_PATTERNS_FATALERROR',
    'description' => '\_MI_WGTESTUI_PATTERNS_FATALERROR_DESC',
    'formtype'    => 'textarea',
    'valuetype'   => 'text',
    'default'     => "xo-siteblocked-message",
];
// patterns Error description
$modversion['config'][] = [
    'name'        => 'patterns_fatalerrordesc',
    'title'       => '\_MI_WGTESTUI_PATTERNS_FATALERRORDESC',
    'description' => '\_MI_WGTESTUI_PATTERNS_FATALERRORDESC_DESC',
    'formtype'    => 'textarea',
    'valuetype'   => 'text',
    'default'     => "/<p class=\'xo-siteblocked-desc\'>(.*?)<\/p>/\r\n/<p class=\"xo-siteblocked-desc\">(.*?)<\/p>/",
];
// patterns Warning
$modversion['config'][] = [
    'name'        => 'patterns_warning',
    'title'       => '\_MI_WGTESTUI_PATTERNS_WARNING',
    'description' => '\_MI_WGTESTUI_PATTERNS_WARNING_DESC',
    'formtype'    => 'textarea',
    'valuetype'   => 'text',
    'default'     => "",
];
// Make Sample button visible?
$modversion['config'][] = [
    'name'        => 'displaySampleButton',
    'title'       => 'CO_' . $moduleDirNameUpper . '_' . 'SHOW_SAMPLE_BUTTON',
    'description' => 'CO_' . $moduleDirNameUpper . '_' . 'SHOW_SAMPLE_BUTTON_DESC',
    'formtype'    => 'yesno',
    'valuetype'   => 'int',
    'default'     => 1,
];
// Maintained by
$modversion['config'][] = [
    'name'        => 'maintainedby',
    'title'       => '\_MI_WGTESTUI_MAINTAINEDBY',
    'description' => '\_MI_WGTESTUI_MAINTAINEDBY_DESC',
    'formtype'    => 'textbox',
    'valuetype'   => 'text',
    'default'     => 'https://xoops.org/modules/newbb',
];
