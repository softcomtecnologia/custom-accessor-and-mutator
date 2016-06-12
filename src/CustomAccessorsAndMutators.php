<?php

namespace Igorwanbarros\CustomAccessorAndMutator;


trait CustomAccessorsAndMutators
{

    public function setAttribute($key, $value)
    {
        if ($this->_hasExistsCustomMutators($key) && isset($this->attributes[$key]) && !$this->hasSetMutator($key)) {

            if ($this->_hasMethodCustomAccessorsAndMutatorsExists($this->customMutators[$key])) {
                $this->attributes[$key] = $this->_callMethodMutator($key, $value);
                return $this;
            }
        }

        return parent::setAttribute($key, $value);
    }


    public function getAttributeValue($key)
    {
        if ($this->_hasExistsCustomAccessors($key) && !$this->hasGetMutator($key))
            if ($this->_hasMethodCustomAccessorsAndMutatorsExists($this->customAccessors[$key]))
                return $this->_callMethodAccessor($key, $this->attributes[$key]);


        return parent::getAttributeValue($key);
    }


    public function toArray()
    {
        $attributes = parent::toArray();
        $attributesAccessors = [];

        if (!is_array($this->customAccessors))
            return $attributes;

        foreach ($this->customAccessors as $key => $classOrMethod) {
            $value = $this->attributes[$key];

            if (($this->_hasMethodCustomAccessorsAndMutatorsExists($classOrMethod) ||
                    $this->_hasClassAccessorsAndMutatorsExists($classOrMethod)) &&
                !$this->hasGetMutator($key)
            )
                $attributesAccessors[$key] = $this->_callMethodAccessor($key, $value);
        }

        return array_merge($attributes, $attributesAccessors);
    }


    private function _hasExistsCustomAccessors($key)
    {
        return isset($this->customAccessors) && array_key_exists($key, $this->customAccessors);
    }


    private function _hasExistsCustomMutators($key)
    {
        return isset($this->customMutators) && array_key_exists($key, $this->customMutators);
    }


    private function _hasMethodCustomAccessorsAndMutatorsExists($method)
    {
        return method_exists($this, $method) || class_exists($method);
    }


    private function _callMethodAccessor($key, $value)
    {
        $classOrMethod = $this->customAccessors[$key];

        if ($this->_hasClassAccessorsAndMutatorsExists($classOrMethod))
            return $classOrMethod::get($value);

        if ($this->_hasMethodCustomAccessorsAndMutatorsExists($classOrMethod))
            return $this->{$classOrMethod}($value);

        return $value;
    }


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


    private function _hasClassAccessorsAndMutatorsExists($class)
    {
        if (!class_exists($class))
            return false;

        $reflection = new \ReflectionClass($class);

        return $reflection->implementsInterface(FormatAccessorAndMutator::class);
    }
}
