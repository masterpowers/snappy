<?php namespace Snappy\Http\Controllers\Api;

use Auth;
use Input;
use Response;
use League\Fractal\Manager;
use Snappy\Http\Transformers\UserTransformer;
use Snappy\Repositories\UsersRepositoryInterface;

class AuthController extends BaseApiController
{
    public function __construct(Manager $fractal, UsersRepositoryInterface $repository)
    {
        $this->fractal = $fractal;

        $this->repository = $repository;
    }

    public function attempt()
    {
        if (Auth::attempt(Input::only('email_address', 'password')))
        {
            return $this->respondWithItem(Auth::user(), new UserTransformer);
        }

        return Response::make(null, 401);
    }

    public function logout()
    {
        Auth::logout();

        return Response::make(null, 204);
    }

    public function register()
    {
        try {
            $user = $this->repository->register(Input::get('email_address'), Input::get('password'), Input::get('name'));

            return $this->setStatusCode(201)->respondWithItem($user, new UserTransformer);
        } catch (\Exception $e) {
            return Response::make($e->getMessage(), 500);
        }
    }
}