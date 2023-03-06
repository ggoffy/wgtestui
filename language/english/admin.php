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

require_once __DIR__ . '/common.php';

// ---------------- Admin Index ----------------
\define('_AM_WGTESTUI_STATISTICS', 'Statistics');
// There are
\define('_AM_WGTESTUI_THEREARE_TESTS', "There are <span class='bold'>%s</span> tests in the database");
// ---------------- Admin Files ----------------
// There aren't
\define('_AM_WGTESTUI_THEREARENT_TESTS', "There aren't tests");
// Save/Delete
\define('_AM_WGTESTUI_FORM_OK', 'Successfully saved');
\define('_AM_WGTESTUI_FORM_DELETE_OK', 'Successfully deleted');
\define('_AM_WGTESTUI_FORM_SURE_DELETE', "Are you sure to delete: <b><span style='color : Red;'>%s </span></b>");
\define('_AM_WGTESTUI_FORM_SURE_RENEW', "Are you sure to update: <b><span style='color : Red;'>%s </span></b>");
\define('_AM_WGTESTUI_FORM_DELETE_CONFIRM', 'Confirm delete');
\define('_AM_WGTESTUI_FORM_DELETE_LABEL', 'Do you really want to delete:');
\define('_AM_WGTESTUI_FORM_TEST_CONFIRM', 'Confirm execute test');
\define('_AM_WGTESTUI_FORM_TEST_CONFIRM_ALL', 'Confirm execute all tests');
\define('_AM_WGTESTUI_FORM_TEST_CONFIRM_ADMIN', 'Confirm execute tests area "ADMIN"');
\define('_AM_WGTESTUI_FORM_TEST_CONFIRM_USER', 'Confirm execute test area "USER"');
\define('_AM_WGTESTUI_FORM_TEST_LABEL', 'Do you want to start now');
\define('_AM_WGTESTUI_TEST_INFO_EXEC1', 'Before starting the tests you should:');
\define('_AM_WGTESTUI_TEST_INFO_EXEC2', 'Enable debug mode inline, in order to get information about errors, notices and warnings');
\define('_AM_WGTESTUI_TEST_INFO_EXEC3', 'Disable module Protector, because otherwise it can be that you are blocked because of the high number of requests within a short time');
\define('_AM_WGTESTUI_TEST_INFO_EXEC4', 'If you want to analyse a hugh number of urls then it is maybe necessary to increase the value for "maximum execution time" in your php settings');
\define('_AM_WGTESTUI_TEST_INFO_EXEC5', 'If you execute the analysis, only tests with "Result code = 0" will be executed. If you want to re-analyse all uls then you have to reset test results before.');
// Buttons
\define('_AM_WGTESTUI_ADD_TEST', 'Add New Test');
\define('_AM_WGTESTUI_EXEC_TEST', 'Execute All Tests');
\define('_AM_WGTESTUI_EXEC_TEST_ADMIN', 'Execute Tests ADMIN');
\define('_AM_WGTESTUI_EXEC_TEST_USER', 'Execute Tests USER');
\define('_AM_WGTESTUI_RESET_TEST', 'Reset Test Results');
\define('_AM_WGTESTUI_CLEAR_TEST', 'Clear Table Test');
// Lists
\define('_AM_WGTESTUI_LIST_TESTS', 'List of Tests');
// ---------------- Admin Classes ----------------
// Test add/edit
\define('_AM_WGTESTUI_TEST_ADD', 'Add Test');
\define('_AM_WGTESTUI_TEST_EDIT', 'Edit Test');
// Elements of Test
\define('_AM_WGTESTUI_TEST_ID', 'Id');
\define('_AM_WGTESTUI_TEST_URL', 'Url');
\define('_AM_WGTESTUI_TEST_MODULE', 'Module');
\define('_AM_WGTESTUI_TEST_AREA', 'Area');
\define('_AM_WGTESTUI_TEST_TYPE', 'Type');
\define('_AM_WGTESTUI_TEST_RESULTCODE', 'Result code');
\define('_AM_WGTESTUI_TEST_RESULTTEXT', 'Result text');
\define('_AM_WGTESTUI_TEST_FATALERRORS', 'Fatal errors');
\define('_AM_WGTESTUI_TEST_ERRORS', 'Errors');
\define('_AM_WGTESTUI_TEST_DEPRECATED', 'Deprecated');
\define('_AM_WGTESTUI_TEST_INFOTEXT', 'Info text');
\define('_AM_WGTESTUI_TEST_DATETEST', 'Datetest');
\define('_AM_WGTESTUI_TEST_DATECREATED', 'Datecreated');
\define('_AM_WGTESTUI_TEST_SUBMITTER', 'Submitter');
// others tests
\define('_AM_WGTESTUI_TEST_DETAILS', 'Show test details');
\define('_AM_WGTESTUI_TEST_RESULTS', 'Details result check of:');
\define('_AM_WGTESTUI_TEST_URL_ADDED', 'Current url added to test database');
\define('_AM_WGTESTUI_TEST_URL_EXISTS', 'The current url exists alreday in the database');
\define('_AM_WGTESTUI_TEST_URL_ERROR', 'Sorry, an error occured when trying to add url in the database');
\define('_AM_WGTESTUI_TEST_STATS_TESTS', 'Number of tests');
\define('_AM_WGTESTUI_TEST_STATS_STATUS200', 'Number of status 200');
\define('_AM_WGTESTUI_TEST_STATS_INFO', 'Number of information');
\define('_AM_WGTESTUI_TEST_ANALYSIS_DONE', 'Result of analysis saved successfully. Number of analysis done: %s');
// datatools
\define('_AM_WGTESTUI_DATATOOLS_FORM_IMPORT', 'Import datatools');
\define('_AM_WGTESTUI_DATATOOLS_FORM_IMPORT_SELECT', 'Select the datatool for import file into list of tests');
\define('_AM_WGTESTUI_DATATOOLS_FORM_IMPORT_SELECT_DESC', 'Pay attention: existing data for these module will be deleted!');
\define('_AM_WGTESTUI_DATATOOLS_FORM_IMPORT_LIST', 'Enter list of links');
\define('_AM_WGTESTUI_DATATOOLS_FORM_IMPORT_LIST_DESC', 'Use new line for each link');
\define('_AM_WGTESTUI_DATATOOLS_FORM_EXPORT', 'Export datatools');
\define('_AM_WGTESTUI_DATATOOLS_FORM_EXPORT_SELECT', 'Select data for export as file');
\define('_AM_WGTESTUI_DATATOOLS_JSON_CREATED_SUCCESS', 'JSON file(s) successfuly created: ');
\define('_AM_WGTESTUI_DATATOOLS_JSON_CREATED_ERROR', 'An error occured when creating JSON file');
\define('_AM_WGTESTUI_DATATOOLS_JSON_IMPORT_SUCCESS', 'JSON file(s) successfully imported: ');
\define('_AM_WGTESTUI_DATATOOLS_JSON_IMPORT_ERROR', 'An error occured when importing JSON file');
\define('_AM_WGTESTUI_DATATOOLS_LIST_IMPORT_SUCCESS', 'Tests imported from list successfully: ');
\define('_AM_WGTESTUI_DATATOOLS_LIST_IMPORT_ERROR', 'Tests imported from list with error: ');
\define('_AM_WGTESTUI_DATATOOLS_LIST_IMPORT_EXIST', 'Tests not imported from list, because they exist already: ');
// General
\define('_AM_WGTESTUI_OK', 'OK');
\define('_AM_WGTESTUI_NOTOK', 'Not OK');
\define('_AM_WGTESTUI_FORM_UPLOAD', 'Upload file');
\define('_AM_WGTESTUI_FORM_UPLOAD_NEW', 'Upload new file: ');
\define('_AM_WGTESTUI_FORM_UPLOAD_SIZE', 'Max file size: ');
\define('_AM_WGTESTUI_FORM_UPLOAD_SIZE_MB', 'MB');
\define('_AM_WGTESTUI_FORM_UPLOAD_IMG_WIDTH', 'Max image width: ');
\define('_AM_WGTESTUI_FORM_UPLOAD_IMG_HEIGHT', 'Max image height: ');
\define('_AM_WGTESTUI_FORM_IMAGE_PATH', 'Files in %s :');
\define('_AM_WGTESTUI_FORM_ACTION', 'Action');
\define('_AM_WGTESTUI_FORM_EDIT', 'Modification');
\define('_AM_WGTESTUI_FORM_DELETE', 'Clear');
\define('_AM_WGTESTUI_FORM_DELETE_TABLEALL', 'Clear table tests');
// Clone feature
\define('_AM_WGTESTUI_CLONE', 'Clone');
\define('_AM_WGTESTUI_CLONE_DSC', 'Cloning a module has never been this easy! Just type in the name you want for it and hit submit button!');
\define('_AM_WGTESTUI_CLONE_TITLE', 'Clone %s');
\define('_AM_WGTESTUI_CLONE_NAME', 'Choose a name for the new module');
\define('_AM_WGTESTUI_CLONE_NAME_DSC', 'Do not use special characters! <br>Do not choose an existing module dirname or database table name!');
\define('_AM_WGTESTUI_CLONE_INVALIDNAME', 'ERROR: Invalid module name, please try another one!');
\define('_AM_WGTESTUI_CLONE_EXISTS', 'ERROR: Module name already taken, please try another one!');
\define('_AM_WGTESTUI_CLONE_CONGRAT', 'Congratulations! %s was sucessfully created!<br>You may want to make changes in language files.');
\define('_AM_WGTESTUI_CLONE_IMAGEFAIL', 'Attention, we failed creating the new module logo. Please consider modifying assets/images/logo_module.png manually!');
\define('_AM_WGTESTUI_CLONE_FAIL', 'Sorry, we failed in creating the new clone. Maybe you need to temporally set write permissions (CHMOD 777) to modules folder and try again.');
// ---------------- Admin Others ----------------
\define('_AM_WGTESTUI_ABOUT_MAKE_DONATION', 'Submit');
\define('_AM_WGTESTUI_SUPPORT_FORUM', 'Support Forum');
\define('_AM_WGTESTUI_DONATION_AMOUNT', 'Donation Amount');
\define('_AM_WGTESTUI_MAINTAINEDBY', ' is maintained by ');
// ---------------- End ----------------
