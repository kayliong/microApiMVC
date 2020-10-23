<?php 
Class UtilityHelper
{
    /**
     * A helper function to check if a value isset properly if not return a default value
     * a cleaner way to do truthy  $value ? : 'default';
     * @param array|object $list
     * @param string|array $key
     * @param null $default
     * @return mixed
     */
    public static function getValue($list, $key, $default = null){
        if(!is_array($list) && !is_object($list)){ // if the first value is not an array return default
            return $default;
        }
        
        if(!is_array($key)){
            $key = [$key];
        }
        
        $current = $list;
        foreach($key as $element){
            
            if(is_array($current)) {
                if (!isset($current[$element])) {
                    return $default;
                }
                $current = $current[$element];
            }else{
                if (!isset($current->$element)) {
                    return $default;
                }
                $current = $current->$element;
            }
        }
        
        return $current;
    }
}