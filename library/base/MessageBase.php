<?php
/**
 * Data return format pack
 * @author kayliong
 *
 */
class MessageBase {

    private function __construct() {}

    /**
     * Dao/Service layer returns the data in the specified format, 
     * with code and message, which is convenient for the action layer to obtain specific error information
     * @param array $result 
     * @param int $code
     * @param string $message
     * 
     */
    public static function formatResult($message, $result, $code){
        return array(
            'status' => array(
                'code' => $code,
                'msg'  => $message,
            ),
            'result'  => $result,
        );
    } 

    /**
      * Prompt for correct information, including page or api, error code is 0
      * @param string $msg information prompt, output interface: $data['status']['msg'];
      * @param array $data data content, output interface: $data['data'];
      * @param array $otherData Extended data content, output interface: $data['xxx']; Same level as the above data node
      * @param string $url If it is in the form of page prompt, the URL to jump to after the prompt is completed
      * @param int $t The waiting time adjusted after the prompt is completed, the default is 3 seconds
      * @param string $ie data content encoding, the default support is utf-8
      * @param string $oe output content encoding, the default is utf-8 (the setting is invalid when the json result is output, unified as unicode)
     */
    public static function showSucc($msg, $data = array(), $otherData=array(), $url='', $t=3, $ie='', $oe='UTF-8') {
        self::message(0, $msg, $data, $url, $t, $otherData, $ie, $oe);
    }


    /**
      * Error message tips, including pages or APIs
      * @param string $msg information prompt, output interface: $data['status']['msg'];
      * @param array $data data content, output interface: $data['data'];
      * @param int $code error number, default is 11
      * @param string $url If it is in the form of page prompt, the URL to jump to after the prompt is completed
      * @param int $t The waiting time adjusted after the prompt is completed, the default is 3 seconds
      * @param string $ie data content encoding, the default support is utf-8
      * @param string $oe output content encoding, the default is utf-8 (the setting is invalid when the json result is output, unified as unicode)
     */
    public static function showError($msg, $data=array(), $code=11, $url='', $t=3, $ie='', $oe='UTF-8') {
        self::message($code, $msg, $data, $url, $t, array(), $ie, $oe);
    }

    /**
      * Output messages in json/xml/html format. This function has many parameters, and it also reads the format and fileds parameters of $_REQUSET, which is very cruel
      * @param int $code error number, 0 means no error occurred
      * @param string $msg result description
      * @param array $data data, which can be a one-dimensional array or a two-dimensional array, only useful when outputting json/xml data
      * @param string $url the page to be redirected, only used when outputting html page
      * @param int $t Jump waiting time, only used when outputting html page
      * @param array $otherData supplementary field of the message, only useful when outputting json/xml data
      * @param string $ie the encoding of the input data, the default is gbk
      * @param string $oe output data encoding, the default is utf8
     */
    protected static function message($code, $msg, $data, $url = 'http://www.chope.co', $t, $otherData=array(), $ie='', $oe='UTF-8') {
        $format = empty($_REQUEST['format']) ? 'json' : strtolower($_REQUEST['format']);
        if (isset($_GET['oe']) && in_array(strtoupper($_GET['oe']), array('GBK', 'UTF-8'), true)) {
            $oe = $_GET['oe'];
        }
        $oe = $format === 'json' ? 'UTF-8' : $oe; // Standard json only supports UTF8 Chinese
        $code = intval($code);
        // convert 
        if(!empty($ie) && strcasecmp($ie, $oe) !== 0) {
            $msg = CommonBase::convertEncoding($msg, $oe, $ie);
            $data = CommonBase::convertEncoding($data, $oe, $ie);
            $otherData = CommonBase::convertEncoding($otherData, $oe, $ie);
        }

        // switch output according to different formats
        switch($format) {
            case 'xml':
                // TODO: if XML needed
            break;
            case 'json':
                $outArr = array();
                if (!is_array($msg)) {
                    $outArr['status']['code'] = (string)$code;
                    $outArr['status']['msg'] = $msg;
                    if (is_array($otherData)) {
                        foreach ($otherData as $k=>$v) {
                            if (!in_array($k, array('status', 'data'), true)) {
                                $outArr[$k] = $v;
                            }
                        }
                    }
                    $outArr['result'] = $data;
                } else {
                    $outArr = $msg;
                }
                $json = json_encode($outArr);
                $callback = isset($_GET['callback']) ? $_GET['callback'] : '';
                if (preg_match("/^[a-zA-Z][a-zA-Z0-9_\.]+$/", $callback)) {
                    if(isset($_SERVER['REQUEST_METHOD']) && strtoupper($_SERVER['REQUEST_METHOD']) === 'POST') { //POST
                        header("Content-Type: text/html");
                        $refer = isset($_SERVER['HTTP_REFERER']) ? parse_url($_SERVER['HTTP_REFERER']) : array();
                        if(!empty($refer) && (substr($refer['host'],-8,8)=='chope.co')){
                            $result = '<script>document.domain="chope.co";';
                        }else{
                            $result = '<script>document.domain="chope.net.cn";';
                        }
                        $result .= "parent.{$callback}({$json});</script>";
                        echo $result;
                    } else {
                        if(isset($_SERVER['HTTP_USER_AGENT']) && stripos($_SERVER['HTTP_USER_AGENT'], 'MSIE')) {
                            header('Content-Type: text/javascript; charset=UTF-8');
                        } else {
                            header('Content-Type: application/javascript; charset=UTF-8');
                        }
                        echo "{$callback}({$json});";
                    }
                } elseif ($callback) {
                    header('Content-Type: text/html; charset=UTF-8');
                    echo 'The callback parameter contains illegal characters！';
                } else {
                    if(isset($_SERVER['HTTP_USER_AGENT']) && stripos($_SERVER['HTTP_USER_AGENT'], 'MSIE')) {
                        header('Content-Type: text/plain; charset=UTF-8');
                    } else {
                        header('Content-Type: application/json; charset=UTF-8');
                    }
                    echo $json;
                }
            break;
            default:
                try {
                    // default data format
                } catch(Exception $e) {
                    
                    // default catch exception
                }
            break;
        }
        exit;
    }
}
