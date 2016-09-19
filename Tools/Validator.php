<?php

namespace Tools;

class Validator
{
    
    /**
     * Validate if all the elements in the control array are set in the input array
     * @param array $input array to validate
     * @param array $control array with control values to validate with. 
     * Keys must correspond with the keys of the input array. 
     * Values can either be true or false depending if the value has to be required.
     * @return boolean true on success, false on failure
     */
    public static function validateArray(array $input, array $control)
    {
        foreach ($control as $key => $value) {
            if (is_array($value) && isset($input[$key])) {
                if (!self::validateArray($input[$key], $value)) {
                    return false;
                }
                continue;
            }
            if ($value === true && !isset($input[$key])) {
                return false;
            }
        }
        
        return true;
    }
    
}