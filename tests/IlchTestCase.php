<?php
/**
 * Holds class IlchTestCase.
 *
 * @author Jainta Martin
 * @package ilch_phpunit
 */

/**
 * Base class for test cases for Ilch.
 *
 * @author Jainta Martin
 * @package ilch_phpunit
 */
class IlchTestCase extends PHPUnit_Framework_TestCase
{
    /**
     * Returns the _files folder path for this test.
     *
     * @return string |false
     * @throws Exception If the _files directory doesn`t exist.
     */
    protected function _getFilesFolder()
    {
        $pathToClass = dirname(strtolower(str_replace('_', '/', get_class($this))));
        $filesDir = __DIR__.'/'.$pathToClass.'/_files';

        if(!is_dir($filesDir))
        {
            throw new Exception('_files directory "'.$filesDir.'" does not exist.');
        }

        return $filesDir;
    }
}