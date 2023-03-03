<?php

declare(strict_types=1);


namespace XoopsModules\Wgtestui;

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

use XoopsModules\Wgtestui;


/**
 * Class Handler Plugins
 */
class PluginsHandler
{

    /**
     * Constructor
     *
     */
    public function __construct()
    {
    }

    /**
     * @public function getForm
     * @param bool $action
     * @return \XoopsThemeForm
     */
    public function getFormImport($action = false)
    {
        $helper = \XoopsModules\Wgtestui\Helper::getInstance();
        if (!$action) {
            $action = $_SERVER['REQUEST_URI'];
        }
                // Get Theme Form
        \xoops_load('XoopsFormLoader');
        $form = new \XoopsThemeForm(\_AM_WGTESTUI_PLUGINS_FORM_IMPORT, 'form', $action, 'post', true);
        $form->setExtra('enctype="multipart/form-data"');

        // Form Select testArea
        $pluginSelect = new \XoopsFormSelect(\_AM_WGTESTUI_PLUGINS_FORM_IMPORT_SELECT, 'plugins', '', 5, true);
        $pluginSelect->setDescription(\_AM_WGTESTUI_PLUGINS_FORM_IMPORT_SELECT_DESC);
        $filesArr = \XoopsLists::getFileListAsArray(\WGTESTUI_PATH . '/plugins/');
        unset($filesArr['index.php']);
        foreach ($filesArr as $file) {
            $pluginName = \str_replace('.json', '', $file);
            $pluginSelect->addOption($pluginName,$pluginName);
        }
        $form->addElement($pluginSelect, true);
        // To Save
        $form->addElement(new \XoopsFormHidden('op', 'import'));
        $form->addElement(new \XoopsFormButtonTray('', \_SUBMIT, 'submit', '', false));
        return $form;
    }

    /**
     * @public function getForm
     * @param bool $action
     * @return \XoopsThemeForm
     */
    public function getFormExport($action = false)
    {
        $helper = \XoopsModules\Wgtestui\Helper::getInstance();
        if (!$action) {
            $action = $_SERVER['REQUEST_URI'];
        }
        // Get Theme Form
        \xoops_load('XoopsFormLoader');
        $form = new \XoopsThemeForm(\_AM_WGTESTUI_PLUGINS_FORM_EXPORT, 'form', $action, 'post', true);
        $form->setExtra('enctype="multipart/form-data"');

        // Form Select testArea
        $pluginSelect = new \XoopsFormSelect(\_AM_WGTESTUI_PLUGINS_FORM_EXPORT_SELECT, 'plugins', '', 5, true);
        $sql = 'SELECT `module` FROM `'  . $GLOBALS['xoopsDB']->prefix('wgtestui_tests') . '` GROUP BY `module`';

        $result = $GLOBALS['xoopsDB']->queryF($sql);
        if (!$result instanceof \mysqli_result) {
            \trigger_error($GLOBALS['xoopsDB']->error());
        }
        while (false !== ($row = $GLOBALS['xoopsDB']->fetchRow($result))) {
            $pluginSelect->addOption($row[0], $row[0]);
        }
        $form->addElement($pluginSelect, true);
        // To Save
        $form->addElement(new \XoopsFormHidden('op', 'export'));
        $form->addElement(new \XoopsFormButtonTray('', \_SUBMIT, 'submit', '', false));
        return $form;
    }

}
