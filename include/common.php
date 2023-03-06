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
if (!\defined('XOOPS_ICONS32_PATH')) {
    \define('XOOPS_ICONS32_PATH', \XOOPS_ROOT_PATH . '/Frameworks/moduleclasses/icons/32');
}
if (!\defined('XOOPS_ICONS32_URL')) {
    \define('XOOPS_ICONS32_URL', \XOOPS_URL . '/Frameworks/moduleclasses/icons/32');
}
\define('WGTESTUI_DIRNAME', 'wgtestui');
\define('WGTESTUI_PATH', \XOOPS_ROOT_PATH . '/modules/' . \WGTESTUI_DIRNAME);
\define('WGTESTUI_URL', \XOOPS_URL . '/modules/' . \WGTESTUI_DIRNAME);
\define('WGTESTUI_ICONS_PATH', \WGTESTUI_PATH . '/assets/icons');
\define('WGTESTUI_ICONS_URL', \WGTESTUI_URL . '/assets/icons');
\define('WGTESTUI_IMAGE_PATH', \WGTESTUI_PATH . '/assets/images');
\define('WGTESTUI_IMAGE_URL', \WGTESTUI_URL . '/assets/images');
\define('WGTESTUI_UPLOAD_PATH', \XOOPS_UPLOAD_PATH . '/' . \WGTESTUI_DIRNAME);
\define('WGTESTUI_UPLOAD_URL', \XOOPS_UPLOAD_URL . '/' . \WGTESTUI_DIRNAME);
\define('WGTESTUI_UPLOAD_FILES_PATH', \WGTESTUI_UPLOAD_PATH . '/files');
\define('WGTESTUI_UPLOAD_FILES_URL', \WGTESTUI_UPLOAD_URL . '/files');
\define('WGTESTUI_UPLOAD_IMAGE_PATH', \WGTESTUI_UPLOAD_PATH . '/images');
\define('WGTESTUI_UPLOAD_IMAGE_URL', \WGTESTUI_UPLOAD_URL . '/images');
\define('WGTESTUI_UPLOAD_SHOTS_PATH', \WGTESTUI_UPLOAD_PATH . '/images/shots');
\define('WGTESTUI_UPLOAD_SHOTS_URL', \WGTESTUI_UPLOAD_URL . '/images/shots');
\define('WGTESTUI_ADMIN', \WGTESTUI_URL . '/admin/index.php');
$localLogo = \WGTESTUI_IMAGE_URL . '/tdmxoops_logo.png';
// Module Information
$copyright = "<a href='https://xoops.org' title='XOOPS Project' target='_blank'><img src='" . $localLogo . "' alt='XOOPS Project' ></a>";
require_once \XOOPS_ROOT_PATH . '/class/xoopsrequest.php';
require_once \WGTESTUI_PATH . '/include/functions.php';
