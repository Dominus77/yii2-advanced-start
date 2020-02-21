<?php

namespace common\components\maintenance\filters;

use Yii;
use common\components\maintenance\Filter;
use yii\web\IdentityInterface;
use yii\web\User;

/**
 * Class UserFilter
 * @package common\components\maintenance\filters
 */
class UserFilter extends Filter
{
    /**
     * @var string
     */
    public $checkedAttribute;
    /**
     * @var array
     */
    public $users;
    /**
     * @var User|null
     */
    protected $identity;

    /**
     * @inheritdoc
     */
    public function init()
    {
        $this->identity = Yii::$app->user->identity;
        if (is_string($this->users)) {
            $this->users = [$this->users];
        }
        parent::init();
    }

    /**
     * @return bool
     */
    public function isAllowed()
    {
        if (($this->identity instanceof IdentityInterface) && is_array($this->users) && !empty($this->users)) {
            return (bool)in_array($this->identity->{$this->checkedAttribute}, $this->users, true);
        }
        return false;
    }
}