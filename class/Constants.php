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
 * Interface  Constants
 */
interface Constants
{
    // Constants for tables
    public const TABLE_TESTS = 0;

    // Constants for status
    public const STATUS_NONE      = 0;
    public const STATUS_OFFLINE   = 1;
    public const STATUS_SUBMITTED = 2;
    public const STATUS_APPROVED  = 3;

    // Constants for test area
    public const AREA_ADMIN = 1;
    public const AREA_USER  = 2;

    // Constants for test type
    public const TYPE_HTTPREQUEST = 1;

}
