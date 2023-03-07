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
 * @copyright    2023 XOOPS Project (https://xoops.org)
 * @license      GPL 2.0 or later
 * @package      wgtestui
 * @author       Goffy - XOOPS Development Team - Email:<webmaster@wedega.com> - Website:<https://xoops.wedega.com>
 */

use XoopsModules\Wgtestui;
use XoopsModules\Wgtestui\Form\FormInline;

\defined('XOOPS_ROOT_PATH') || die('Restricted access');

/**
 * Class Object Tests
 */
class Tests extends \XoopsObject
{
    /**
     * @var int
     */
    public $start = 0;

    /**
     * @var int
     */
    public $limit = 0;

    /**
     * Constructor
     *
     * @param null
     */
    public function __construct()
    {
        $this->initVar('id', \XOBJ_DTYPE_INT);
        $this->initVar('url', \XOBJ_DTYPE_TXTBOX);
        $this->initVar('module', \XOBJ_DTYPE_TXTBOX);
        $this->initVar('area', \XOBJ_DTYPE_INT);
        $this->initVar('type', \XOBJ_DTYPE_INT);
        $this->initVar('resultcode', \XOBJ_DTYPE_INT);
        $this->initVar('resulttext', \XOBJ_DTYPE_TXTBOX);
        $this->initVar('fatalerrors', \XOBJ_DTYPE_INT);
        $this->initVar('errors', \XOBJ_DTYPE_INT);
        $this->initVar('deprecated', \XOBJ_DTYPE_INT);
        $this->initVar('infotext', \XOBJ_DTYPE_TXTAREA);
        $this->initVar('datetest', \XOBJ_DTYPE_INT);
        $this->initVar('datecreated', \XOBJ_DTYPE_INT);
        $this->initVar('submitter', \XOBJ_DTYPE_INT);
    }

    /**
     * @static function &getInstance
     *
     * @param null
     */
    public static function getInstance()
    {
        static $instance = false;
        if (!$instance) {
            $instance = new self();
        }
    }

    /**
     * The new inserted $Id
     * @return inserted id
     */
    public function getNewInsertedIdTests()
    {
        $newInsertedId = $GLOBALS['xoopsDB']->getInsertId();
        return $newInsertedId;
    }

    /**
     * @public function getForm
     * @param bool $action
     * @return \XoopsThemeForm
     */
    public function getFormTests($action = false)
    {
        $helper = \XoopsModules\Wgtestui\Helper::getInstance();
        if (!$action) {
            $action = $_SERVER['REQUEST_URI'];
        }
        // Title
        $isNew = $this->isNew();
        $title = $isNew ? \_AM_WGTESTUI_TEST_ADD : \_AM_WGTESTUI_TEST_EDIT;
        // Get Theme Form
        \xoops_load('XoopsFormLoader');
        $form = new \XoopsThemeForm($title, 'form', $action, 'post', true);
        $form->setExtra('enctype="multipart/form-data"');
        // Form Text testUrl
        $form->addElement(new \XoopsFormText(\_AM_WGTESTUI_TEST_URL, 'url', 100, 255, $this->getVar('url')));
        // Tests Handler
        $testsHandler = $helper->getHandler('Tests');
        // Form Select testArea
        $testAreaSelect = new \XoopsFormSelect(\_AM_WGTESTUI_TEST_AREA, 'area', $this->getVar('area'));
        $testAreaSelect->addOption(Constants::AREA_ADMIN,'ADMIN');
        $testAreaSelect->addOption(Constants::AREA_USER,'USER');
        $form->addElement($testAreaSelect);
        // Form Select testType
        if ($isNew) {
            $form->addElement(new \XoopsFormHidden('type', 1));
        } else {
            /*currently only HTTPREQUEST is used*/
            /*
            $testTypeSelect = new \XoopsFormSelect(\_AM_WGTESTUI_TEST_TYPE, 'type', $this->getVar('type'));
            $testTypeSelect->addOption(1,'HTTPREQUEST');
            $form->addElement($testTypeSelect);
            */
            $form->addElement(new \XoopsFormHidden('type', 1));
        }
        // Form Text testResultcode
        if (!$isNew) {
            $form->addElement(new \XoopsFormText(\_AM_WGTESTUI_TEST_RESULTCODE, 'resultcode', 50, 255, $this->getVar('resultcode')));
        }
        // Form Text testResulttext
        if (!$isNew) {
            $form->addElement(new \XoopsFormText(\_AM_WGTESTUI_TEST_RESULTTEXT, 'resulttext', 50, 255, $this->getVar('resulttext')));
        }
        // Form Text testFatalerrors
        if (!$isNew) {
            $form->addElement(new \XoopsFormText(\_AM_WGTESTUI_TEST_FATALERRORS,  'fatalerrors', 50, 255, $this->getVar('fatalerrors')));
         }
        // Form Text testErros
        if (!$isNew) {
            $form->addElement(new \XoopsFormText(\_AM_WGTESTUI_TEST_ERRORS, 'errors', 50, 255, $this->getVar('errors')));
        }
        // Form Text testDeprecated
        if (!$isNew) {
            $form->addElement(new \XoopsFormText(\_AM_WGTESTUI_TEST_DEPRECATED, 'deprecated', 50, 255, $this->getVar('deprecated')));
        }
        // Form Editor TextArea testInfotext
        if (!$isNew) {
            $form->addElement(new \XoopsFormTextArea(\_AM_WGTESTUI_TEST_INFOTEXT, 'infotext', $this->getVar('infotext', 'e'), 4, 47));
        }
        // Form Text Date Select testDatetest
        if (!$isNew) {
            $testDatetest = $this->isNew() ? \time() : $this->getVar('datetest');
            $form->addElement(new \XoopsFormDateTime(\_AM_WGTESTUI_TEST_DATETEST, 'datetest', '', $testDatetest));
            // Form Text Date Select testDatecreated
            $testDatecreated = $this->isNew() ? \time() : $this->getVar('datecreated');
            $form->addElement(new \XoopsFormDateTime(\_AM_WGTESTUI_TEST_DATECREATED, 'datecreated', '', $testDatecreated));
        }
        // Form Select User testSubmitter
        $uidCurrent = \is_object($GLOBALS['xoopsUser']) ? $GLOBALS['xoopsUser']->uid() : 0;
        $testSubmitter = $this->isNew() ? $uidCurrent : $this->getVar('submitter');
        $form->addElement(new \XoopsFormSelectUser(\_AM_WGTESTUI_TEST_SUBMITTER, 'submitter', false, $testSubmitter));
        // To Save
        $form->addElement(new \XoopsFormHidden('op', 'save'));
        $form->addElement(new \XoopsFormHidden('start', $this->start));
        $form->addElement(new \XoopsFormHidden('limit', $this->limit));
        $form->addElement(new \XoopsFormButtonTray('', \_SUBMIT, 'submit', '', false));
        return $form;
    }

    /**
     * Get Values
     * @param null $keys
     * @param null $format
     * @param null $maxDepth
     * @return array
     */
    public function getValuesTests($keys = null, $format = null, $maxDepth = null)
    {
        $helper  = \XoopsModules\Wgtestui\Helper::getInstance();
        $utility = new \XoopsModules\Wgtestui\Utility();
        $editorMaxchar = $helper->getConfig('editor_maxchar');
        $ret = $this->getValues($keys, $format, $maxDepth);
        $ret['area_text']        = $this->getVar('area') == Constants::AREA_ADMIN ? 'ADMIN' : 'USER';
        $ret['type_text']        = $this->getVar('type') == 1 ? 'HTTPREQUEST' : 'invalid';
        $ret['infotext']         = $this->getVar('infotext', 'e');
        $ret['infotext_br']      = \str_replace(PHP_EOL, '<br>', $ret['infotext']);
        $ret['infotext_short']   = $utility::truncateHtml($ret['infotext'], $editorMaxchar);
        $ret['datetest_text']    = $this->getVar('datetest') > 0 ? \formatTimestamp($this->getVar('datetest'), 'm') : '';
        $ret['datecreated_text'] = \formatTimestamp($this->getVar('datecreated'), 'm');
        $ret['submitter_text']   = \XoopsUser::getUnameFromId($this->getVar('submitter'));
        return $ret;
    }

    /**
     * Returns an array representation of the object
     *
     * @return array
     */
    public function toArrayTests()
    {
        $ret = [];
        $vars = $this->getVars();
        foreach (\array_keys($vars) as $var) {
            $ret[$var] = $this->getVar($var);
        }
        return $ret;
    }

    /**
     * @public function to get form for filtering test list
     * @param bool $action
     * @return FormInline
     */
    public function getFormTestsFilter($action = false)
    {
        if (!$action) {
            $action = $_SERVER['REQUEST_URI'];
        }

        // Get Theme Form
        \xoops_load('XoopsFormLoader');
        $form = new FormInline('', 'form', $action, 'post', true);
        $form->setExtra('enctype="multipart/form-data"');
        // Form Select module
        $filtermSelect = new \XoopsFormSelect(\_AM_WGTESTUI_TEST_MODULE, 'filter_m', $this->getVar('module'));
        $sql = 'SELECT `module` FROM `'  . $GLOBALS['xoopsDB']->prefix('wgtestui_tests') . '` GROUP BY `module`';
        $result = $GLOBALS['xoopsDB']->queryF($sql);
        if (!$result instanceof \mysqli_result) {
            \trigger_error($GLOBALS['xoopsDB']->error());
        }
        $filtermSelect->addOption('all', \_ALL);
        while (false !== ($row = $GLOBALS['xoopsDB']->fetchRow($result))) {
            $filtermSelect->addOption($row[0], $row[0]);
        }
        $filtermSelect->setExtra(" onchange='submit()' ");
        $form->addElement($filtermSelect);
        // Form Select testArea
        $filteraSelect = new \XoopsFormSelect(\_AM_WGTESTUI_TEST_AREA, 'filter_a', $this->getVar('area'));
        $filteraSelect->addOption(0, \_ALL);
        $filteraSelect->addOption(Constants::AREA_ADMIN,'ADMIN');
        $filteraSelect->addOption(Constants::AREA_USER,'USER');
        $filteraSelect->setExtra(" onchange='submit()' ");
        $form->addElement($filteraSelect);
        // Form Select testType
        /*currently only HTTPREQUEST is used*/
        /*
        $testTypeSelect = new \XoopsFormSelect(\_AM_WGTESTUI_TEST_TYPE, 'type', $this->getVar('type'));
        $testTypeSelect->addOption(1,'HTTPREQUEST');
        $form->addElement($testTypeSelect);
        */
        // Form Text testResultcode
        $filterrcSelect = new \XoopsFormSelect(\_AM_WGTESTUI_TEST_RESULTCODE, 'filter_rc', $this->getVar('resultcode'));
        $filterrcSelect->addOption(0,\_ALL);
        $filterrcSelect->addOption(1,'<>200');
        $filterrcSelect->setExtra(" onchange='submit()' ");
        $form->addElement($filterrcSelect);
        // Form Text testFatalerrors
        $filterfeSelect = new \XoopsFormSelect(\_AM_WGTESTUI_TEST_FATALERRORS, 'filter_fe', $this->getVar('fatalerrors'));
        $filterfeSelect->addOption(0,\_ALL);
        $filterfeSelect->addOption(1,'> 0');
        $filterfeSelect->setExtra(" onchange='submit()' ");
        $form->addElement($filterfeSelect);
        // Form Text testErros
        $filtereSelect = new \XoopsFormSelect(\_AM_WGTESTUI_TEST_ERRORS, 'filter_e', $this->getVar('errors'));
        $filtereSelect->addOption(0,\_ALL);
        $filtereSelect->addOption(1,'> 0');
        $filtereSelect->setExtra(" onchange='submit()' ");
        $form->addElement($filtereSelect);
        // Form Text testDeprecated
        $filterdSelect = new \XoopsFormSelect(\_AM_WGTESTUI_TEST_DEPRECATED, 'filter_d', $this->getVar('deprecated'));
        $filterdSelect->addOption(0,\_ALL);
        $filterdSelect->addOption(1,'> 0');
        $filterdSelect->setExtra(" onchange='submit()' ");
        $form->addElement($filterdSelect);

        // To Save
        $form->addElement(new \XoopsFormHidden('op', 'list'));
        return $form;
    }
}
