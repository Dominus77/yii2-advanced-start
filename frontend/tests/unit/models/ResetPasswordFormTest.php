<?php

namespace frontend\tests\unit\models;

use common\fixtures\User as UserFixture;
use modules\users\models\ResetPasswordForm;

/**
 * Class ResetPasswordFormTest
 * @package frontend\tests\unit\models
 */
class ResetPasswordFormTest extends \Codeception\Test\Unit
{
    /**
     * @var \frontend\tests\UnitTester
     */
    protected $tester;

    /**
     * @inheritdoc
     */
    public function _before()
    {
        $this->tester->haveFixtures([
            'user' => [
                'class' => UserFixture::className(),
                'dataFile' => codecept_data_dir() . 'user.php'
            ],
        ]);
    }

    /**
     * @inheritdoc
     */
    public function testResetWrongToken()
    {
        $this->tester->expectException('yii\base\InvalidParamException', function() {
            new ResetPasswordForm('');
        });

        $this->tester->expectException('yii\base\InvalidParamException', function() {
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
