<?php namespace Snappy\Http\Controllers\Api;

use Auth;
use League\Fractal\Manager;
use Snappy\Http\Transformers\UserTransformer;
use Snappy\Repositories\UsersRepositoryInterface;
use Snappy\Support\Exceptions\ResourceNotFoundException;

class UsersController extends BaseApiController
{
    private $repository;
    
    /**
     * Create a new users controller instance.
     * 
     * @return void
     */
    public function __construct(Manager $fractal, UsersRepositoryInterface $repository)
    {
        parent::__construct($fractal);

        $this->repository = $repository;
    }

    /**
     * 
     * 
     * @return Response
     */
    public function index()
    {
        $users = $this->repository->all();

        return $this->respondWithCollection($users, new UserTransformer);
    }

    /**
     * 
     * 
     * @return Response
     */
    public function me()
    {
        $user = Auth::user();

        return $this->respondWithItem($user, new UserTransformer);
    }
}
