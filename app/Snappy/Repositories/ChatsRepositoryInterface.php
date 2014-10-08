<?php namespace Snappy\Repositories;

interface ChatsRepositoryInterface
{
    /**
     * Return all chats.
     * 
     * @return Illuminate\Database\Eloquent\Collection
     */
    public function all();

    /**
     * Find a single chat by it's ID.
     * 
     * @param  string  $id
     * @return Snappy\Chat
     */
    public function findById($id);

    /**
     * Start a new chat.
     * 
     * @param  string  $userId
     * @return Snappy\Chat
     */
    public function store($userId);

    /**
     * End a chat by it's ID.
     * 
     * @param  string  $id
     * @return void
     */
    public function deleteById($id);
}