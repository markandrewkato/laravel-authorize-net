<?php

namespace Markandrewkato\AuthorizeNet\DataType;

use Carbon\Carbon;

class CreditCard extends BaseDataType
{
    protected $propertyMap = [
        'cardNumber',
        'expirationDate',
        'cardCode'
    ];
    
    public function __set($name, $value)
    {
        if ($name === 'expirationDate') {
            $value = Carbon::createFromFormat('m/y', $value)->format('Y-m');
        }
        
        $this->properties[$name] = $value;
    }
}