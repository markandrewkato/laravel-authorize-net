<?php

namespace Markandrewkato\AuthorizeNet\Tests;

use Illuminate\Foundation\Testing\WithFaker;
use Markandrewkato\AuthorizeNet\AuthorizeNet;
use Markandrewkato\AuthorizeNet\DataType\BillingInfo;
use Markandrewkato\AuthorizeNet\DataType\CreditCard;
use Markandrewkato\AuthorizeNet\Response\TransactionResponse;

class PaymentTest extends TestCase
{
    use WithFaker;
    
    private $loginId;
    private $key;
    
    public function setUp(): void
    {
        parent::setUp();
        
        $this->loginId = '25EywBAG5KzP';
        $this->key     = '56Zn3J9f8VHwp7zc';
    }
    
    /** @test */
    public function it_can_authenticate_if_key_is_valid()
    {
        $loggedIn = AuthorizeNet::make($this->loginId, $this->key)->check();
        
        $this->assertTrue($loggedIn);
    }
    
    /** @test */
    public function it_can_transact_a_card_payment()
    {
        $response = AuthorizeNet::make($this->loginId, $this->key)
            ->setCardInfo(new CreditCard([
                'cardNumber'     => '4111111111111111',
                'expirationDate' => '12/22',
                'cardCode'       => '1234'
            ]))
            ->setBillingInfo(new BillingInfo([
                'firstName' => $this->faker->firstName,
                'lastName'  => $this->faker->lastName,
                'address'   => $this->faker->address,
                'city'      => $this->faker->city,
                'state'     => $this->faker->state,
                'zip'       => $this->faker->postcode
            ]))
            ->charge(1);
        
        $this->assertInstanceOf(TransactionResponse::class, $response);
        $this->assertTrue($response->isForReview() || $response->isApproved());
    }
    
    /** @test */
    public function it_should_show_an_error_if_the_card_is_invalid()
    {
        $response = AuthorizeNet::make($this->loginId, $this->key)
            ->setCardInfo(new CreditCard([
                'cardNumber'     => '4111111111111111',
                'expirationDate' => '12/22',
                'cardCode'       => '1234'
            ]))
            ->setBillingInfo(new BillingInfo([
                'firstName' => $this->faker->firstName,
                'lastName'  => $this->faker->lastName,
                'address'   => $this->faker->address,
                'city'      => $this->faker->city,
                'state'     => $this->faker->state,
                'zip'       => '46282' // this zip will determine that its declined
            ]))
            ->charge(1);
        
        $this->assertFalse($response->isApproved());
    }
    
    /** @test */
    public function it_can_get_the_error_message()
    {
        $response = AuthorizeNet::make($this->loginId, $this->key)
            ->setCardInfo(new CreditCard([
                'cardNumber'     => '4111111111111112',
                'expirationDate' => '12/22',
                'cardCode'       => '1234'
            ]))
            ->setBillingInfo(new BillingInfo([
                'firstName' => $this->faker->firstName,
                'lastName'  => $this->faker->lastName,
                'address'   => $this->faker->address,
                'city'      => $this->faker->city,
                'state'     => $this->faker->state,
                'zip'       => '46282' // this zip will determine that its declined
            ]))
            ->charge(1);
    
        $this->assertEquals('The credit card number is invalid.', $response->getMessage());
    }
}
