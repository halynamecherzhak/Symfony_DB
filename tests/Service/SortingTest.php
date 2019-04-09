<?php
/**
 * Created by PhpStorm.
 * User: Halyna_Mecherzhak
 * Date: 4/9/2019
 * Time: 1:33 PM
 */

namespace App\Tests\Service;

use App\Service\Sorting;
use PHPUnit\Framework\TestCase;

class SortingTest extends TestCase{
    public function testAdd()
    {
        $calculator = new Sorting();
        $result = $calculator->add(30, 12);

        $this->assertEquals(42, $result);
    }
}