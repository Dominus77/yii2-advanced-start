<?php

namespace common\components\maintenance\states;

use common\components\maintenance\StateInterface;
use yii\base\BaseObject;

/**
 * Class SimpleState
 * @package common\components\maintenance\states
 */
class SimpleState extends BaseObject implements StateInterface
{
    /**
     * @var bool
     */
    public $enabled = false;

    /**
     * @inheritdoc
     */
    public function enable($datetime)
    {
        $this->enabled = true;
    }

    /**
     * @inheritdoc
     */
    public function disable()
    {
        $this->enabled = false;
    }

    /**
     * @inheritdoc
     */
    public function isEnabled()
    {
        return $this->enabled;
    }

    /**
     * @inheritDoc
     */
    public function update($datetime)
    {
        // TODO: Implement update() method.
    }
}