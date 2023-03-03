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
        $this->initVar('resultcode', \XOBJ_DTYPE_TXTBOX);
        $this->initVar('resulttext', \XOBJ_DTYPE_TXTBOX);
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
        $title = $this->isNew() ? \_AM_WGTESTUI_TEST_ADD : \_AM_WGTESTUI_TEST_EDIT;
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
        $testAreaSelect->addOption(1,'ADMIN');
        $testAreaSelect->addOption(2,'USER');
        $form->addElement($testAreaSelect);
        // Tests Handler
        $testsHandler = $helper->getHandler('Tests');
        // Form Select testType
        $testTypeSelect = new \XoopsFormSelect(\_AM_WGTESTUI_TEST_TYPE, 'type', $this->getVar('type'));
        $testTypeSelect->addOption(1,'HTTPREQUEST');
        $form->addElement($testTypeSelect);
        // Form Text testResultcode
        $form->addElement(new \XoopsFormText(\_AM_WGTESTUI_TEST_RESULTCODE, 'resultcode', 50, 255, $this->getVar('resultcode')));
        // Form Text testResulttext
        $form->addElement(new \XoopsFormText(\_AM_WGTESTUI_TEST_RESULTTEXT, 'resulttext', 50, 255, $this->getVar('resulttext')));
        // Form Editor TextArea testInfotext
        $form->addElement(new \XoopsFormTextArea(\_AM_WGTESTUI_TEST_INFOTEXT, 'infotext', $this->getVar('infotext', 'e'), 4, 47));
        // Form Text Date Select testDatetest
        $testDatetest = $this->isNew() ? \time() : $this->getVar('datetest');
        $form->addElement(new \XoopsFormDateTime(\_AM_WGTESTUI_TEST_DATETEST, 'datetest', '', $testDatetest));
        // Form Text Date Select testDatecreated
        $testDatecreated = $this->isNew() ? \time() : $this->getVar('datecreated');
        $form->addElement(new \XoopsFormDateTime(\_AM_WGTESTUI_TEST_DATECREATED, 'datecreated', '', $testDatecreated));
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
        $ret = $this->getValues($keys, $format, $maxDepth);
        //$ret['id']               = $this->getVar('id');
        //$ret['url']              = $this->getVar('url');
        //$ret['module']           = $this->getVar('module');
        $ret['area_text']             = $this->getVar('area') == 1 ? 'ADMIN' : 'USER';
        $ret['type_text']             = $this->getVar('type') == 1 ? 'HTTPREQUEST' : 'invalid';
        //$ret['resultcode']       = $this->getVar('resultcode');
        //$ret['resulttext']       = $this->getVar('resulttext');
        $ret['infotext']       = \strip_tags($this->getVar('infotext', 'e'));
        $editorMaxchar = $helper->getConfig('editor_maxchar');
        $ret['infotext_short'] = $utility::truncateHtml($ret['infotext'], $editorMaxchar);
        $ret['datetest_text']         = $this->getVar('datetest') > 0 ? \formatTimestamp($this->getVar('datetest'), 'm') : '';
        $ret['datecreated_text']      = \formatTimestamp($this->getVar('datecreated'), 'm');
        $ret['submitter_text']        = \XoopsUser::getUnameFromId($this->getVar('submitter'));
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
}
