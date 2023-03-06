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

require_once __DIR__ . '/header.php';
require_once \XOOPS_ROOT_PATH . '/header.php';

XoopsLoad::load('xoopslogger');
$xoopsLogger = XoopsLogger::getInstance();
$xoopsLogger->activated = false;

// Get instance of module
$helper = \XoopsModules\Wgtestui\Helper::getInstance();
$testsHandler = $helper->getHandler('Tests');

$url = Request::getString('url', 'invalid url');

$testsObj = $testsHandler->create();
if (!is_object($testsObj)) {
    header('Content-Type: application/json');
    echo json_encode(['status'=>'error','message'=>'invalid object testsObj']);
} else {
    $currentUrl = str_replace(XOOPS_URL . '/', '', $url);
    if ('' === $currentUrl) {
        $currentUrl = 'index.php';
    }
    //check whether given url already exists in database
    $crTests = new \CriteriaCompo();
    $crTests->add(new Criteria('url', $currentUrl));
    if ($testsHandler->getCount($crTests) > 0) {
        header('Content-Type: application/json');
        echo json_encode(['status' => 'success', 'message' => \_AM_WGTESTUI_TEST_URL_EXISTS]);
    } else {
        $arrTemp = explode('/', $currentUrl);
        $testModule = \count($arrTemp) > 0 ? $arrTemp[1] : 'xoopscore';
        $testsObj->setVar('url', $currentUrl);
        $testsObj->setVar('area', 2);
        $testsObj->setVar('module', $testModule);
        $testsObj->setVar('type', 1);
        $testsObj->setVar('resultcode', '0');
        $testsObj->setVar('resulttext', '');
        $testsObj->setVar('infotext', '');
        //$testsObj->setVar('datetest', \time());
        $testsObj->setVar('datecreated', \time());
        $testsObj->setVar('submitter', $GLOBALS['xoopsUser']->uid());
        // Insert Data
        if ($testsHandler->insert($testsObj)) {
            // redirect after insert
            header('Content-Type: application/json');
            echo json_encode(['status' => 'success', 'message' => \_AM_WGTESTUI_TEST_URL_ADDED]);
        } else {
            header('Content-Type: application/json');
            echo json_encode(['status' => 'error', 'message' => \_AM_WGTESTUI_TEST_URL_ERROR . '<br>' . $testsObj->getErrors()]);
        }
    }
}
