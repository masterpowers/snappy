<?php namespace Snappy\Http\Transformers;

use Snappy\Message;
use League\Fractal\TransformerAbstract;
use Snappy\Http\Transformers\UserTransformer;

class MessageTransformer extends TransformerAbstract
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
    protected $availableIncludes = ['author'];

    /**
     * Transform single resource instance.
     * 
     * @param  Snappy\Message  $message
     * @return array
     */
    public function transform(Message $message)
    {
        return [
            'user_id'    => (string) $message->user_id,
            'chat_id'    => (string) $message->chat_id,
            'id'         => (string) $message->id,
            'type'       => (string) $message->type,
            'content'    => (string) $message->content,
            'created_at' => (string) $message->created_at
        ];
    }

    public function includeAuthor(Message $message)
    {
        $author = $message->author;

        return $this->item($author, new UserTransformer);
    }
}