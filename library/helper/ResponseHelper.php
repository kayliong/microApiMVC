<?php

/**
 * Response helper
 * @author kayliong
 *
 */
class ResponseHelper extends MessageBase
{
    /**
     * @var bool
     */
    public $status;
    /**
     * @var mixed
     */
    public $results;

    /**
     * Commerce_Response constructor.
     * @param $results
     * @param $status
     */
    public function __construct($results, $status)
    {
        $this->results = $results;
        $this->status = $status;
    }


    /**
     * 
     * @param string $msg
     * @param array $data
     * @param number $code
     * @param array $otherData
     * @param string $url
     * @param number $t
     * @param string $ie
     * @param string $oe
     */
    public static function showSucc($msg, $data = array(), $code = 200, $otherData = array(), $url = '', $t = 3, $ie = '', $oe = 'UTF-8')
    {
        if (is_int($code) && $code >= 200 && $code < 600) {
            http_response_code($code);
        }
        self::message($code, $msg, $data, $url, $t, $otherData, $ie, $oe);
    }

    /**
     * 
     * @param string $msg
     * @param array $data
     * @param number $statusCode
     * @param number $code
     * @param string $url
     * @param number $t
     * @param string $ie
     * @param string $oe
     */
    public static function showError($msg, $data = array(), $statusCode = 400, $code = 400, $url = '', $t = 3, $ie = '', $oe = 'UTF-8')
    {
        if (is_int($code) && $code >= 200 && $code < 600) {
            http_response_code($code);
        }
        parent::showError($msg, $data, $code, $url, $t, $ie, $oe);
    }
}
