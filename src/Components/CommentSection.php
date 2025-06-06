<?php

namespace CommentBuddy\Components;

use CommentBuddy\Services\CommentServiceInterface;
use CommentBuddy\Utils\Constants\AppEventListener;
use CommentBuddy\Utils\Constants\MessageType;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\View;
use Livewire\Component;

class CommentSection extends Component
{
    protected $view = 'comment-buddy::livewire.comment-section';

    public $post;
    public $body = '';
    public $comments;
    public bool $isAuthenticated;
    public bool $showToastMessage;

    protected $rules = [
        'body' => 'required|string|max:1000',
    ];

    protected $listeners = [
        'refresh-comments' => 'loadComments'
    ];

    protected CommentServiceInterface $commentService;

    public function boot(CommentServiceInterface $commentService)
    {
        $this->commentService = $commentService;
    }
    public function mount()
    {
        $this->isAuthenticated = Auth::check();
        $this->showToastMessage = Config::get('comment-buddy.show_message', true);
    }

    public function loadComments()
    {
        $this->comments = $this->commentService->all($this->post);
    }

    public function submit()
    {
        $this->validate();

        $this->commentService->create([
            'post_id' => $this->post->id,
            'user_id' => Auth::id(),
            'body' => $this->body,
        ]);

        $this->body = '';
        if ($this->showToastMessage){
            $this->dispatch(AppEventListener::TOAST_MESSAGE, details: [
                'message' => 'Comment posted',
                'type' => MessageType::SUCCESS
            ]);
        }
    }

    public function render()
    {
        $this->loadComments();
        return View::make($this->view);
    }
}
