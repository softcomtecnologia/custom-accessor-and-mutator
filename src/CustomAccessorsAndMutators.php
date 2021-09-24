<?php

namespace Softcomtecnologia\CustomAccessorAndMutator;

/**
 * Trait CustomAccessorsAndMutators
 * @package Softcomtecnologia\CustomAccessorAndMutator
 */
trait CustomAccessorsAndMutators
{

    /**
     * Overwrite method of Model class to assign (s) mutator (s) custom (s).
     *
     * @param  string $key
     * @param  mixed  $value
     *
     * @return $this
     */
    public function setAttribute($key, $value)
    {
        if ($this->_hasExistsCustomMutators($key) && array_key_exists($key, $this->attributes) && !$this->hasSetMutator($key)) {
            if ($this->_hasMethodCustomAccessorsAndMutatorsExists($this->customMutators[$key])) {
                $this->attributes[$key] = $this->_callMethodMutator($key, $value);
                return $this;
            }
        }

        return parent::setAttribute($key, $value);
    }


    /**
     * Overwrite method of Model class for a simple attribute.
     *
     * @param  string $key
     *
     * @return mixed
     */
    public function getAttributeValue($key)
    {
        if ($this->_hasExistsCustomAccessors($key) && !$this->hasGetMutator($key))
            if ($this->_hasMethodCustomAccessorsAndMutatorsExists($this->customAccessors[$key]))
                return $this->_callMethodAccessor($key, $this->attributes[$key]);


        return parent::getAttributeValue($key);
    }


    /**
     * Convert the model instance to an array assigning specific accessor.
     *
     * @return array
     */
    public function toArray()
    {
        $attributes = parent::toArray();
        $attributesAccessors = [];

        if (!is_array($this->customAccessors))
            return $attributes;

        foreach ($this->customAccessors as $key => $classOrMethod) {
            $value = array_key_exists($key, $this->attributes) ? $this->attributes[$key] : null;

            if (($this->_hasMethodCustomAccessorsAndMutatorsExists($classOrMethod) ||
                    $this->_hasClassAccessorsAndMutatorsExists($classOrMethod)) &&
                !$this->hasGetMutator($key)
            )
                $attributesAccessors[$key] = $this->_callMethodAccessor($key, $value);
        }

        return array_merge($attributes, $attributesAccessors);
    }


    /**
     * Checks whether the key exists
     *
     * @param $key
     *
     * @return bool
     */
    private function _hasExistsCustomAccessors($key)
    {
        return isset($this->customAccessors) && array_key_exists($key, $this->customAccessors);
    }


    /**
     * Checks whether the key exists
     *
     * @param $key
     *
     * @return bool
     */
    private function _hasExistsCustomMutators($key)
    {
        return isset($this->customMutators) && array_key_exists($key, $this->customMutators);
    }


    /**
     * Verifies that the method exists in the class
     *
     * @param $method
     *
     * @return bool
     */
    private function _hasMethodCustomAccessorsAndMutatorsExists($method)
    {
        return method_exists($this, $method) || class_exists($method);
    }


    /**
     * Executes the logic specific for accessor
     *
     * @param $key
     * @param $value
     *
     * @return mixed
     */
    private function _callMethodAccessor($key, $value)
    {
        $classOrMethod = $this->customAccessors[$key];

        if ($this->_hasClassAccessorsAndMutatorsExists($classOrMethod) || class_exists($classOrMethod)) {
            return $classOrMethod::get($value);
        }

        if ($this->_hasMethodCustomAccessorsAndMutatorsExists($classOrMethod) && method_exists($this, $classOrMethod)) {
            return $this->{$classOrMethod}($value);
        }

        return $value;
    }


    /**
     * Executes the logic specific for mutator
     *
     * @param $key
     * @param $value
     *
     * @return mixed
     */
    private function _callMethodMutator($key, $value)
    {
        $classOrMethod = $this->customMutators[$key];

        if ($this->_hasClassAccessorsAndMutatorsExists($classOrMethod)) {
            return $classOrMethod::set($value);
        }

        if ($this->_hasMethodCustomAccessorsAndMutatorsExists($classOrMethod))
            return $this->{$classOrMethod}($value);

        return $value;
    }


    /**
     * Verifies that the specified class exists and implements a particular interface
     *
     * @param $class
     *
     * @return bool
     */
    private function _hasClassAccessorsAndMutatorsExists($class)
    {
        if (!class_exists($class))
            return false;

        $reflection = new \ReflectionClass($class);

        return $reflection->implementsInterface(FormatAccessorAndMutator::class);
    }
}
