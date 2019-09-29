<?php 

namespace app\libs;

defined('LOADED_FROM_INDEX') OR exit('No direct access allowed');

/**
 * Fast crutch for Validation Library
 * @todo extend Gump and make it more usable
 */
class HelperValidation 
{
    /**
     * Replaces fiels names in $errors with eligible names in $fieldNames
     * 
     * @param array $errors
     * @param array $fieldNames
     * @return array
     */
    public static function resolveErrorMessages(array $errors, array $fieldNames): array
    {
        foreach ($errors as &$error) {
            foreach ($fieldNames as $key => $fieldName) {
                if (strpos($error, $key) !== false) {
                    $error = str_replace($key, $fieldName, $error);
                }
            }
        }
        return $errors;
    }
}