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

use Xmf\Request;
use XoopsModules\Wgtestui;
use XoopsModules\Wgtestui\Constants;
use XoopsModules\Wgtestui\Common;

require __DIR__ . '/header.php';
// Get all request values
$op     = Request::getCmd('op', 'list');
$testId = Request::getInt('id');
$start  = Request::getInt('start');
$limit  = Request::getInt('limit', $helper->getConfig('adminpager'));
$GLOBALS['xoopsTpl']->assign('start', $start);
$GLOBALS['xoopsTpl']->assign('limit', $limit);

switch ($op) {
    case 'list':
    default:
        // Define Stylesheet
        $GLOBALS['xoTheme']->addStylesheet($style, null);
        // css and js for showing dialog
        $GLOBALS['xoTheme']->addStylesheet(XOOPS_URL . '/modules/system/css/admin.css');
        $GLOBALS['xoTheme']->addStylesheet(XOOPS_URL . '/modules/system/css/ui/' . xoops_getModuleOption('jquery_theme', 'system') . '/ui.all.css');
        $GLOBALS['xoTheme']->addScript('browse.php?Frameworks/jquery/jquery.js');
        $GLOBALS['xoTheme']->addScript('browse.php?Frameworks/jquery/plugins/jquery.ui.js');
        $GLOBALS['xoTheme']->addScript(\XOOPS_URL . '/modules/system/js/admin.js');
        // end: css and js for showing dialog
        $templateMain = 'wgtestui_admin_tests.tpl';
        $GLOBALS['xoopsTpl']->assign('navigation', $adminObject->displayNavigation('tests.php'));
        $adminObject->addItemButton(\_AM_WGTESTUI_ADD_TEST, 'tests.php?op=new');
        $adminObject->addItemButton(\_AM_WGTESTUI_EXEC_TEST, 'tests.php?op=execute', 'exec');
        $adminObject->addItemButton(\_AM_WGTESTUI_RESET_TEST, 'tests.php?op=reset_all', 'delete');
        $adminObject->addItemButton(\_AM_WGTESTUI_CLEAR_TEST, 'tests.php?op=delete_all', 'delete');
        $GLOBALS['xoopsTpl']->assign('buttons', $adminObject->displayButton('left'));
        $testsCount = $testsHandler->getCountTests();
        $testsAll = $testsHandler->getAllTests($start, $limit);
        $GLOBALS['xoopsTpl']->assign('tests_count', $testsCount);
        $GLOBALS['xoopsTpl']->assign('wgtestui_url', \WGTESTUI_URL);
        $GLOBALS['xoopsTpl']->assign('wgtestui_upload_url', \WGTESTUI_UPLOAD_URL);
        // Table view tests
        if ($testsCount > 0) {
            foreach (\array_keys($testsAll) as $i) {
                $test = $testsAll[$i]->getValuesTests();
                $GLOBALS['xoopsTpl']->append('tests_list', $test);
                unset($test);
            }
            // Display Navigation
            if ($testsCount > $limit) {
                require_once \XOOPS_ROOT_PATH . '/class/pagenav.php';
                $pagenav = new \XoopsPageNav($testsCount, $limit, $start, 'start', 'op=list&limit=' . $limit);
                $GLOBALS['xoopsTpl']->assign('pagenav', $pagenav->renderNav());
            }
        } else {
            $GLOBALS['xoopsTpl']->assign('error', \_AM_WGTESTUI_THEREARENT_TESTS);
        }
        break;
    case 'new':
        $templateMain = 'wgtestui_admin_tests.tpl';
        $GLOBALS['xoopsTpl']->assign('navigation', $adminObject->displayNavigation('tests.php'));
        $adminObject->addItemButton(\_AM_WGTESTUI_LIST_TESTS, 'tests.php', 'list');
        $GLOBALS['xoopsTpl']->assign('buttons', $adminObject->displayButton('left'));
        // Form Create
        $testsObj = $testsHandler->create();
        $form = $testsObj->getFormTests();
        $GLOBALS['xoopsTpl']->assign('form', $form->render());
        break;
    case 'clone':
        $templateMain = 'wgtestui_admin_tests.tpl';
        $GLOBALS['xoopsTpl']->assign('navigation', $adminObject->displayNavigation('tests.php'));
        $adminObject->addItemButton(\_AM_WGTESTUI_LIST_TESTS, 'tests.php', 'list');
        $adminObject->addItemButton(\_AM_WGTESTUI_ADD_TEST, 'tests.php?op=new');
        $GLOBALS['xoopsTpl']->assign('buttons', $adminObject->displayButton('left'));
        // Request source
        $testIdSource = Request::getInt('test_id_source');
        // Get Form
        $testsObjSource = $testsHandler->get($testIdSource);
        $testsObj = $testsObjSource->xoopsClone();
        $form = $testsObj->getFormTests();
        $GLOBALS['xoopsTpl']->assign('form', $form->render());
        break;
    case 'save':
        // Security Check
        if (!$GLOBALS['xoopsSecurity']->check()) {
            \redirect_header('tests.php', 3, \implode(',', $GLOBALS['xoopsSecurity']->getErrors()));
        }
        if ($testId > 0) {
            $testsObj = $testsHandler->get($testId);
        } else {
            $testsObj = $testsHandler->create();
        }
        // Set Vars
        $testUrl = str_replace(XOOPS_URL . '/', '', Request::getString('url'));
        $testModule = '';
        $modArr = explode('/', $testUrl);
        if (\count($modArr) > 1) {
            $testModule = $modArr[1];
        }
        $testsObj->setVar('url', $testUrl);
        $testsObj->setVar('module', $testModule);
        $testsObj->setVar('area', Request::getInt('area'));
        $testsObj->setVar('type', Request::getInt('type'));
        $testsObj->setVar('resultcode', Request::getString('resultcode'));
        $testsObj->setVar('resulttext', Request::getString('resulttext'));
        $testsObj->setVar('infotext', Request::getText('infotext'));
        $testDatetestArr = Request::getArray('datetest');
        $testDatetestObj = \DateTime::createFromFormat(\_SHORTDATESTRING, $testDatetestArr['date']);
        $testDatetestObj->setTime(0, 0, 0);
        $testDatetest = $testDatetestObj->getTimestamp() + (int)$testDatetestArr['time'];
        $testsObj->setVar('datetest', $testDatetest);
        $testDatecreatedArr = Request::getArray('datecreated');
        $testDatecreatedObj = \DateTime::createFromFormat(\_SHORTDATESTRING, $testDatecreatedArr['date']);
        $testDatecreatedObj->setTime(0, 0, 0);
        $testDatecreated = $testDatecreatedObj->getTimestamp() + (int)$testDatecreatedArr['time'];
        $testsObj->setVar('datecreated', $testDatecreated);
        $testsObj->setVar('submitter', Request::getInt('submitter'));
        // Insert Data
        if ($testsHandler->insert($testsObj)) {
            \redirect_header('tests.php?op=list&amp;start=' . $start . '&amp;limit=' . $limit, 2, \_AM_WGTESTUI_FORM_OK);
        }
        // Get Form
        $GLOBALS['xoopsTpl']->assign('error', $testsObj->getHtmlErrors());
        $form = $testsObj->getFormTests();
        $GLOBALS['xoopsTpl']->assign('form', $form->render());
        break;
    case 'edit':
        $templateMain = 'wgtestui_admin_tests.tpl';
        $GLOBALS['xoopsTpl']->assign('navigation', $adminObject->displayNavigation('tests.php'));
        $adminObject->addItemButton(\_AM_WGTESTUI_ADD_TEST, 'tests.php?op=new');
        $adminObject->addItemButton(\_AM_WGTESTUI_LIST_TESTS, 'tests.php', 'list');
        $GLOBALS['xoopsTpl']->assign('buttons', $adminObject->displayButton('left'));
        // Get Form
        $testsObj = $testsHandler->get($testId);
        $testsObj->start = $start;
        $testsObj->limit = $limit;
        $form = $testsObj->getFormTests();
        $GLOBALS['xoopsTpl']->assign('form', $form->render());
        break;
    case 'delete':
        $templateMain = 'wgtestui_admin_tests.tpl';
        $GLOBALS['xoopsTpl']->assign('navigation', $adminObject->displayNavigation('tests.php'));
        $testsObj = $testsHandler->get($testId);
        $testUrl = $testsObj->getVar('url');
        if (isset($_REQUEST['ok']) && 1 == $_REQUEST['ok']) {
            if (!$GLOBALS['xoopsSecurity']->check()) {
                \redirect_header('tests.php', 3, \implode(', ', $GLOBALS['xoopsSecurity']->getErrors()));
            }
            if ($testsHandler->delete($testsObj)) {
                \redirect_header('tests.php', 3, \_AM_WGTESTUI_FORM_DELETE_OK);
            } else {
                $GLOBALS['xoopsTpl']->assign('error', $testsObj->getHtmlErrors());
            }
        } else {
            $customConfirm = new Common\Confirm(
                ['ok' => 1, 'id' => $testId, 'start' => $start, 'limit' => $limit, 'op' => 'delete'],
                $_SERVER['REQUEST_URI'],
                \sprintf(\_AM_WGTESTUI_FORM_SURE_DELETE, $testsObj->getVar('url')));
            $form = $customConfirm->getFormConfirm();
            $GLOBALS['xoopsTpl']->assign('form', $form->render());
        }
        break;
    case 'delete_all':
        $templateMain = 'wgtestui_admin_tests.tpl';
        $GLOBALS['xoopsTpl']->assign('navigation', $adminObject->displayNavigation('tests.php'));

        if (isset($_REQUEST['ok']) && 1 === (int)$_REQUEST['ok']) {
            if (!$GLOBALS['xoopsSecurity']->check()) {
                \redirect_header('tests.php', 3, \implode(', ', $GLOBALS['xoopsSecurity']->getErrors()));
            }
            if ($testsHandler->deleteAll()) {
                \redirect_header('tests.php', 3, \_AM_WGTESTUI_FORM_DELETE_OK);
            } else {
                $GLOBALS['xoopsTpl']->assign('error', $testsObj->getHtmlErrors());
            }
        } else {
            $customConfirm = new Common\Confirm(
                ['ok' => 1, 'op' => 'delete_all'],
                $_SERVER['REQUEST_URI'], \_AM_WGTESTUI_FORM_DELETE_TABLEALL);
            $form = $customConfirm->getFormConfirm();
            $GLOBALS['xoopsTpl']->assign('form', $form->render());
        }
        break;
    case 'reset_all':
        $testsHandler->updateAll('resultcode', 0, null, true);
        $testsHandler->updateAll('resulttext', '', null, true);
        $testsHandler->updateAll('infotext', '', null, true);
        $testsHandler->updateAll('datetest', 0, null, true);
        \redirect_header('tests.php', 3, \_AM_WGTESTUI_FORM_DELETE_OK);
        break;
    case 'execute':
        // Define Stylesheet
        $GLOBALS['xoTheme']->addStylesheet($style, null);
        $templateMain = 'wgtestui_admin_tests.tpl';
        if (isset($_REQUEST['ok']) && 1 === (int)$_REQUEST['ok']) {
            $options = [];
            $cookie = '';
            $userAgent = '';
            //get http request header
            foreach (getallheaders() as $name => $value) {
                if ('Cookie' === $name) {
                    $cookie = $value;
                }
                if ('User-Agent' === $name) {
                    $userAgent = $value;
                }
            }
            $header = [
                "Accept-language: en",
                "Connection: keep-alive",
                'Cookie: ' . $cookie,
                'User-Agent: ' . $userAgent
            ];
            $options['header'] = $header;
            // get preferences
            $options['patterns_ok']        = explode("\r\n", $helper->getConfig('patterns_ok'));
            $options['patterns_fatalerror']     = explode("\r\n", $helper->getConfig('patterns_fatalerror'));
            $options['patterns_fatalerrordesc'] = explode("\r\n", $helper->getConfig('patterns_fatalerrordesc'));
            $options['patterns_warning']   = explode("\r\n", $helper->getConfig('patterns_warning'));

            $options['httpStatusCodes'] = $testsHandler->getHttpStatusCodes();
            $modhandler = xoops_getHandler('module');
            $crModules = new \CriteriaCompo();
            $crModules->add(new \Criteria('isactive', '1'));
            $moduleslist = $modhandler->getList($crModules, true);
            $testsAll = $testsHandler->getAll();
            foreach (\array_keys($testsAll) as $i) {
                $test = $testsAll[$i]->getValuesTests();
                $testUrl    = $test['url'];
                $testModule = $test['module'];
                $statusCode = 0;
                $statusText = 'skipped';
                $fatalError = '';
                $errors     = [];
                $deprecated = [];
                if ('xoopscore' === $testModule || \array_key_exists($testModule, $moduleslist)) {
                    $resCheck = $testsHandler->checkURL(XOOPS_URL . '/' . $testUrl, $options);
                    $statusCode = $resCheck['statusCode'];
                    $statusText = $resCheck['statusText'];
                    $errors     = $resCheck['errors'];
                    $deprecated = $resCheck['deprecated'];
                    $fatalError = $resCheck['fatalError'];
                }
                $infoText = '';
                if ('' !== $fatalError) {
                    $infoText .= $fatalError . PHP_EOL;
                }
                if (\count($errors) > 0) {
                    foreach ($errors as $line) {
                        $infoText .= $line . PHP_EOL;
                    }
                }
                if (\count($deprecated) > 0) {
                    foreach ($deprecated as $line) {
                        $infoText .= $line . PHP_EOL;
                    }
                }
                $testsObj = $testsHandler->get($i);
                // Set Vars
                $testsObj->setVar('resultcode', $statusCode);
                $testsObj->setVar('resulttext', $statusText);
                $testsObj->setVar('infotext', $infoText);
                $testsObj->setVar('datetest', \time());
                // Insert Data
                $testsHandler->insert($testsObj);
            }
            \redirect_header('tests.php?op=list', 2, \_AM_WGTESTUI_FORM_OK);
        } else {
            $customConfirm = new Common\Confirm(
                ['ok' => 1, 'op' => 'execute'],
                $_SERVER['REQUEST_URI'], \_AM_WGTESTUI_FORM_TEST_LABEL, _AM_WGTESTUI_FORM_TEST_CONFIRM, _AM_WGTESTUI_FORM_TEST_CONFIRM);
            $form = $customConfirm->getFormConfirm();
            $GLOBALS['xoopsTpl']->assign('form', $form->render());
            $GLOBALS['xoopsTpl']->assign('showInfoExecute', true);
        }
        break;
}
require __DIR__ . '/footer.php';
