<?php

namespace CommentBuddy;

use CommentBuddy\Components\CommentForm;
use CommentBuddy\Components\CommentSection;
use CommentBuddy\Components\CommentThread;
use CommentBuddy\Services\CommentService;
use CommentBuddy\Services\CommentServiceInterface;
use Illuminate\Support\Facades\App;
use Illuminate\Support\ServiceProvider;
use Livewire\Livewire;

class CommentBuddyServiceProvider extends ServiceProvider
{
    public function register()
    {
        $this->app->bind(CommentServiceInterface::class, CommentService::class);

        $this->mergeConfigFrom(__DIR__ . '/../config/comment-buddy.php', 'comment-buddy');
    }

    public function boot()
    {
        $this->loadViewsFrom(__DIR__.'/../resources/views', 'comment-buddy');

        $this->publishes([
            __DIR__.'/../resources/views' => App::configPath('views/vendor/comment-buddy'),
        ], 'comment-buddy-views');

        $this->loadMigrationsFrom(__DIR__.'/../database/migrations');

        $this->publishes([
            __DIR__ . '/../config/comment-buddy.php' => App::configPath('comment-buddy.php'),
        ], 'comment-buddy-config');

        Livewire::component('comment-form', CommentForm::class);
        Livewire::component('comment-section', CommentSection::class);
        Livewire::component('comment-thread', CommentThread::class);
    }
}
