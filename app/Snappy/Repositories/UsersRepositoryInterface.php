<?php namespace Snappy\Repositories;

interface UsersRepositoryInterface
{
    /**
     * Return all users.
     * 
     * @return Illuminate\Database\Eloquent\Collection
     */
    public function all();

    /**
     * Register a new user.
     * 
     * @param  string  $email
     * @param  string  $password
     * @param  string  $name
     * @return Snappy\User
     */
    public function register($email, $password, $name);

    /**
     * Find a single user by their ID.
     * 
     * @param  string  $id
     * @return Snappy\User
     */
    public function findById($id);

    /**
     * Find a single user by their email address.
     * 
     * @param  string  $email
     * @return Snappy\User
     */
    public function findByEmail($email);

    /**
     * Unregister a user by their ID.
     * 
     * @param  string  $id
     * @return void
     */
    public function deleteById($id);
}