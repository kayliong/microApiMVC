<?php

/**
 * Common Class
 * To handle common functions
 * @author kayliongmac11air
 *
 */
class CommonBase {

   private static $statInfo = array();

    /** 
     * get stat info
     * @param void
     * @return array
     */
    public static function getStatInfo() {
        return self::$statInfo;
    }   

    /** 
     * add stat info
     * @param string $type mc|db|request
     * @param int $startTime
     * @param int $offset default 1
     * @return mix
     */
    public static function addStatInfo($type, $startTime = 0, $offset = 1) {
        if (!isset(self::$statInfo[$type]['count'])) {
            self::$statInfo[$type]['count'] = 0;
        }
        
        if (!isset(self::$statInfo[$type]['time'])) {
            self::$statInfo[$type]['time'] = 0;
        }

        self::$statInfo[$type]['count'] += $offset;
        if($startTime > 0) {
            $runTime = sprintf("%0.2f", (microtime(true) - $startTime) * 1000);
            self::$statInfo[$type]['time'] += $runTime;
            return $runTime . " ms";
        }   
        return true;
    }
    
    /**
      * Function convert encoding
      * @param Mixed $data array to be convert
      * @param String $dstEncoding output encoding
      * @param String $srcEncoding incoming encoding
      * @param bool $toArray whether to convert stdObject to array output
      * @return Mixed
      */
    public static function convertEncoding($data, $dstEncoding, $srcEncoding, $toArray=false) {
        if ($toArray && is_object($data)) {
            $data = (array)$data;
        }
        if (!is_array($data) && !is_object($data)) {
            $data = mb_convert_encoding($data, $dstEncoding, $srcEncoding);
        } else {
            if (is_array($data)) {
                foreach($data as $key=>$value) {
                    if (is_numeric($value)) {
                        continue;
                    }
                    $keyDstEncoding = self::convertEncoding($key, $dstEncoding, $srcEncoding, $toArray);
                    $valueDstEncoding = self::convertEncoding($value, $dstEncoding, $srcEncoding, $toArray);
                    unset($data[$key]);
                    $data[$keyDstEncoding] = $valueDstEncoding;
                }
            } else if(is_object($data)) {
                $dataVars = get_object_vars($data);
                foreach($dataVars as $key=>$value) {
                    if (is_numeric($value)) {
                        continue;
                    }
                    $keyDstEncoding = self::convertEncoding($key, $dstEncoding, $srcEncoding, $toArray);
                    $valueDstEncoding = self::convertEncoding($value, $dstEncoding, $srcEncoding, $toArray);
                    unset($data->$key);
                    $data->$keyDstEncoding = $valueDstEncoding;
                }
            }
        }
        return $data;
    }
}
