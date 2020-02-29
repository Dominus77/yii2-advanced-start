<?php

namespace frontend\tests\unit\models;

use modules\main\models\frontend\ContactForm;
use Codeception\Test\Unit;
use frontend\tests\UnitTester;
use yii\mail\MessageInterface;

/**
 * Class ContactFormTest
 * @package frontend\tests\unit\models
 */
class ContactFormTest extends Unit
{
    /**
     * @var UnitTester
     */
    protected $tester;

    /**
     * @inheritdoc
     */
    public function testSendEmail()
    {
        $model = new ContactForm();

        $model->attributes = [
            'name' => 'Tester',
            'email' => 'tester@example.com',
            'subject' => 'very important letter subject',
            'body' => 'body of current message',
        ];

        expect_that($model->sendEmail('admin@example.com'));

        // using Yii2 module actions to check email was sent
        $this->tester->seeEmailIsSent();

        $emailMessage = $this->tester->grabLastSentEmail();

        expect('valid email is sent', $emailMessage)->isInstanceOf(MessageInterface::class);
        expect($emailMessage->getTo())->hasKey('admin@example.com');
        expect($emailMessage->getFrom())->hasKey('tester@example.com');
        expect($emailMessage->getSubject())->equals('very important letter subject');
        expect($emailMessage->toString())->stringContainsString('body of current message');
    }
}
