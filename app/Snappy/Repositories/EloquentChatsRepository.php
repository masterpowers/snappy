<?php namespace Snappy\Repositories;

use Auth;
use Snappy\User;
use Snappy\Chat;
use Snappy\Message;
use Snappy\Http\Transformers\MessageTransformer;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Snappy\Support\Exceptions\ResourceNotFoundException;

class EloquentChatsRepository implements ChatsRepositoryInterface
{
    /**
     * {@inheritdoc}
     */
    public function all()
    {
        return Chat::whereHas('recipients', function($q) {
            $q->where('id', Auth::user()->id);
        })->get();
    }

    public function addRecipient($id, $recipientId)
    {
        try {
            $user = User::find($recipientId);

            $this->findById($id)->recipients()->attach($user);

            return $user;
        } catch (ModelNotFoundException $e) {
            throw new ResourceNotFoundException;
        }
    }

    public function addMessage($id, $content, $type)
    {
        $post = Message::create([
            'user_id' => Auth::user()->id,
            'chat_id' => $id,
            'content' => $content,
            'type' => $type
        ]);

        return $post;
    }

    /**
     * {@inheritdoc}
     */
    public function findById($id)
    {
        try {
            return Chat::find($id);
        } catch (ModelNotFoundException $e) {
            throw new ResourceNotFoundException;
        }
    }

    /**
     * {@inheritdoc}
     */
    public function store($userId)
    {
        $chat = Chat::create([ 'user_id' => $userId ]);

        $chat->recipients()->attach(Auth::user()->id);

        return $chat;
    }

    /**
     * {@inheritdoc}
     */
    public function deleteById($id)
    {
        try {
            return Chat::delete($id);
        } catch (ModelNotFoundException $e) {
            throw new ResourceNotFoundException;
        }
    }
}