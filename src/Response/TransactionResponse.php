<?php

namespace Markandrewkato\AuthorizeNet\Response;

class TransactionResponse
{
    private $response;
    
    public function __construct($response)
    {
        $this->response = $response;
    }
    
    /**
     * Returns the response code
     *
     * @return mixed
     */
    public function getResponseCode()
    {
        return $this->response['responseCode'];
    }
    
    /**
     * Returns true if payment is approved
     * Reference: https://developer.authorize.net/api/reference/index.html#gettingstarted-section-section-header
     *
     * @return bool
     */
    public function isApproved()
    {
        return $this->getResponseCode() === '1';
    }
    
    public function isDeclined()
    {
        return $this->getResponseCode() === '2';
    }
    
    public function isError()
    {
        return $this->getResponseCode() === '3';
    }
    
    public function isForReview()
    {
        return $this->getResponseCode() === '4';
    }
    
    /**
     * Gets the transaction ID generated when payment is completed
     *
     * @return mixed
     */
    public function getTransactionId()
    {
        return $this->response['transId'];
    }
    
    /**
     * Gets the last 4 digits of the credit card number used for payment
     *
     * @return string|null
     */
    public function getAccountNumber()
    {
        return $this->response['accountNumber'];
    }
    
    /**
     * Gets the type of credit card used upon payment
     *
     * @return mixed
     */
    public function getAccountType()
    {
        return $this->response['accountType'];
    }
    
    /**
     * Returns an array of code and description if the transaction is success
     *
     * @return array|mixed
     */
    public function getMessages()
    {
        return $this->response['messages'] ?? [];
    }
    
    /**
     * Returns an array with the list of errors
     * Reference: https://developer.authorize.net/api/reference/dist/json/responseCodes.json
     *
     * @return array|mixed
     */
    public function getErrors()
    {
        return $this->response['errors'] ?? [];
    }
    
    /**
     * Gets the first message description in the list of messages
     *
     * @return mixed|string
     */
    public function getMessage()
    {
        if (array_key_exists('messages', $this->response)) {
            return $this->getMessages()[0]['description'] ?? '';
        }
        
        return $this->getErrors()[0]['errorText'];
    }
    
}