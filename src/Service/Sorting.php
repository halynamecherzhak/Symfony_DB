<?php
/**
 * Created by PhpStorm.
 * User: Halyna_Mecherzhak
 * Date: 4/9/2019
 * Time: 12:14 PM
 */

namespace App\Service;

class Sorting
{
    public static function callback($a1, $b1)
    {
        if (is_array($a1)) {
            $a = $a1['title'];
        }

        if (is_array($b1)) {
            $b = $b1['title'];
        }

        $el1 = strtolower($a);
        $el2 = strtolower($b);

        return $el1 <=> $el2;
    }

    public function add($a, $b)
    {
        return $a + $b;
    }

}