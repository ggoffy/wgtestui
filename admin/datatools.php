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
use XoopsModules\Wgtestui\{
    DatatoolsHandler,
    Constants
};

require __DIR__ . '/header.php';

// Template Plugin
$templateMain = 'wgtestui_admin_datatools.tpl';

$op          = Request::getCmd('op', 'list');
$modGenerate = Request::getString('generate_menu_module');

// Define Stylesheet
$GLOBALS['xoTheme']->addStylesheet($style, null);

$datatoolsHandler = new DatatoolsHandler();
$formImport = $datatoolsHandler->getFormImport();
$GLOBALS['xoopsTpl']->assign('form_import', $formImport->render());
$formExport = $datatoolsHandler->getFormExport();
$GLOBALS['xoopsTpl']->assign('form_export', $formExport->render());
$formImportList = $datatoolsHandler->getFormImportList();
$GLOBALS['xoopsTpl']->assign('form_importlist', $formImportList->render());
$formGenerateMenu = $datatoolsHandler->getFormGenerateMenu($modGenerate);
$GLOBALS['xoopsTpl']->assign('form_generatemenu', $formGenerateMenu->render());


switch ($op) {
    case 'list':
    default:
        break;
    case 'generate_from_menu':
        if ('' !== $modGenerate) {
            $resultGenerate = '';
            include XOOPS_ROOT_PATH . "/modules/$modGenerate/admin/menu.php";
            foreach ($adminmenu as $menuItem) {
                $file = str_replace('admin/', '', $menuItem['link']);
                $noNewDelete = ['index.php', 'feedback.php', 'about.php', 'clone.php'];
                $resultGenerate .= '<br>' . XOOPS_URL . '/modules/' . $modGenerate . '/admin/' . $file;
                if (!\in_array($file, $noNewDelete)) {
                    $resultGenerate .= '<br>' . XOOPS_URL . '/modules/' . $modGenerate . '/admin/' . $file . '?op=new';
                    $resultGenerate .= '<br>' . XOOPS_URL . '/modules/' . $modGenerate . '/admin/' . $file . '?op=delete';
                }
            }
            $GLOBALS['xoopsTpl']->assign('resultGenerate', $resultGenerate);
        }

        break;
    case 'import':
        $datatools = Request::getArray('datatools', 'none');
        $countSuccess = 0;
        $countErrors  = 0;
        foreach($datatools as $datatool) {
            $fileJson = \WGTESTUI_PATH . '/datatools/' . $datatool . '.json';
            if ($fileContent = file_get_contents($fileJson)) {
                $countErrorsImport = 0;
                $datatoolArr = json_decode($fileContent, true);
                if (\count($datatoolArr) > 0) {
                    $crTests = new \CriteriaCompo();
                    $crTests->add(new \Criteria('module', $datatool));
                    $testsAll = $testsHandler->deleteAll($crTests, true);
                    foreach ($datatoolArr['data'] as $data) {
                        $testsObj = $testsHandler->create();
                        // Set Vars
                        $testsObj->setVar('url', $data['url']);
                        $testsObj->setVar('module', $data['module']);
                        $testsObj->setVar('area', $data['area']);
                        $testsObj->setVar('type', $data['type']);
                        $testsObj->setVar('resultcode', 0);
                        $testsObj->setVar('resulttext', '');
                        $testsObj->setVar('infotext', '');
                        //$testsObj->setVar('datetest', $testDatetest);
                        $testsObj->setVar('datecreated', \time());
                        $testsObj->setVar('submitter', $GLOBALS['xoopsUser']->uid());
                        // Insert Data
                        if (!$testsHandler->insert($testsObj)) {
                            $countErrorsImport++;
                        }
                    }
                    if (0 === $countErrorsImport) {
                        $countSuccess++;
                    }
                } else {
                    $countErrors++;
                }
            } else {
                $countErrors++;
            }
        }
        if ($countErrors > 0) {
            \redirect_header('datatools.php?op=list', 3, \_AM_WGTESTUI_DATATOOLS_JSON_IMPORT_ERROR);
        } else {
            \redirect_header('datatools.php?op=list', 3, \_AM_WGTESTUI_DATATOOLS_JSON_IMPORT_SUCCESS . $countSuccess);
        }
        break;
    case 'export':
        $datatools = Request::getArray('datatools', 'none');
        $countSuccess = 0;
        $countErrors  = 0;
        foreach($datatools as $datatool) {
            $fileJson = \WGTESTUI_PATH . '/datatools/' . $datatool . '.json';
            $datatoolArr = [];
            $moduleHandler = \xoops_getHandler('module');
            $xoopsModule = \XoopsModule::getByDirname($datatool);
            if (is_object($xoopsModule)) {
                $datatoolArr['dirname'] = $datatool;
                $datatoolArr['name'] = $xoopsModule->name();
                $datatoolArr['version'] = $xoopsModule->version();
            } else {
                if ('xoopscore' === $datatool) {
                    $datatoolArr['dirname'] = $datatool;
                    $datatoolArr['name'] = 'XOOPS Core';
                    $datatoolArr['version'] = XOOPS_VERSION;
                } else {
                    \redirect_header('datatools.php?op=list', 3, 'invalid datatool name');
                }
            }
            $datatoolData = [];
            $crTests = new \CriteriaCompo();
            $crTests->add(new \Criteria('module', $datatool));
            $testsAll = $testsHandler->getAll($crTests);
            foreach (\array_keys($testsAll) as $i) {
                $datatoolData[] = [
                    'url' => $testsAll[$i]->getVar('url'),
                    'module' => $testsAll[$i]->getVar('module'),
                    'area' => $testsAll[$i]->getVar('area'),
                    'type' => $testsAll[$i]->getVar('type')
                ];
            }
            $datatoolArr['data'] = $datatoolData;
            if (file_put_contents($fileJson, json_encode($datatoolArr, JSON_PRETTY_PRINT))) {
                $countSuccess++;
            } else {
                $countErrors++;
            }
        }
        if ($countErrors > 0) {
            \redirect_header('datatools.php?op=list', 3, \_AM_WGTESTUI_DATATOOLS_JSON_CREATED_ERROR);
        } else {
            \redirect_header('datatools.php?op=list', 3, \_AM_WGTESTUI_DATATOOLS_JSON_CREATED_SUCCESS . $countSuccess);
        }
        break;
    case 'import_list':
        $datatoolList = Request::getString('data_list');
        $testArea   = Request::getInt('area');
        $datatools = \explode(PHP_EOL, $datatoolList);
        unset($datatools['']);
        $countErrors  = 0;
        $countSuccess = 0;
        $countExist   = 0;
        foreach ($datatools as $datatool) {
            $testUrl = str_replace(XOOPS_URL . '/', '', $datatool);
            $crTests = new \CriteriaCompo();
            $crTests->add(new Criteria('url', $testUrl));
            if ($testsHandler->getCount($crTests) > 0) {
                $countExist++;
            } else {
                $testModule = '';
                $modArr = explode('/', $testUrl);
                if (\count($modArr) > 1) {
                    $testModule = $modArr[1];
                }
                $testsObj = $testsHandler->create();
                // Set Vars
                $testsObj->setVar('url', $testUrl);
                $testsObj->setVar('module', $testModule);
                $testsObj->setVar('area', $testArea);
                $testsObj->setVar('type', Constants::TYPE_HTTPREQUEST);
                $testsObj->setVar('resultcode', 0);
                $testsObj->setVar('resulttext', '');
                $testsObj->setVar('infotext', '');
                //$testsObj->setVar('datetest', $testDatetest);
                $testsObj->setVar('datecreated', \time());
                $testsObj->setVar('submitter', $GLOBALS['xoopsUser']->uid());
                // Insert Data
                if ($testsHandler->insert($testsObj)) {
                    $countSuccess++;
                } else {
                    $countErrors++;
                }
            }
        }
        $result = \_AM_WGTESTUI_DATATOOLS_LIST_IMPORT_SUCCESS . $countSuccess . '<br>';
        $result .= \_AM_WGTESTUI_DATATOOLS_LIST_IMPORT_EXIST . $countExist . '<br>';
        $result .= \_AM_WGTESTUI_DATATOOLS_LIST_IMPORT_ERROR . $countErrors . '<br>';
        \redirect_header('tests.php?op=list', 5, $result);
}

// End Test Data
require __DIR__ . '/footer.php';
