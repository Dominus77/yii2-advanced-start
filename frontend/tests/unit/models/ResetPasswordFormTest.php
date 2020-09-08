<?php

namespace frontend\tests\unit\models;

use Codeception\Test\Unit;
use common\fixtures\User as UserFixture;
use frontend\tests\UnitTester;
use modules\users\models\ResetPasswordForm;
use yii\base\InvalidArgumentException;

/**
 * Class ResetPasswordFormTest
 * @package frontend\tests\unit\models
 */
class ResetPasswordFormTest extends Unit
{
    /**
     * @var UnitTester
     */
    protected $tester;

    /**
     * @inheritdoc
     */
    public function _before() // phpcs:ignore
    {
        $this->tester->haveFixtures([
            'user' => [
                'class' => UserFixture::class,
                'dataFile' => codecept_data_dir() . 'user.php'
            ],
        ]);
    }

    /**
     * @inheritdoc
     */
    public function testResetWrongToken()
    {
        $this->tester->expectThrowable(InvalidArgumentException::class, static function () {
            new ResetPasswordForm('');
        });

        $this->tester->expectThrowable(InvalidArgumentException::class, static function () {
            new ResetPasswordForm('notexistingtoken_1391882543');
        });
    }

    /**
     * @inheritdoc
     */
    public function testResetCorrectToken()
    {
        $user = $this->tester->grabFixture('user', 2);
        $form = new ResetPasswordForm($user['password_reset_token']);
        expect_that($form->resetPassword());
    }
}
