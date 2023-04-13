<?php declare(strict_types=1);

namespace XoopsModules\Wgtestui;

/*
 Utility Class Definition

 You may not change or alter any portion of this comment or credits of
 supporting developers from this source code or any supporting source code
 which is considered copyrighted (c) material of the original comment or credit
 authors.

 This program is distributed in the hope that it will be useful, but
 WITHOUT ANY WARRANTY; without even the implied warranty of
 MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.
 */


/**
 * Class ReplaceTextInFiles
 */
class ReplaceTextInFiles
{

    /**
     * @param $src_path
     * @param $dst_path
     * @param $patterns
     * @param $dirname
     * @param $mimetypes
     */
    public static function replaceExecute($src_path, $dst_path, $patterns, $mimetypes): void
    {
        $patKeys   = \array_keys($patterns);
        $patValues = \array_values($patterns);
        self::cloneFileFolder($src_path, $dst_path, $patKeys, $patValues, $mimetypes);
    }

    // recursive cloning script

    /**
     * @param $src_path
     * @param $dst_path
     * @param array $patKeys
     * @param array $patValues
     * @param $dirname
     * @param $mimetypes
     */
    public static function cloneFileFolder($src_path, $dst_path, $patKeys, $patValues, $mimetypes): void
    {
        // open the source directory
        $dir = \opendir($src_path);
        // Make the destination directory if not exist
        @\mkdir($dst_path);
        // Loop through the files in source directory
        while( $file = \readdir($dir) ) {
            if (( $file != '.' ) && ( $file != '..' )) {
                if ( \is_dir($src_path . '/' . $file) ) {
                    // Recursively calling custom copy function for sub directory
                    self::cloneFileFolder($src_path . '/' . $file, $dst_path . '/' . $file, $patKeys, $patValues, $mimetypes);
                } else {
                    self::cloneFile($src_path . '/' . $file, $dst_path . '/' . $file, $patKeys, $patValues, $mimetypes);
                }
            }
        }
        \closedir($dir);
    }

    /**
     * @param $src_file
     * @param $dst_file
     * @param array $patKeys
     * @param array $patValues
     */
    private static function cloneFile($src_file, $dst_file, $patKeys, $patValues, $mimetypes): void
    {
        $replace_code = false;
        if (\in_array(\mb_strtolower(\pathinfo($src_file, PATHINFO_EXTENSION)), $mimetypes)) {
            $replace_code = true;
        }
        if (\mb_strpos($dst_file, \basename(__FILE__)) > 0) {
            //skip myself
            $replace_code = false;
        }
        if ($replace_code) {
            // file, read it and replace text
            $content = \file_get_contents($src_file);
            $content = \str_replace($patKeys, $patValues, $content);

            //check file name whether it contains replace code
            $path_parts = \pathinfo($dst_file);
            $path = $path_parts['dirname'];
            $file =  $path_parts['basename'];
            $dst_file = $path . '/' . \str_replace($patKeys, $patValues, $file);
            \file_put_contents($dst_file, $content);
        } else {
            \copy($src_file, $dst_file);
        }
    }

}
