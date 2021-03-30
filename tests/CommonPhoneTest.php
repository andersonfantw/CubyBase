<?php

namespace CubyBase\Tests;

use Illuminate\Notifications\Notifiable;
use Illuminate\Notifications\Notification;
use Illuminate\Support\Facades\Event;
use CubyBase\Events\SystemNoticeEvent;
use CubyBase\Common\Phone;
use Orchestra\Testbench\TestCase;

class CommonPhoneTest extends TestCase
{
    protected $phone;

    // protected function getPackageProviders($app)
    // {
    //     return ['CubyBase\CubyBaseProvider'];
    // }

    /**
     * Define environment setup.
     *
     * @param  \Illuminate\Foundation\Application  $app
     * @return void
     */
    protected function getEnvironmentSetUp($app)
    {
        $app['config']->set('phone' , require __DIR__.'/../config/phone.php');
    }

    public function setUp(): void
    {
        parent::setUp();
        $this->phone = new Phone();
    }

    public function tearDown(): void
    {
        parent::tearDown();
    }

    /** @test */
    public function test_call_statically()
    {
        $this->assertTrue(Phone::create('+85212345678')->isValid());
        $this->assertEquals('zh-hk', Phone::create('+85212345678')->getCountryCode());
    }

    /** @test */
    public function test_invalid_phone()
    {
        Event::fake();
        $this->phone->create('+86212345678');
        $this->assertFalse($this->phone->isValid());
        $this->assertEquals('', $this->phone->getCountryCode());
        Event::assertDispatched(SystemNoticeEvent::class);
    }

    /** @test */
    public function test_can_valid_hk_phone()
    {
        Event::fake();
        $this->phone->create('+85212345678');
        $this->assertTrue($this->phone->isValid());
        $this->assertEquals('zh-hk', $this->phone->getCountryCode());
        Event::assertNotDispatched(SystemNoticeEvent::class);
    }

    /** @test */
    public function test_can_valid_tw_phone()
    {
        Event::fake();
        $this->phone->create('+886123456789');
        $this->assertTrue($this->phone->isValid());
        $this->assertEquals('zh-tw', $this->phone->getCountryCode());
        Event::assertNotDispatched(SystemNoticeEvent::class);
    }

    /** @test */
    public function test_can_valid_cn_phone()
    {
        Event::fake();
        $this->phone->create('+8612345678901');
        $this->assertTrue($this->phone->isValid());
        $this->assertEquals('zh-cn', $this->phone->getCountryCode());
        Event::assertNotDispatched(SystemNoticeEvent::class);
    }

    /** @test */
    public function test_can_valid_mo_phone()
    {
        Event::fake();
        $this->phone->create('+85312345678');
        $this->assertTrue($this->phone->isValid());
        $this->assertEquals('zh-mo', $this->phone->getCountryCode());
        Event::assertNotDispatched(SystemNoticeEvent::class);
    }

    public function test_can_valid_a_phone()
    {
        Event::fake();
        $this->assertTrue(Phone::valid('85212345678'));
        Event::assertNotDispatched(SystemNoticeEvent::class);
        $this->assertFalse(Phone::valid('86212345678'));
        Event::assertDispatched(SystemNoticeEvent::class);
    }

    public function test_can_valid_a_phone_with_country_code()
    {
        Event::fake();
        $this->assertTrue(Phone::valid('85212345678','zh-hk'));
        Event::assertNotDispatched(SystemNoticeEvent::class);
        $this->assertFalse(Phone::valid('85212345678','zh-tw'));
    }

    /** @test */
    public function test_it_format()
    {
        $this->phone->create('+85212345678');
        $this->assertEquals('(+852)1234-5678 ',$this->phone->format('(+c)4-5'));
    }
}