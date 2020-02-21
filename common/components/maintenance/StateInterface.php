<?php

namespace common\components\maintenance;

/**
 * Interface StateInterface
 * @package common\components\maintenance
 */
interface StateInterface
{
    /**
     * Enable mode method
     */
    public function enable();
    /**
     * Disable mode method
     */
    public function disable();

    /**
     * @return bool
     */
    public function isEnabled();
}