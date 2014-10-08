<?php

use Mockery as m;

class UsersControllerTest extends TestCase
{
    /**
     * Mock user repository implementation.
     * 
     * @var Mockery
     */
    private $userRepository;

    /**
     * Mock user model implementation.
     * 
     * @var Mockery
     */
    private $userModel;

    /**
     * Prepare mock implementations before each test.
     * 
     * @return void
     */
    public function setUp()
    {
        parent::setUp();

        $this->userRepository = m::mock('Snappy\Repositories\UsersRepositoryInterface');
        $this->app->instance('Snappy\Repositories\UsersRepositoryInterface', $this->userRepository);

        $this->conversationModel = m::mock('Snappy\Conversation');
    }

    /**
     * Test that the index route returns all registered users.
     * 
     * @return void
     */
    public function test_index_route()
    {
        $this->userRepository->shouldReceive('all')->once()->andReturn(array());

        $this->call('GET', '/api/v1/users');

        $this->assertResponseOk();
    }

    /**
     * Test that the 'me' route returns the currently authenticated user.
     * 
     * @return void
     */
    public function test_me_route()
    {
        Auth::once([ 'email_address' => 'chris@brayniverse.com', 'password' => 'Password1' ]);
        
        $response = $this->call('GET', '/api/v1/users/me');

        $this->assertResponseOk();

        $this->assertEquals('chris@brayniverse.com', json_decode($response->getContent())->data->email_address);
    }
}