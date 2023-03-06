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
use XoopsModules\Wgtestui;
use XoopsModules\Wgtestui\Constants;
use XoopsModules\Wgtestui\Common;

require __DIR__ . '/header.php';
// Get all request values
$op         = Request::getCmd('op', 'list');
$testId     = Request::getInt('id');
$start      = Request::getInt('start');
$limit      = Request::getInt('limit', $helper->getConfig('adminpager'));
$filterM    = Request::getString('filter_m', 'all');
$filterA    = Request::getInt('filter_a');
$filterRc   = Request::getInt('filter_rc');
$filterFe   = Request::getInt('filter_fe');
$filterE    = Request::getInt('filter_e');
$filterD    = Request::getInt('filter_d');
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
        $GLOBALS['xoopsTpl']->assign('wgtestui_url', \WGTESTUI_URL);
        $GLOBALS['xoopsTpl']->assign('wgtestui_upload_url', \WGTESTUI_UPLOAD_URL);
        $GLOBALS['xoopsTpl']->assign('wgtestui_icons_url_16', \WGTESTUI_ICONS_URL . '/16');
        $GLOBALS['xoopsTpl']->assign('wgtestui_icons_url_32', \WGTESTUI_ICONS_URL . '/32');

        $GLOBALS['xoopsTpl']->assign('navigation', $adminObject->displayNavigation('tests.php'));
        if ('' !== $filterM) {
            $adminObject->addItemButton(\_AM_WGTESTUI_LIST_TESTS, 'tests.php', 'list');
        }
        $adminObject->addItemButton(\_AM_WGTESTUI_ADD_TEST, 'tests.php?op=new');
        $adminObject->addItemButton(\_AM_WGTESTUI_EXEC_TEST_ADMIN, 'tests.php?op=execute_admin', 'exec');
        $adminObject->addItemButton(\_AM_WGTESTUI_EXEC_TEST_USER, 'tests.php?op=execute_user', 'exec');
        $adminObject->addItemButton(\_AM_WGTESTUI_EXEC_TEST, 'tests.php?op=execute', 'exec');
        $adminObject->addItemButton(\_AM_WGTESTUI_RESET_TEST, 'tests.php?op=reset_all', 'delete');
        $adminObject->addItemButton(\_AM_WGTESTUI_CLEAR_TEST, 'tests.php?op=delete_all', 'delete');
        $adminObject->addItemButton(\_AM_WGTESTUI_STATISTICS, 'tests.php?op=statistics', 'stats');
        $GLOBALS['xoopsTpl']->assign('buttons', $adminObject->displayButton('left'));
        $testsCountTotal = $testsHandler->getCount();
        $crTests = new \CriteriaCompo();
        if ('all' !== $filterM) {
            $crTests->add(new \Criteria('module', $filterM));
        }
        if ($filterA > 0) {
            $crTests->add(new \Criteria('area', $filterA));
        }
        if ($filterRc > 0) {
            $crTests->add(new \Criteria('resultcode', 200, '<>'));
        }
        if ($filterFe > 0) {
            $crTests->add(new \Criteria('fatalerrors', 0, '>'));
        }
        if ($filterE > 0) {
            $crTests->add(new \Criteria('errors', 0, '>'));
        }
        if ($filterD > 0) {
            $crTests->add(new \Criteria('deprecated', 0, '>'));
        }
        $testsCount = $testsHandler->getCount($crTests);
        $GLOBALS['xoopsTpl']->assign('tests_count', $testsCount);
        // Table view tests
        if ($testsCount > 0) {
            $crTests->setStart($start);
            $crTests->setLimit($limit);
            $testsAll = $testsHandler->getAll($crTests);
            foreach (\array_keys($testsAll) as $i) {
                $test = $testsAll[$i]->getValuesTests();
                $GLOBALS['xoopsTpl']->append('tests_list', $test);
                unset($test);
            }
            // Display Navigation
            if ($testsCount > $limit) {
                require_once \XOOPS_ROOT_PATH . '/class/pagenav.php';
                $pagenav = new \XoopsPageNav($testsCount, $limit, $start, 'start', 'op=list&amp;limit=' . $limit . '&amp;module=' .$testModule);
                $GLOBALS['xoopsTpl']->assign('pagenav', $pagenav->renderNav());
            }

        } else {
            $GLOBALS['xoopsTpl']->assign('error', \_AM_WGTESTUI_THEREARENT_TESTS);
        }
        if ($testsCountTotal > 0) {
            // get filter
            $testsObjF = $testsHandler->create();
            $testsObjF->setVar('module', $filterM);
            $testsObjF->setVar('area', $filterA);
            $testsObjF->setVar('resultcode', $filterRc);
            $testsObjF->setVar('fatalerrors', $filterFe);
            $testsObjF->setVar('errors', $filterE);
            $testsObjF->setVar('deprecated', $filterD);
            $form = $testsObjF->getFormTestsFilter();
            $GLOBALS['xoopsTpl']->assign('form_filter', $form->render());
        }
        break;
    case 'statistics':
        // Define Stylesheet
        $GLOBALS['xoTheme']->addStylesheet($style, null);
        $templateMain = 'wgtestui_admin_tests.tpl';
        $GLOBALS['xoopsTpl']->assign('navigation', $adminObject->displayNavigation('tests.php'));
        $adminObject->addItemButton(\_AM_WGTESTUI_LIST_TESTS, 'tests.php', 'list');
        $GLOBALS['xoopsTpl']->assign('buttons', $adminObject->displayButton('left'));
        $GLOBALS['xoopsTpl']->assign('wgtestui_icons_url_16', \WGTESTUI_ICONS_URL . '/16');

        $testsCount = $testsHandler->getCountTests();// Table view tests
        if ($testsCount > 0) {
            $sql = 'SELECT `module`, ';
            $sql .= 'count(`id`) as countid, ';
            $sql .= 'sum(IF(`resultcode` = 200, 1, 0)) as count200, ';
            $sql .= 'sum(`fatalerrors`) as count_fe, ';
            $sql .= 'sum(`errors`) as count_e, ';
            $sql .= 'sum(`deprecated`) as count_d, ';
            $sql .= 'sum(IF(STRCMP("",`infotext`) = 0, 0, 1)) as countinfo ';
            $sql .= 'FROM `'  . $GLOBALS['xoopsDB']->prefix('wgtestui_tests') . '` GROUP BY `module`';
            $result = $GLOBALS['xoopsDB']->queryF($sql);
            if (!$result instanceof \mysqli_result) {
                \trigger_error($GLOBALS['xoopsDB']->error());
            }
            $statistics = [];
            while (false !== ($row = $GLOBALS['xoopsDB']->fetchRow($result))) {
                $statistics[] = [
                    'module' => $row[0],
                    'tests' => $row[1],
                    'status200' => $row[2],
                    'status200ok' => ((int)$row[1] === (int)$row[2]),
                    'fatalerrors' => $row[3],
                    'errors' => $row[4],
                    'deprecated' => $row[5],
                    'info' => $row[6],
                    'show_details' => ((int)$row[1] !== (int)$row[2] || (int)$row[3] > 0 || (int)$row[4] > 0 || (int)$row[5] > 0)
                ];
            }
            if (\count($statistics) > 0) {
                $GLOBALS['xoopsTpl']->assign('statistics', $statistics);
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
        $testUrl = str_replace(XOOPS_URL . '/', '', Request::getString('url'));
        if ($testId > 0) {
            $testsObj = $testsHandler->get($testId);
        } else {
            //check whether given url already exists in database
            $crTests = new \CriteriaCompo();
            $crTests->add(new Criteria('url', $testUrl));
            if ($testsHandler->getCount($crTests) > 0) {
                \redirect_header('tests.php?op=list', 3, \_AM_WGTESTUI_TEST_URL_EXISTS);
            }
            $testsObj = $testsHandler->create();
        }
        // Set Vars

        $testModule = '';
        $modArr = explode('/', $testUrl);
        if (\count($modArr) > 1) {
            $testModule = $modArr[1];
        }
        $testsObj->setVar('url', $testUrl);
        $testsObj->setVar('module', $testModule);
        $testsObj->setVar('area', Request::getInt('area'));
        $testsObj->setVar('type', Request::getInt('type'));
        $testsObj->setVar('resultcode', Request::getString('resultcode', '0'));
        $testsObj->setVar('resulttext', Request::getString('resulttext'));
        $testsObj->setVar('infotext', Request::getText('infotext'));
        if ($testId > 0) {
            $testDatetestArr = Request::getArray('datetest');
            $testDatetestObj = \DateTime::createFromFormat(\_SHORTDATESTRING, $testDatetestArr['date']);
            $testDatetestObj->setTime(0, 0, 0);
            $testDatetest = $testDatetestObj->getTimestamp() + (int)$testDatetestArr['time'];
            $testsObj->setVar('datetest', $testDatetest);
        } else {
            $testsObj->setVar('datetest', 0);
        }
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
    case 'execute_admin':
    case 'execute_user':
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

            $crTests = new \CriteriaCompo();
            if ('execute_admin' === $op) {
                $crTests->add(new \Criteria('area', Constants::AREA_ADMIN));
            }
            if ('execute_user' === $op) {
                $crTests->add(new \Criteria('area', Constants::AREA_USER));
            }
            $testsAll = $testsHandler->getAll($crTests);
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
                $testsObj->setVar('fatalerrors', '' !== $fatalError ? 1 : 0);
                $testsObj->setVar('errors', \count($errors));
                $testsObj->setVar('deprecated', \count($deprecated));
                $testsObj->setVar('infotext', $infoText);
                $testsObj->setVar('datetest', \time());
                // Insert Data
                $testsHandler->insert($testsObj);
            }
            \redirect_header('tests.php?op=list', 2, \_AM_WGTESTUI_FORM_OK);
        } else {
            $label = \_AM_WGTESTUI_FORM_TEST_CONFIRM_ALL;
            if ('execute_admin' === $op) {
                $label = \_AM_WGTESTUI_FORM_TEST_CONFIRM_ADMIN;
            }
            if ('execute_user' === $op) {
                $label = \_AM_WGTESTUI_FORM_TEST_CONFIRM_USER;
            }
            $customConfirm = new Common\Confirm(
                ['ok' => 1, 'op' => $op],
                $_SERVER['REQUEST_URI'], \_AM_WGTESTUI_FORM_TEST_LABEL, \_AM_WGTESTUI_FORM_TEST_CONFIRM, $label);
            $form = $customConfirm->getFormConfirm();
            $GLOBALS['xoopsTpl']->assign('form', $form->render());
            $GLOBALS['xoopsTpl']->assign('showInfoExecute', true);
        }
        break;
}
require __DIR__ . '/footer.php';
