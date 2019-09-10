<?php

namespace frontend\tests\functional;

use frontend\tests\FunctionalTester;
use yii\helpers\Url;

/**
 * Class AboutCest
 * @package frontend\tests\functional
 */
class AboutCest
{
    /**
     *
     * @param FunctionalTester $I
     */
    public function checkAbout(FunctionalTester $I)
    {
        $I->amOnRoute(Url::to(['/main/default/about']));
        $I->see('About', 'h1');
    }
}
