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


/**
 * Class Object Handler Tests
 */
class TestsHandler extends \XoopsPersistableObjectHandler
{

    /**
     * Constructor
     *
     * @param \XoopsDatabase $db
     */
    public function __construct(\XoopsDatabase $db)
    {
        parent::__construct($db, 'wgtestui_tests', Tests::class, 'id', 'url');
    }

    /**
     * @param bool $isNew
     *
     * @return object
     */
    public function create($isNew = true)
    {
        return parent::create($isNew);
    }

    /**
     * retrieve a field
     *
     * @param int $id field id
     * @param null $fields
     * @return \XoopsObject|null reference to the {@link Get} object
     */
    public function get($id = null, $fields = null)
    {
        return parent::get($id, $fields);
    }

    /**
     * get inserted id
     *
     * @return int reference to the {@link Get} object
     */
    public function getInsertId()
    {
        return $this->db->getInsertId();
    }

    /**
     * Get Count Tests in the database
     * @param int    $start
     * @param int    $limit
     * @param string $sort
     * @param string $order
     * @return int
     */
    public function getCountTests($start = 0, $limit = 0, $sort = 'id ASC, url', $order = 'ASC')
    {
        $crCountTests = new \CriteriaCompo();
        $crCountTests = $this->getTestsCriteria($crCountTests, $start, $limit, $sort, $order);
        return $this->getCount($crCountTests);
    }

    /**
     * Get All Tests in the database
     * @param int    $start
     * @param int    $limit
     * @param string $sort
     * @param string $order
     * @return array
     */
    public function getAllTests($start = 0, $limit = 0, $sort = 'id ASC, url', $order = 'ASC')
    {
        $crAllTests = new \CriteriaCompo();
        $crAllTests = $this->getTestsCriteria($crAllTests, $start, $limit, $sort, $order);
        return $this->getAll($crAllTests);
    }

    /**
     * Get Criteria Tests
     * @param        $crTests
     * @param int    $start
     * @param int    $limit
     * @param string $sort
     * @param string $order
     * @return int
     */
    private function getTestsCriteria($crTests, $start, $limit, $sort, $order)
    {
        $crTests->setStart($start);
        $crTests->setLimit($limit);
        $crTests->setSort($sort);
        $crTests->setOrder($order);
        return $crTests;
    }

    /**
     * @param $url
     * @param array $options
     * @return array
     * @throws Exception
     */
    public function checkURL($url, array $options = []) {

        $fatalError = '';

        $patternsOk        = $options['patterns_ok'];
        $patternsError     = $options['patterns_fatalerror'];
        $patternsErrorDesc = $options['patterns_fatalerrordesc'];

        if (empty($url)) {
            throw new Exception('URL is empty');
        }

        $ch = curl_init($url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
        if (isset($options['timeout'])) {
            $timeout = (int) $options['timeout'];
            curl_setopt($ch, CURLOPT_TIMEOUT, $timeout);
        }
        curl_setopt($ch, CURLOPT_HTTPHEADER, $options['header']);

        $htmlCode = \curl_exec($ch);
        $returnedStatusCode = curl_getinfo($ch, CURLINFO_RESPONSE_CODE);
        curl_close($ch);

        if (200 == $returnedStatusCode) {
            // check whether site seems to be loaded proper
            $properLoad      = false;
            $fatalErrorFound = false;
            foreach ($patternsOk as $pattern) {
                if(strpos($htmlCode, $pattern) > 0) {
                    $properLoad = true;
                    break;
                }
            }
            if (!$properLoad) {
                // search for error
                $fatalErrorFound = false;
                foreach ($patternsError as $pattern) {
                    if(strpos($htmlCode, $pattern) > 0) {
                        $fatalErrorFound = true;
                        break;
                    }
                }
                if($fatalErrorFound) {
                    // search error description
                    foreach ($patternsErrorDesc as $pattern) {
                        preg_match($pattern, $htmlCode, $match);
                        if (\is_array($match)) {
                            $fatalError = $match[1];
                            break;
                        }
                    }
                    if ('' === $fatalError) {
                        $fatalError = "pattern for fatal error found, but no error description";
                    }
                }
            }
        }
        // check for deprecated
        $deprecated = [];
        if (!$fatalErrorFound) {
            $deprecated = $this->getXoDeprecated($htmlCode);
        }
        $errors = [];
        if (!$fatalErrorFound) {
            $errors = $this->getXoErrors($htmlCode);
        }

        $statusText = $options['httpStatusCodes'][$returnedStatusCode];
        return ['statusCode' => $returnedStatusCode,
                'statusText' => $statusText,
                'fatalError' => $fatalError,
                'deprecated' => $deprecated,
                'errors'     => $errors,
            ];

    }

    /**
     * function to return a list of response codes http response
     *
     * @return array
     */
    public function getHttpStatusCodes() {

        return [
            100 => 'Continue',
            101 => 'Switching Protocols',
            102 => 'Processing',
            200 => 'OK',
            201 => 'Created',
            202 => 'Accepted',
            203 => 'Non-Authoritative Information',
            204 => 'No Content',
            205 => 'Reset Content',
            206 => 'Partial Content',
            207 => 'Multi-Status',
            208 => 'Already Reported',
            226 => 'IM Used',
            300 => 'Multiple Choices',
            301 => 'Moved Permanently',
            302 => 'Found',
            303 => 'See Other',
            304 => 'Not Modified',
            305 => 'Use Proxy',
            306 => 'Switch Proxy',
            307 => 'Temporary Redirect',
            308 => 'Permanent Redirect',
            400 => 'Bad Request',
            401 => 'Unauthorized',
            402 => 'Payment Required',
            403 => 'Forbidden',
            404 => 'Not Found',
            405 => 'Method Not Allowed',
            406 => 'Not Acceptable',
            407 => 'Proxy Authentication Required',
            408 => 'Request Timeout',
            409 => 'Conflict',
            410 => 'Gone',
            411 => 'Length Required',
            412 => 'Precondition Failed',
            413 => 'Payload Too Large',
            414 => 'Request-URI Too Long',
            415 => 'Unsupported Media Type',
            416 => 'Requested Range Not Satisfiable',
            417 => 'Expectation Failed',
            418 => 'I\'m a teapot',
            422 => 'Unprocessable Entity',
            423 => 'Locked',
            424 => 'Failed Dependency',
            425 => 'Unordered Collection',
            426 => 'Upgrade Required',
            428 => 'Precondition Required',
            429 => 'Too Many Requests',
            431 => 'Request Header Fields Too Large',
            449 => 'Retry With',
            450 => 'Blocked by Windows Parental Controls',
            500 => 'Internal Server Error',
            501 => 'Not Implemented',
            502 => 'Bad Gateway',
            503 => 'Service Unavailable',
            504 => 'Gateway Timeout',
            505 => 'HTTP Version Not Supported',
            506 => 'Variant Also Negotiates',
            507 => 'Insufficient Storage',
            508 => 'Loop Detected',
            509 => 'Bandwidth Limit Exceeded',
            510 => 'Not Extended',
            511 => 'Network Authentication Required',
            599 => 'Network Connect Timeout Error'
        ];
    }

    /**
     * function to return infos about deprecated functions
     *
     * @return array
     */
    public function getXoDeprecated($htmlCode) {

        $deprecated = [];

        // get table deprecated
        \preg_match_all('/<table id="xo-logger-deprecated".*?>(.*?)<\/table>/si', $htmlCode, $matchesTable);
        if (\count($matchesTable) > 0) {
            // get all td from table
            \preg_match_all('/<td.*?>(.*?)<\/td>/si', (string)$matchesTable[1][0], $matchesTd);
            \array_shift($matchesTd);
            foreach ($matchesTd[0] as $tdkey => $tdmatch) {
                $deprecated[] = 'Deprecated: ' . ($tdkey + 1) . ') ' . \str_replace('<br>', '', $tdmatch);
            }
        }

        return $deprecated;
    }

    /**
     * function to return infos about errors (non-fatal), warnings and notices
     *
     * @return array
     */
    public function getXoErrors($htmlCode) {

        $errors = [];

        // get table deprecated
        preg_match_all('/<table id="xo-logger-errors".*?>(.*?)<\/table>/si', $htmlCode, $matchesTable);
        if (\count($matchesTable) > 0) {
            // get all td from table
            preg_match_all('/<td.*?>(.*?)<\/td>/si', (string)$matchesTable[1][0], $matchesTd);
            array_shift($matchesTd);
            foreach ($matchesTd[0] as $tdkey => $tdmatch) {
                $errors[] = ($tdkey + 1) . ') ' . \str_replace('<br>', '', $tdmatch);
            }
        }

        return $errors;
    }

}
