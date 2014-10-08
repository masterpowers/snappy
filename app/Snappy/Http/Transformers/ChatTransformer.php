<?php namespace Snappy\Http\Transformers;

use Snappy\Chat;
use League\Fractal\TransformerAbstract;
use Snappy\Http\Transformers\UserTransformer;
use Snappy\Http\Transformers\MessageTransformer;

class ChatTransformer extends TransformerAbstract
{
    /**
     * List of resources to automatically include.
     * 
     * @var array
     */
    protected $defaultIncludes = [];

    /**
     * Resources available to include in the response.
     * 
     * @var array
     */
    protected $availableIncludes = ['recipients', 'messages'];
    
    /**
     * Transform single resource instance.
     * 
     * @param  Snappy\Chat  $chat
     * @return array
     */
    public function transform(Chat $chat)
    {
        return [
            'id' => (string) $chat->id
        ];
    }

    /**
     * Include the chat recipients.
     * 
     * @param  Snappy\Chat  $chat
     * @return League\Fractal\Resource\Collection
     */
    public function includeRecipients(Chat $chat)
    {
        $recipients = $chat->recipients;

        return $this->collection($recipients, new UserTransformer);
    }

    /**
     * Include the chat messages.
     * 
     * @param  Snappy\Chat  $chat
     * @return League\Fractal\Resource\Collection
     */
    public function includeMessages(Chat $chat)
    {
        $messages = $chat->messages;

        return $this->collection($messages, new MessageTransformer);
    }
}
