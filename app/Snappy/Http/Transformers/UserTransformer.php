<?php namespace Snappy\Http\Transformers;

use Snappy\User;
use League\Fractal\TransformerAbstract;
use Snappy\Http\Transformers\PhotoTransformer;
use Snappy\Http\Transformers\ConversationTransformer;

class UserTransformer extends TransformerAbstract
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
    protected $availableIncludes = ['conversations'];
    
    /**
     * Transform single resource instance.
     * 
     * @param  Snappy\User  $user
     * @return array
     */
    public function transform(User $user)
    {
        $defaultAvatar = 'http://freeiconbox.com/icon/256/42829.png';

        return [
            'id'            => (string) $user->id,
            'name'          => (string) $user->name,
            'email_address' => (string) $user->email_address,
            'avatar'        => (string) 'http://www.gravatar.com/avatar/' . md5(strtolower(trim($user->email_address))) . '?d=' . urlencode($defaultAvatar) . '&s=20'
        ];
    }

    /**
     * Include authenticated user's conversations.
     * 
     * @param  Snappy\User  $user
     * @return League\Fractal\Resource\Collection
     */
    public function includeConversations(User $user)
    {
        $conversations = $user->conversations;

        return $this->collection($conversations, new ConversationTransformer);
    }
}
