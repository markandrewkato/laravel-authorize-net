<?php

namespace Markandrewkato\AuthorizeNet;

use Illuminate\Support\Facades\Http;
use Markandrewkato\AuthorizeNet\DataType\BillingInfo;
use Markandrewkato\AuthorizeNet\DataType\CreditCard;
use Markandrewkato\AuthorizeNet\Response\TransactionResponse;

class AuthorizeNet
{
    private $loginId;
    private $key;
    /**
     * @var CreditCard
     */
    private $card;
    /**
     * @var BillingInfo
     */
    private $billing;
    
    public function __construct($loginId, $key)
    {
        $this->loginId = $loginId;
        $this->key = $key;
    }
    
    public static function make($loginId, $key)
    {
        return new static($loginId, $key);
    }
    
    public function check()
    {
        $response = Http::post(config('authorize-net.endpoint'), [
            'authenticateTestRequest' => [
                'merchantAuthentication' => [
                    'name' => $this->loginId,
                    'transactionKey' => $this->key,
                ],
            ],
        ]);
        
        if ($response->ok()) {
            $content = $this->parseContentToArray($response->body());
            
            return array_key_exists('messages', $content) && $content['messages']['resultCode'] === 'Ok';
        }
        
        return false;
    }
    
    public function charge($amount)
    {
        $response = Http::post(config('authorize-net.endpoint'), [
            'createTransactionRequest' => [
                'merchantAuthentication' => [
                    'name' => $this->loginId,
                    'transactionKey' => $this->key,
                ],
                'transactionRequest' => [
                    'transactionType' => 'authCaptureTransaction',
                    'amount' => $amount,
                    'payment' => [
                        'creditCard' => $this->card->toArray(),
                    ],
                    'billTo' => $this->billing->toArray(),
                ],
            ],
        ]);
        
        if ($response->ok()) {
            $content = $this->parseContentToArray($response->body());
            
            if (array_key_exists('transactionResponse', $content)) {
                return new TransactionResponse($content['transactionResponse']);
            }
        }
        
        return new \Exception('Invalid response from the server.');
    }
    
    public function setCardInfo(CreditCard $card)
    {
        $this->card = $card;

        return $this;
    }
    
    public function setBillingInfo(BillingInfo $billing)
    {
        $this->billing = $billing;

        return $this;
    }
    
    private function parseContentToArray($body)
    {
        $content = preg_replace('/[\x00-\x1F\x80-\xFF]/', '', $body);

        return json_decode($content, true);
    }
}
