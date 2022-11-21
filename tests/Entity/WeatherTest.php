<?php

use App\Entity\Weather;

class WeatherTest extends \PHPUnit\Framework\TestCase{

    /**
     * @test
     * @dataProvider provideData
     */
    public function testToFahrenheit($c, $exp)
    {
        $w= new Weather();
        $w->setTempAvg($c);
        $f=$w->ToFahrenheit($w->getTempAvg());

        $this->assertEquals($exp, $f);
    }


    public function provideData(): array
    {
        return [
            [18,64.4],
            [0,32],
            [-10,14],
            [40,104],
            [-1,30.2]
        ];
    }
}