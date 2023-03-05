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
 * @copyright    2021 XOOPS Project (https://xoops.org)
 * @license      GPL 2.0 or later
 * @package      wgtestui
 * @since        1.0.0
 * @min_xoops    2.5.10
 * @author       TDM XOOPS - Email:info@email.com - Website:https://xoops.org
 */

require_once __DIR__ . '/common.php';

// ---------------- Admin Main ----------------
\define('_MI_WGTESTUI_NAME', 'wgTestUI');
\define('_MI_WGTESTUI_DESC', 'This module is for automation of testing XOOPS sites');
// ---------------- Admin Menu ----------------
\define('_MI_WGTESTUI_ADMENU1', 'Dashboard');
\define('_MI_WGTESTUI_ADMENU2', 'Tests');
\define('_MI_WGTESTUI_ADMENU3', 'Clone');
\define('_MI_WGTESTUI_ADMENU4', 'Feedback');
\define('_MI_WGTESTUI_ADMENU5', 'Datatools');
\define('_MI_WGTESTUI_ABOUT', 'About');
// ---------------- Admin Nav ----------------
\define('_MI_WGTESTUI_ADMIN_PAGER', 'Admin pager');
\define('_MI_WGTESTUI_ADMIN_PAGER_DESC', 'Admin per page list');
// Blocks
\define('_MI_WGTESTUI_TESTS_BLOCK', 'Tests block');
\define('_MI_WGTESTUI_TESTS_BLOCK_DESC', 'Tests block description');
\define('_MI_WGTESTUI_TESTS_BLOCK_NEW', 'Block add new tests');
\define('_MI_WGTESTUI_TESTS_BLOCK_NEW_DESC', 'Block for adding new tests');
// Config
\define('_MI_WGTESTUI_EDITOR_MAXCHAR', 'Text max characters');
\define('_MI_WGTESTUI_EDITOR_MAXCHAR_DESC', 'Max characters for showing text of a textarea or editor field in admin area');
\define('_MI_WGTESTUI_MAINTAINEDBY', 'Maintained By');
\define('_MI_WGTESTUI_MAINTAINEDBY_DESC', 'Allow url of support site or community');
\define('_MI_WGTESTUI_PATTERNS_OK', 'Search patterns OK');
\define('_MI_WGTESTUI_PATTERNS_OK_DESC', 'Define search pattern which identify a proper site, e.g. XOOPS is loading meta description only, if there was no error.<br>Use one line for one pattern.');
\define('_MI_WGTESTUI_PATTERNS_FATALERROR', 'Search patterns FATAL ERROR identifier');
\define('_MI_WGTESTUI_PATTERNS_FATALERROR_DESC', 'Define search pattern which identify that the html-code of the site contains XOOPS fatal error information (site is blocked).<br>Use one line for one pattern.');
\define('_MI_WGTESTUI_PATTERNS_FATALERRORDESC', 'Search patterns FATAL ERROR description');
\define('_MI_WGTESTUI_PATTERNS_FATALERRORDESC_DESC', 'Define search pattern which identify the error description, if site contains XOOPS error information.<br>Use one line for one pattern.');
\define('_MI_WGTESTUI_PATTERNS_WARNING', 'Search patterns WARNING');
\define('_MI_WGTESTUI_PATTERNS_WARNING_DESC', 'Define search pattern which identify that the html-code of the site contains XOOPS warning information.<br>Use one line for one pattern.');
// ---------------- End ----------------
