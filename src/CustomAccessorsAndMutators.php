<?php

namespace Igorwanbarros\CustomAccessorAndMutator;


trait CustomAccessorsAndMutators
{

    protected $customMutators = [];

    protected $customAccessors = [];


    public function setAttribute($key, $value)
    {
        if (array_key_exists($key, $this->customMutators) &&
            isset($this->attributes[$key]) && !$this->hasSetMutator($key)
        ) {
            $method = $this->customMutators[$key];
            if (method_exists($this, $method)) {
                $this->attributes[$key] == $this->$method($value);
                return;
            }
        }

        parent::setAttribute($key, $value);
    }


    public function getAttributeValue($key)
    {
        if (array_key_exists($key, $this->customAccessors) && !$this->hasGetMutator($key)) {
            $method = $this->customAccessors[$key];
            if (method_exists($this, $method))
                return $this->$method($this->attributes[$key]);
        }

        return parent::getAttributeValue($key);
    }


    public function toArray()
    {
        $attributes = parent::toArray();
        $attributesAccessors = [];

        foreach ($this->customAccessors as $key => $methodAccessors)
            if (method_exists($this, $methodAccessors) && !$this->hasGetMutator($key))
                $attributesAccessors[$key] = $this->$methodAccessors($this->attributes[$key]);

        return array_merge($attributes, $attributesAccessors);
    }
}