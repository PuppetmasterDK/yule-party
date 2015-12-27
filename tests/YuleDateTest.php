<?php

class YuleDateTest extends PHPUnit_Framework_TestCase
{

    /**
     * @dataProvider getYulePartyData
     * @param \Carbon\Carbon $now The now
     * @param \Carbon\Carbon $expected The expected date
     */
    public function testFirst(\Carbon\Carbon $now, \Carbon\Carbon $expected) {
        $instance = new \Lutzen\Models\YuleDate($now);
        $this->assertEquals($expected, $instance->getYulePartyDate(), "The returned date did not match!");

    }

    public function getYulePartyData() {
        return array(
            // Normal tests
            array(Carbon\Carbon::create(2013, 12, 1), \Carbon\Carbon::create(2013, 12, 14, 15, 0, 0)),
            array(Carbon\Carbon::create(2014, 12, 1), \Carbon\Carbon::create(2014, 12, 13, 15, 0, 0)),
            array(Carbon\Carbon::create(2015, 12, 1), \Carbon\Carbon::create(2015, 12, 12, 15, 0, 0)),

            // Edge cases
            array(Carbon\Carbon::create(2013, 12, 15), \Carbon\Carbon::create(2014, 12, 13, 15, 0, 0)),
            array(Carbon\Carbon::create(2013, 12, 14, 0, 0, 0), \Carbon\Carbon::create(2013, 12, 14, 15, 0, 0)),
            array(Carbon\Carbon::create(2013, 12, 14, 15, 0, 1), \Carbon\Carbon::create(2013, 12, 14, 15, 0, 0)),
            array(Carbon\Carbon::create(2013, 12, 14, 20, 0, 1), \Carbon\Carbon::create(2013, 12, 14, 15, 0, 0)),
        );
    }

    public function testIsolation() {
        $now = Carbon\Carbon::create(2013, 12, 1);
        $expected = \Carbon\Carbon::create(2013, 12, 14, 15, 0, 0);

        $instance = new \Lutzen\Models\YuleDate($now);
        $now->addYear();
        $this->assertEquals($expected, $instance->getYulePartyDate(), "The returned date did not match!");
    }

    /**
     * @dataProvider getIsYulePartyData
     * @param \Carbon\Carbon $now
     * @param boolean $expected
     */
    public function testIsYulePartyStarted(\Carbon\Carbon $now, $expected) {
        $instance = new \Lutzen\Models\YuleDate($now);
        $this->assertEquals($expected, $instance->isYulePartyStarted(), "Did not return expected yule party status");
    }

    public function getIsYulePartyData() {
        return array(
            // Normal tests
            array(\Carbon\Carbon::create(2013, 12, 14, 15, 0, 0), true),
            array(\Carbon\Carbon::create(2013, 12, 14, 14, 59, 59), false),
            array(\Carbon\Carbon::create(2013, 12, 14, 15, 0, 1), true),
            array(\Carbon\Carbon::create(2013, 12, 14, 20, 0, 0), true),
            array(\Carbon\Carbon::create(2013, 12, 14, 10, 0, 0), false),
            array(\Carbon\Carbon::create(2013, 12, 13, 15, 0, 0), false),
            array(\Carbon\Carbon::create(2013, 12, 14, 23, 59, 59), true),
            array(\Carbon\Carbon::create(2013, 12, 15, 0, 0, 0), false),
            array(\Carbon\Carbon::create(2013, 12, 15, 0, 0, 0), false),
            array(\Carbon\Carbon::create(2013, 12, 14, 20, 52, 17), true),
        );
    }

}
