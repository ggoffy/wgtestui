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

use Xmf\Request;
use XoopsModules\Wgtestui\ReplaceTextInFiles;

require __DIR__ . '/header.php';

$op = Request::getCmd('op', 'list');
// Template Index
$templateMain = 'wgtestui_admin_tools.tpl';

// Render Index
$GLOBALS['xoopsTpl']->assign('navigation', $adminObject->displayNavigation('tools.php'));

$mimetypes = ['html', 'tpl'];
$src_path  = XOOPS_ROOT_PATH . '/modules/';
$dst_path  = XOOPS_ROOT_PATH . '/modules/';

switch ($op) {
    case 'list':
    default:
        $GLOBALS['xoopsTpl']->assign('smarty3_info1', \sprintf(\_AM_WGTESTUI_TOOLS_ATT_OVERWRITE, $dst_path));
        $GLOBALS['xoopsTpl']->assign('smarty3_info2', \sprintf(\_AM_WGTESTUI_TOOLS_ATT_MIMETYPES, \implode(' ', $mimetypes)));

        break;

    case 'updatesmarty3':
        $patterns = [
            '<{includeq file'        => '<{include file',
            '<{foreachq '            => '<{foreach ',
            '<{xoAppUrl index.php}>' => "<{xoAppUrl 'index.php'}>",
            '<{block '               => '<{xoBlock '
        ];
        //check all images from icons 16
        $img16 = XOOPS_ROOT_PATH . '/Frameworks/moduleclasses/icons/16/';
        $imagesArr   = \XoopsLists::getImgListAsArray($img16);
        foreach ($imagesArr as $img) {
            //"<{xoModuleIcons16 edit.png}>" into "<{xoModuleIcons16 'edit.png'}>"
            $patterns["\"<{xoModuleIcons16 $img}>\""] = "\"<{xoModuleIcons16 '$img'}>\"";
            $patterns["\"<{xoAdminIcons $img}>\""]    = "\"<{xoAdminIcons '$img'}>\"";
            $patterns["\"<{xoAdminNav $img}>\""]      = "\"<{xoAdminNav '$img'}>\"";
            $patterns["\"<{xoAppUrl $img}>\""]        = "\"<{xoAppUrl '$img'}>\"";
            $patterns["\"<{xoImgUrl $img}>\""]        = "\"<{xoImgUrl '$img'}>\"";
            //'<{xoModuleIcons16 edit.png}>' into "<{xoModuleIcons16 'edit.png'}>"
            $patterns["'<{xoModuleIcons16 $img}>'"] = "\"<{xoModuleIcons16 '$img'}>\"";
            $patterns["'<{xoAdminIcons $img}>'"]    = "\"<{xoAdminIcons '$img'}>\"";
            $patterns["'<{xoAdminNav $img}>'"]      = "\"<{xoAdminNav '$img'}>\"";
            $patterns["'<{xoAppUrl $img}>'"]        = "\"<{xoAppUrl '$img'}>\"";
            $patterns["'<{xoImgUrl $img}>'"]        = "\"<{xoImgUrl '$img'}>\"";

        }
        //check all images from icons 32
        $img32 = XOOPS_ROOT_PATH . '/Frameworks/moduleclasses/icons/32/';
        $imagesArr   = \XoopsLists::getImgListAsArray($img32);
        foreach ($imagesArr as $img) {
            //"<{xoModuleIcons32 edit.png}>" into "<{xoModuleIcons32 'edit.png'}>"
            $patterns["\"<{xoModuleIcons32 $img}>\""] = "\"<{xoModuleIcons32 '$img'}>\"";
            $patterns["\"<{xoAdminIcons $img}>\""]    = "\"<{xoAdminIcons '$img'}>\"";
            $patterns["\"<{xoAdminNav $img}>\""]      = "\"<{xoAdminNav '$img'}>\"";
            $patterns["\"<{xoAppUrl $img}>\""]        = "\"<{xoAppUrl '$img'}>\"";
            $patterns["\"<{xoImgUrl $img}>\""]        = "\"<{xoImgUrl '$img'}>\"";
            //'<{xoModuleIcons32 edit.png}>' into "<{xoModuleIcons32 'edit.png'}>"
            $patterns["'<{xoModuleIcons32 $img}>'"] = "\"<{xoModuleIcons32 '$img'}>\"";
            $patterns["'<{xoAdminIcons $img}>'"]    = "\"<{xoAdminIcons '$img'}>\"";
            $patterns["'<{xoAdminNav $img}>'"]      = "\"<{xoAdminNav '$img'}>\"";
            $patterns["'<{xoAppUrl $img}>'"]        = "\"<{xoAppUrl '$img'}>\"";
            $patterns["'<{xoImgUrl $img}>'"]        = "\"<{xoImgUrl '$img'}>\"";
        }

        $helperReplace = new ReplaceTextInFiles;
        $helperReplace::replaceExecute($src_path, $dst_path, $patterns, $mimetypes);

        \redirect_header('tools.php?op=list', 2, \_AM_WGTESTUI_TOOLS_DONE1);
        break;
}






// End Test Data
require __DIR__ . '/footer.php';
