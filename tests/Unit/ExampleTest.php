<?php

namespace Tests\Unit;

use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;

class ExampleTest extends TestCase
{
    /**
     * A basic test example.
     *
     * @return void
     */
    public function testBasicTest()
    {
        $this->assertTrue(true);
    }

    public function testOpenCloseAccount()
    {
        // Open Account
        $response = $this->post('/api/v1/user/2/account', ['balance' => 20000]);
        $response
            ->assertStatus(200)
            ->assertExactJson([
                'status' => 'success'
            ]);

        // List Account
        $response = $this->get('/api/v1/user/2/account');
        $list = $response->decodeResponseJson();
        $index = count($list) - 1;
        $newId = $list[$index]['id'];


        // Close Account
        $response = $this->delete('/api/v1/user/2/account/' . $newId);
        $response
            ->assertStatus(200)
            ->assertExactJson([
                'status' => 'success'
            ]);

    }

    public function testCheckBalance()
    {
        // open Account with balance 20000
        $response = $this->post('/api/v1/user/2/account', ['balance' => 20000]);

        // List Account
        $response = $this->get('/api/v1/user/2/account');
        $list = $response->decodeResponseJson();
        $index = count($list) - 1;
        $newId = $list[$index]['id'];

        // show current balance
        $response = $this->get('/api/v1/user/2/account/' . $newId);
        $response->assertJson(['balance' => 20000]);

    }

    public function testWithdrawDeposit()
    {
        $response = $this->post('/api/v1/user/2/account/2/withdraw', ['amount' => 10000]);
        $response->assertJson(['status' => 'success']);

        $response = $this->post('/api/v1/user/2/account/2/deposit', ['amount' => 10000]);
        $response->assertJson(['status' => 'success']);
    }


}
