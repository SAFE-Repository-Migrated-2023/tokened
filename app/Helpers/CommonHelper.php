<?php

namespace App\Helpers;

class CommonHelper
{
    public static function normalizeUsername($safe_id)
    {
        $safe_id = self::cleanUsername($safe_id);
        $safe_id = self::addUsername($safe_id);

        return $safe_id;
    }

    public static function cleanUsername($safe_id)
    {
        //remove '<'
         if (substr($safe_id, 0, 1) == '<') {
            $safe_id = str_replace('<', '', $safe_id);
        }

        return trim($safe_id);
    }

    public static function addUsername($safe_id)
    {
        //add '<'
        return substr($safe_id, 0, 1) != '<' ? '<'.$safe_id : $safe_id;
    }

    public static function normalizePhone($phone)
    {
        //add "+" if missing
        return substr($phone, 0, 1) != '+' ? '+'.$phone : $phone;
    }
}