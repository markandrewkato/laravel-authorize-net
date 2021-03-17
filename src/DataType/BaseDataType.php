<?php


namespace Markandrewkato\AuthorizeNet\DataType;


class BaseDataType
{
    protected $propertyMap = [];
    protected $properties;
    
    public function __construct(array $values = [])
    {
        foreach ($values as $name => $value) {
            $this->$name = $value;
        }
    }
    
    public function toArray()
    {
        $sorted_properties = [];
        foreach ($this->propertyMap as $property_key) {
            if (isset($this->properties[$property_key])) {
                $sorted_properties[$property_key] = $this->properties[$property_key];
            }
        }
        $sorted_properties += $this->properties;
        return $sorted_properties;
    }
    
    public function getType()
    {
        return lcfirst((new \ReflectionClass($this))->getShortName());
    }
    
    public function __set($name, $value)
    {
        $this->properties[$name] = $value;
    }
    
    public function __get($name)
    {
        return $this->properties[$name];
    }
    
    public function __isset($name)
    {
        return isset($this->properties[$name]);
    }
    
    public function __unset($name)
    {
        unset($this->properties[$name]);
    }
    
    public function addData($name, $value)
    {
        $this->properties[$name] = $value;
    }
}