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

use XoopsModules\Wgtestui\Constants;


/**
 * Class Handler Datatools
 */
class DatatoolsHandler
{

    /**
     * Constructor
     *
     */
    public function __construct()
    {
    }

    /**
     * @public function get form import
     * import data from file in folder / datatools
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
        $form = new \XoopsThemeForm(\_AM_WGTESTUI_DATATOOLS_FORM_IMPORT, 'form', $action, 'post', true);
        $form->setExtra('enctype="multipart/form-data"');

        // Form Select testArea
        $pluginSelect = new \XoopsFormSelect(\_AM_WGTESTUI_DATATOOLS_FORM_IMPORT_SELECT, 'datatools', '', 5, true);
        $pluginSelect->setDescription(\_AM_WGTESTUI_DATATOOLS_FORM_IMPORT_SELECT_DESC);
        $filesArr = \XoopsLists::getFileListAsArray(\WGTESTUI_PATH . '/datatools/');
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
     * @public function get form export
     * export data to file in folder / datatools
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
        $form = new \XoopsThemeForm(\_AM_WGTESTUI_DATATOOLS_FORM_EXPORT, 'form', $action, 'post', true);
        $form->setExtra('enctype="multipart/form-data"');

        // Form Select datatool
        $datatoolsSelect = new \XoopsFormSelect(\_AM_WGTESTUI_DATATOOLS_FORM_EXPORT_SELECT, 'datatools', '', 5, true);
        $sql = 'SELECT `module` FROM `'  . $GLOBALS['xoopsDB']->prefix('wgtestui_tests') . '` GROUP BY `module`';

        $result = $GLOBALS['xoopsDB']->queryF($sql);
        if (!$result instanceof \mysqli_result) {
            \trigger_error($GLOBALS['xoopsDB']->error());
        }
        while (false !== ($row = $GLOBALS['xoopsDB']->fetchRow($result))) {
            $datatoolsSelect->addOption($row[0], $row[0]);
        }
        $form->addElement($datatoolsSelect, true);
        // To Save
        $form->addElement(new \XoopsFormHidden('op', 'export'));
        $form->addElement(new \XoopsFormButtonTray('', \_SUBMIT, 'submit', '', false));
        return $form;
    }

    /**
     * @public function get form list
     * import data from a text list in folder / datatools
     * @param bool $action
     * @return \XoopsThemeForm
     */
    public function getFormImportList($action = false)
    {
        $helper = \XoopsModules\Wgtestui\Helper::getInstance();
        if (!$action) {
            $action = $_SERVER['REQUEST_URI'];
        }
        // Get Theme Form
        \xoops_load('XoopsFormLoader');
        $form = new \XoopsThemeForm(\_AM_WGTESTUI_DATATOOLS_FORM_IMPORT, 'form', $action, 'post', true);
        $form->setExtra('enctype="multipart/form-data"');

        // Form Editor TextArea pluginList
        $pluginList = new \XoopsFormTextArea(\_AM_WGTESTUI_DATATOOLS_FORM_IMPORT_LIST, 'data_list', '', 15, 47);
        $pluginList->setDescription(\_AM_WGTESTUI_DATATOOLS_FORM_IMPORT_LIST_DESC);
        $form->addElement($pluginList);
        // Form Select testArea
        $testAreaSelect = new \XoopsFormSelect(\_AM_WGTESTUI_TEST_AREA, 'area', Constants::AREA_ADMIN);
        $testAreaSelect->addOption(Constants::AREA_ADMIN,'ADMIN');
        $testAreaSelect->addOption(Constants::AREA_USER,'USER');
        $form->addElement($testAreaSelect);

        // To Save
        $form->addElement(new \XoopsFormHidden('op', 'import_list'));
        $form->addElement(new \XoopsFormButtonTray('', \_SUBMIT, 'submit', '', false));
        return $form;
    }

}
