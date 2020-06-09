<?php declare(strict_types=1);

namespace SCF\Logger;

class Log 
{
    const LOG_PATH = 'app/Storage/logs/';

    /**
     * Writes a line to the log file.
     * @param string $log - data you want to log.
     * 
     * @return bool Returns True or False on Succeed/Fail.
     */
    public static function write(string $log): bool 
    {
        $file = self::LOG_PATH . 'application-' . date('YYYYmmdd') . '.log';
        if (($fd = fopen($file, 'a')) === false) {
            return false;
        }

        $msg = '[' . date('YYYY-mm-dd H:i:s') . ']' . $log . "\n";
        if (fwrite($fd, $msg) === false) {
            return false;
        }

        fclose($fd);

        return true;
    }
}