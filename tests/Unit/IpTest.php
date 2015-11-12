<?php
/*
 * This file is part of the IPTools package.
 *
 * (c) Avtandil Kikabidze aka LONGMAN <akalongman@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */
namespace Tests\Unit;

use \Longman\IPTools\Ip;

/**
 * @package        TelegramTest
 * @author         Avtandil Kikabidze <akalongman@gmail.com>
 * @copyright      Avtandil Kikabidze <akalongman@gmail.com>
 * @license        http://opensource.org/licenses/mit-license.php  The MIT License (MIT)
 * @link           http://www.github.com/akalongman/php-telegram-bot
 */
class IpTest extends TestCase
{

    /**
     * @test
     */
    public function test0()
    {
        $status = (bool)Ip::isValid('192.168.1.1');
        $this->assertTrue($status);

        $status = (bool)Ip::isValid('192.168.1.255');
        $this->assertTrue($status);

        $status = (bool)Ip::isValid('192.168.1.256');
        $this->assertFalse($status);
    }


    /**
     * @test
     */
    public function test1()
    {
        $status = Ip::match('192.168.1.1', '192.168.0.*');
        $this->assertFalse($status);

        $status = Ip::match('192.168.1.1', '192.168.0/24');
        $this->assertFalse($status);

        $status = Ip::match('192.168.1.1', '192.168.0.0/255.255.255.0');
        $this->assertFalse($status);

    }

    /**
     * @test
     */
    public function test2()
    {
        $status = Ip::match('192.168.1.1', '192.168.*.*');
        $this->assertTrue($status);

        $status = Ip::match('192.168.1.1', '192.168.1/24');
        $this->assertTrue($status);

        $status = Ip::match('192.168.1.1', '192.168.1.1/255.255.255.0');
        $this->assertTrue($status);
    }

    /**
     * @test
     */
    public function test3()
    {
        $status = Ip::match('192.168.1.1', '192.168.1.1');
        $this->assertTrue($status);
    }

    /**
     * @test
     */
    public function test4()
    {
        $status = Ip::match('192.168.1.1', '192.168.1.2');
        $this->assertFalse($status);
    }

    /**
     * @test
     */
    public function test5()
    {
        $status = Ip::match('192.168.1.1', array('192.168.123.*', '192.168.123.124'));
        $this->assertFalse($status);

        $status = Ip::match('192.168.1.1', array('122.128.123.123', '192.168.1.*', '192.168.123.124'));
        $this->assertTrue($status);
    }

    /**
     * @test
     * @expectedException \InvalidArgumentException
     */
    public function test6()
    {
        $status = Ip::match('192.168.1.1', '192.168.1.2');

        $status = Ip::match('192.168.1.256', '192.168.1.2');
    }
}
