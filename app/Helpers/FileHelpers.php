<?php

namespace App\Helpers;

class FileHelpers
{

    protected $commentToken;

    /**
     * Store Comment Token List for Tokenizer
     */
    public static function commentTokens()
    {
        $commentTokens = array(T_COMMENT);
        if (defined('T_DOC_COMMENT'))
            $commentTokens[] = T_DOC_COMMENT; // PHP 5
        if (defined('T_ML_COMMENT'))
            $commentTokens[] = T_ML_COMMENT;  // PHP 4

        return $commentTokens;
    }

    public function removeComments($files)
    {
        $this->commentTokens();
        $file = [];
        $lines = '';
        $tokens = token_get_all($files);
        foreach ($tokens as $token) {
            if (is_array($token)) {
                if (in_array($token[0], $this->commentTokens)) {
//                    echo "Line {$token[2]}: ", token_name($token[0]), " ('{$token[1]}')","</br>";
                    continue;
                }
                $token = $token[1];
            }
//            $newStr .= $token;
            if (strstr($token, "\n")) {
                if ((!empty(trim($lines))))
                    $file[] = trim($lines); // trim kore whitespace gula remove kora hoy; majhe majhe only space theke jay i.e. empty string/blank line
                $lines = "";
            } else {
                $lines .= $token;
            }
        }

        return $file;
    }

    public function getMethods(){

    }
}