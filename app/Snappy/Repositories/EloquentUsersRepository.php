<?php namespace Snappy\Repositories;

use Snappy\User;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Snappy\Support\Exceptions\ResourceNotFoundException;

class EloquentUsersRepository implements UsersRepositoryInterface
{
    /**
     * {@inheritdoc}
     */
    public function all()
    {
        return User::all();
    }
    
    /**
     * {@inheritdoc}
     */
    public function register($email_address, $password, $name)
    {
        return User::create(compact('email_address', 'password', 'name'));
    }

    /**
     * {@inheritdoc}
     */
    public function findById($id)
    {
        try {
            return User::findOrFail($id);
        } catch (ModelNotFoundException $e) {
            throw new ResourceNotFoundException;
        }
    }

    /**
     * {@inheritdoc}
     */
    public function findByEmail($email)
    {
        try {
            return User::where([ 'email_address' => $email ])->firstOrFail();
        } catch (ModelNotFoundException $e) {
            throw new ResourceNotFoundException;
        }
    }
    
    /**
     * {@inheritdoc}
     */
    public function deleteById($id)
    {
        try {
            User::delete($id);
        } catch (ModelNotFoundException $e) {
            throw new ResourceNotFoundException;
        }
    }
}