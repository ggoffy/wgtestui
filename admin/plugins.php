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
//use XoopsModules\Wgtestui\Common;

require __DIR__ . '/header.php';

// Template Plugin
$templateMain = 'wgtestui_admin_plugins.tpl';

$op      = Request::getCmd('op', 'list');
$plugins = Request::getArray('plugins', 'none');

// Define Stylesheet
$GLOBALS['xoTheme']->addStylesheet($style, null);

$formImport = $pluginsHandler->getFormImport();
$GLOBALS['xoopsTpl']->assign('form_import', $formImport->render());
$formExport = $pluginsHandler->getFormExport();
$GLOBALS['xoopsTpl']->assign('form_export', $formExport->render());

switch ($op) {
    case 'list':
    default:
        break;
    case 'import':
        $countSuccess = 0;
        $countErrors  = 0;
        foreach($plugins as $plugin) {
            $fileJson = \WGTESTUI_PATH . '/plugins/' . $plugin . '.json';
            if ($fileContent = file_get_contents($fileJson)) {
                $countErrorsImport = 0;
                $pluginArr = json_decode($fileContent, true);
                if (\count($pluginArr) > 0) {
                    $crTests = new \CriteriaCompo();
                    $crTests->add(new \Criteria('module', $plugin));
                    $testsAll = $testsHandler->deleteAll($crTests, true);
                    foreach ($pluginArr['data'] as $data) {
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
            \redirect_header('plugins.php?op=list', 3, \_AM_WGTESTUI_PLUGINS_JSON_IMPORT_ERROR);
        } else {
            \redirect_header('plugins.php?op=list', 3, \_AM_WGTESTUI_PLUGINS_JSON_IMPORT_SUCCESS . $countSuccess);
        }
        break;
    case 'export':
        $countSuccess = 0;
        $countErrors  = 0;
        foreach($plugins as $plugin) {
            $fileJson = \WGTESTUI_PATH . '/plugins/' . $plugin . '.json';
            $pluginArr = [];
            $moduleHandler = \xoops_getHandler('module');
            $xoopsModule = \XoopsModule::getByDirname($plugin);
            if (is_object($xoopsModule)) {
                $pluginArr['dirname'] = $plugin;
                $pluginArr['name'] = $xoopsModule->name();
                $pluginArr['version'] = $xoopsModule->version();
            } else {
                if ('xoopscore' === $plugin) {
                    $pluginArr['dirname'] = $plugin;
                    $pluginArr['name'] = 'XOOPS Core';
                    $pluginArr['version'] = XOOPS_VERSION;
                } else {
                    \redirect_header('plugins.php?op=list', 3, 'invalid plugin name');
                }
            }
            $pluginData = [];
            $crTests = new \CriteriaCompo();
            $crTests->add(new \Criteria('module', $plugin));
            $testsAll = $testsHandler->getAll($crTests);
            foreach (\array_keys($testsAll) as $i) {
                $pluginData[] = [
                    'url' => $testsAll[$i]->getVar('url'),
                    'module' => $testsAll[$i]->getVar('module'),
                    'area' => $testsAll[$i]->getVar('area'),
                    'type' => $testsAll[$i]->getVar('type')
                ];
            }
            $pluginArr['data'] = $pluginData;
            if (file_put_contents($fileJson, json_encode($pluginArr, JSON_PRETTY_PRINT))) {
                $countSuccess++;
            } else {
                $countErrors++;
            }
        }
        if ($countErrors > 0) {
            \redirect_header('plugins.php?op=list', 3, \_AM_WGTESTUI_PLUGINS_JSON_CREATED_ERROR);
        } else {
            \redirect_header('plugins.php?op=list', 3, \_AM_WGTESTUI_PLUGINS_JSON_CREATED_SUCCESS . $countSuccess);
        }
        break;
}

// End Test Data
require __DIR__ . '/footer.php';
