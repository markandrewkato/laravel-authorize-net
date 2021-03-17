<?php

namespace Markandrewkato\AuthorizeNet\DataType;

class BillingInfo extends BaseDataType
{
    protected $propertyMap = [
        'firstName',
        'lastName',
        'address',
        'city',
        'state',
        'zip'
    ];
    
    protected $properties = [
        'country' => 'USA'
    ];
}