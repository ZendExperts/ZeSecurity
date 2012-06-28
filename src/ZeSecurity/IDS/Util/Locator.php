<?php
namespace ZeSecurity\IDS\Util;

class Locator
{
    /**
     * Expand the file path using the current include path
     * @static
     * @param string $file
     * @return string
     */
    public static function expandFilePath($file)
    {
        $ps = explode(PATH_SEPARATOR, ini_get('include_path'));
        foreach ($ps as $path) {
            if (file_exists($path . '/' . $file)) return $path . '/' . $file;
        }
        return $file;
    }
}