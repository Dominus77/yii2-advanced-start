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
     * @param $datetime string
     * @param $title string
     * @param $content string
     * @param $subscribe bool
     * @return mixed
     */
    public function enable($datetime, $title, $content, $subscribe);

    /**
     * Update param text to mode file
     * @param $replace string
     * @param $line integer
     * @return mixed
     */
    public function update($replace, $line);

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