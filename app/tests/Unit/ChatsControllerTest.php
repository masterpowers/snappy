<?php

use Mockery as m;

class ChatsControllerTest extends TestCase
{
    /**
     * Mock chat repository implementation.
     * 
     * @var Mockery
     */
    private $chatRepository;

    /**
     * Mock chat model implementation.
     * 
     * @var Mockery
     */
    private $chatModel;

    /**
     * Mock message model implementation.
     * 
     * @var Mockery
     */
    private $messageModel;

    /**
     * Mock user model implementation.
     *
     * @var Mockery
     */
    private $userModel;

    /**
     * Build mock implementations before each test.
     * 
     * @return void
     */
    public function setUp()
    {
        parent::setUp();

        $this->chatRepository = m::mock('Snappy\Repositories\ChatsRepositoryInterface');
        $this->app->instance('Snappy\Repositories\ChatsRepositoryInterface', $this->chatRepository);

        $this->chatModel = m::mock('Snappy\Chat');
        $this->messageModel = m::mock('Snappy\Message');
        $this->userModel = m::mock('Snappy\User');
    }

    /**
     * Test that the index route returns all chats from the repository.
     * 
     * @return void
     */
    public function test_index_route()
    {
        $this->chatRepository->shouldReceive('all')->once()->andReturn(array());

        $response = $this->call('GET', '/api/v1/chats');

        $this->assertResponseOk($response);
    }

    /**
     * Test that the show route returns a chat object.
     * 
     * @return void
     */
    public function test_show_route()
    {
        $this->chatRepository->shouldReceive('findById')->once()->andReturn($this->chatModel);
        $this->chatModel->shouldReceive('getAttribute');

        $this->call('GET', '/api/v1/chats/abc123');

        $this->assertResponseOk();
    }

    /**
     * Test that the store route passes information for a new chat to the
     * repository implementation and returns a new instance of the chat model.
     * 
     * @return void
     */
    public function test_store_route()
    {
        Auth::once([ 'email_address' => 'chris@brayniverse.com', 'password' => 'Password1' ]);

        $this->chatRepository->shouldReceive('store')->once()->andReturn($this->chatModel);
        $this->chatModel->shouldReceive('getAttribute');

        $this->call('POST', '/api/v1/chats');

        $this->assertResponseStatus(201);
    }

    /**
     * Test that the add message route attaches a new message to the specified
     * chat history and returns a new instance of the user model.
     * 
     * @return void
     */
    public function test_add_message_route()
    {
        Auth::once([ 'email_address' => 'chris@brayniverse.com', 'password' => 'Password1' ]);

        $this->chatRepository->shouldReceive('addMessage')->once()->andReturn($this->messageModel);
        $this->messageModel->shouldReceive('getAttribute');

        $this->call('POST', '/api/v1/chats/abc123/messages');

        $this->assertResponseStatus(201);
    }

    /**
     * Test add recipient route attaches a recipient to the specified chat
     * instance and returns an instance of user model.
     * 
     * @return void
     */
    public function test_add_recipient_route()
    {
        $this->chatRepository->shouldReceive('addRecipient')->once()->andReturn($this->userModel);
        $this->userModel->shouldReceive('getAttribute');

        $this->call('POST', '/api/v1/chats/abc123/recipients');

        $this->assertResponseStatus(201);
    }

    /**
     * Test destroy route.
     * 
     * @return void
     */
    public function test_destroy_route()
    {
        $this->chatRepository->shouldReceive('deleteById')->once();

        $this->call('DELETE', '/api/v1/chats/abc123');

        $this->assertResponseStatus(204);
    }

    /**
     * Destroy all built mock instances after every test.
     * 
     * @return void
     */
    public function tearDown()
    {
        parent::tearDown();
        m::close();
    }
}