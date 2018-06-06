<?php

namespace Softcomtecnologia\CustomAccessorAndMutator;

/**
 * Interface FormatAccessorAndMutator
 * @package Softcomtecnologia\CustomAccessorAndMutator
 */
interface FormatAccessorAndMutator
{

    /**
     * Method responsible for setting the value to be displayed
     *
     * @param $value
     *
     * @return $value
     */
    public static function get($value);


    /**
     * Method responsible for setting the value to be stored (mutator).
     *
     * @param $value
     *
     * @return $value
     */
    public static function set($value);
}
