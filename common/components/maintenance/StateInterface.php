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
     *
     * @param string $datetime
     * @return mixed
     */
    public function enable($datetime);
    /**
     * Update text to mode file
     *
     * @param string $datetime
     * @return mixed
     */
    public function update($datetime);
    /**
     * Disable mode method
     *
     * @return mixed
     */
    public function disable();
    /**
     * @return bool
     */
    public function isEnabled();
}