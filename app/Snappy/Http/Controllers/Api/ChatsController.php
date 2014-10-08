<?php namespace Snappy\Http\Controllers\Api;

use Auth;
use Input;
use Pusher;
use Response;
use League\Fractal\Manager;
use Snappy\Http\Transformers\UserTransformer;
use Snappy\Http\Transformers\ChatTransformer;
use Snappy\Http\Transformers\MessageTransformer;
use Snappy\Repositories\ChatsRepositoryInterface;

class ChatsController extends BaseApiController
{
    private $repository;
    private $pusher;
    
    /**
     * Create a new chats controller instance.
     * 
     * @return void
     */
    public function __construct(Manager $fractal, ChatsRepositoryInterface $repository, Pusher $pusher)
    {
        parent::__construct($fractal);

        $this->repository = $repository;
        $this->pusher = $pusher;
    }

    /**
     * 
     * 
     * @return Response
     */
    public function index()
    {
        $chats = $this->repository->all();
        
        return $this->respondWithCollection($chats, new ChatTransformer);
    }

    /**
     * 
     * 
     * @return Response
     */
    public function store()
    {
        $chat = $this->repository->store(Auth::user()->id);

        return $this->setStatusCode(201)->respondWithItem($chat, new ChatTransformer);
    }

    /**
     * 
     * 
     * @return Response
     */
    public function show($chatId)
    {
        $chat = $this->repository->findById($chatId);

        return $this->respondWithItem($chat, new ChatTransformer);
    }

    /**
     * 
     * 
     * @return Response
     */
    public function addMessage($chatId)
    {
        $message = $this->repository->addMessage($chatId, Input::get('content'), Input::get('type'));

        $response = $this->setStatusCode(201)->respondWithItem($message, new MessageTransformer);

        $this->pusher->trigger('chat', 'new_message', (string) $response->getContent());

        return $response;
    }

    /**
     * 
     * 
     * @return Response
     */
    public function addRecipient($chatId)
    {
        $user = $this->repository->addRecipient($chatId, Input::get('recipient_id'));

        return $this->setStatusCode(201)->respondWithItem($user, new UserTransformer);
    }

    /**
     * 
     * 
     * @return Response
     */
    public function destroy($chatId)
    {
        $this->repository->deleteById($chatId);
        
        return Response::make(null, 204);
    }
}
