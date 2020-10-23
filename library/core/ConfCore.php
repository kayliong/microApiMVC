<?php
/**
 * Class Core Configuration
 * To read ini file
 * @author kayliong
 *
 */
class ConfCore
{
    /**
     * Get Configuration
     * @param string $conf
     * @return array
     */
    public static function getConf($conf) {
       $arr = explode('/', $conf);
        if (count($arr) == 1) {
            $section = $conf;
            $filename = "{$conf}.ini";
        } else {
            $section = array_pop($arr);
            $filename = implode('/', $arr) . '.ini'; 
        }
        
        $filename = APPDIR . '/conf/' . $filename;
        $config = parse_ini_file($filename, true);
        return $config[$section];
    }
}
