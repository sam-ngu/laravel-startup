<?php


namespace App\Helpers\Routes;

class RouteHelper
{
    /**
     * Loops through a folder and requires all PHP files
     * Searches sub-directories as well.
     *
     * @param $folder
     */
    public static function includeRouteFiles($folder)
    {
        try {
            $rdi = new \recursiveDirectoryIterator($folder);
            $it = new \recursiveIteratorIterator($rdi);

            while ($it->valid()) {
                if (! $it->isDot() && $it->isFile() && $it->isReadable() && $it->current()->getExtension() === 'php') {
                    require $it->key();
                }

                $it->next();
            }
        } catch (\Exception $e) {
            dump($e);
            echo $e->getMessage();
        }
    }
}
