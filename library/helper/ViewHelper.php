<?php

/**
 * Class helper view
 * Load header, top, left, footer, right
 * @author  Kay Liong
 */
abstract class ViewHelper {


    /**
     * Load header
     */
    static public function header(){
        $header = APPDIR.'/views/include/header.php';
        include $header;
    }

    /**
     * Load top menu bar
     */
    static public function top(){
        $topbar = APPDIR.'/views/include/top.php';
        include $topbar;
    }

    /**
     * Load left side menu bar
     */
    static public function sidebar($var=array()){
        $left_menu = APPDIR.'/views/include/sidebar.php';
        include $left_menu;
    }


    /**
     * Load footer
     */
    static public function footer(){
        $footer = APPDIR.'/views/include/footer.php';
        include $footer;
    }
    
    /**
     * Load customer bill & ship addresses in the invoice
     * @param string $user_id
     */
    static public function aj_cust_addresses($user_id=''){
        $invoice_addresses_form = APPDIR.'/views/invoices/invoice_address_form.phtml';
        $addresses = Customers::getCustAddressFormByID(2);
        extract($addresses, EXTR_SKIP);
        include $invoice_addresses_form;
    }
    
    /**
     * Load invoice items layout
     * Default load and via ajax
     */
    static public function aj_cust_items(){
        $invoice_items_form = APPDIR.'/views/invoices/invoice_items_form.phtml';
        $items = Service_Items::svcGetAllItems();
        include $invoice_items_form;
    }


    /**
     * Load css files
     * @param string $path  xxx.css
     * @param string $return
     * @return string
     */
    public static function css($path,$domain=false,$return=false){
        if(empty($path)) return false;
        if(!is_array($path)) $path = array($path);

        $incdomain = empty($domain)?S3_STATIC:$domain;

        foreach($path as $k=>$v){
            $href = $incdomain.$v.'?v='.Service_Version::getVer();
            $result = "<link href=\"{$href}\" type=\"text/css\" rel=\"stylesheet\" />\r\n";
            if ($return) {
                return $result;
            } else {
                echo $result;
            }
        }
    }


    /**
     * load js files
     * @param string $path  xxx.css
     * @param string $return
     * @return string
     */
    public static function js($path,$domain=false,$return=false){
        if(empty($path)) return false;
        if(!is_array($path)) $path = array($path);

        $incdomain = empty($domain)?S3_STATIC:$domain;

        foreach($path as $k=>$v){
            $href = $incdomain.$v.'?v='.Service_Version::getVerFileModified($incdomain.$v);
            $result = "<script type=\"text/javascript\" src=\"{$href}\"></script>\r\n";
            if ($return) {
                return $result;
            } else {
                echo $result;
            }
        }
    }
    
    /**
     * Load block
     *
     * @param string $_tpl path to the view
     * @param array  $_var Register template variables inside the block, key is the variable name, value is the corresponding value。
     */
    static public function loadBlock($_tpl, array $_var = array()) {
        extract($_var, EXTR_SKIP);
        include APP_PATH .'/application/views/' . $_tpl;
    }

    static public function loadToastMessage($status,$msg,$is_script=true){
        if($is_script == false){
            $result = "";
        }else{
            $result = "<script>" ;
        }
        $result .= "$.toast({".
                   "heading: '".$status."',".
                   "text: '".$msg."',".
                   "position: 'top-center',".
                    "loaderBg: '#ff6849',".
                    "icon: '".$status."',".
                    "hideAfter: 1000,".
                    "stack: 4".
                "})";
        if($is_script == false){
            return $result;
        }
        $result .= "</script>" ;
        return $result ;
    }
}
