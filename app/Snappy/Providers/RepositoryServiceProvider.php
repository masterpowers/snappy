<?php namespace Snappy\Providers;

use Illuminate\Support\ServiceProvider;

class RepositoryServiceProvider extends ServiceProvider
{
    /**
     * Register the service provider.
     *
     * @return void
     */
    public function register()
    {
        $this->app->bind(
          'Snappy\Repositories\ChatsRepositoryInterface',
          'Snappy\Repositories\EloquentChatsRepository'
        );

        $this->app->bind(
            'Snappy\Repositories\UsersRepositoryInterface',
            'Snappy\Repositories\EloquentUsersRepository'
        );
    }
}