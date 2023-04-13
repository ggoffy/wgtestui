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

$dirname       = \basename(\dirname(__DIR__));
$moduleHandler = \xoops_getHandler('module');
$xoopsModule   = XoopsModule::getByDirname($dirname);
$moduleInfo    = $moduleHandler->get($xoopsModule->getVar('mid'));
$sysPathIcon32 = $moduleInfo->getInfo('sysicons32');

$adminmenu[] = [
    'title' => \_MI_WGTESTUI_ADMENU1,
    'link' => 'admin/index.php',
    'icon' => $sysPathIcon32.'/dashboard.png',
];
$adminmenu[] = [
    'title' => \_MI_WGTESTUI_ADMENU2,
    'link' => 'admin/tests.php',
    'icon' => 'assets/icons/32/search.png',
];
$adminmenu[] = [
    'title' => \_MI_WGTESTUI_ADMENU5,
    'link' => 'admin/datatools.php',
    'icon' => 'assets/icons/32/datatools.png',
];
$adminmenu[] = [
    'title' => \_MI_WGTESTUI_ADMENU6,
    'link' => 'admin/tools.php',
    'icon' => $sysPathIcon32.'/exec.png',
];
$adminmenu[] = [
    'title' => \_MI_WGTESTUI_ADMENU3,
    'link' => 'admin/clone.php',
    'icon' => $sysPathIcon32.'/page_copy.png',
];
$adminmenu[] = [
    'title' => \_MI_WGTESTUI_ADMENU4,
    'link' => 'admin/feedback.php',
    'icon' => $sysPathIcon32.'/mail_foward.png',
];
$adminmenu[] = [
    'title' => \_MI_WGTESTUI_ABOUT,
    'link' => 'admin/about.php',
    'icon' => $sysPathIcon32.'/about.png',
];
