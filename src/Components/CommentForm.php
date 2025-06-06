<?php

namespace CommentBuddy\Components;

use CommentBuddy\Services\CommentServiceInterface;
use CommentBuddy\Utils\Constants\AppEventListener;
use CommentBuddy\Utils\Constants\MessageType;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\View;
use Livewire\Component;

class CommentForm extends Component
{
    protected $view = 'comment-buddy::livewire.comment-form';
    public $postId;
    public $parentId = null;
    public $body = '';
    public bool $showToastMessage;

    protected $rules = [
        'body' => 'required|string|max:1000',
    ];

    protected CommentServiceInterface $commentService;

    public function boot(CommentServiceInterface $commentService)
    {
        $this->commentService = $commentService;
    }
    public function mount()
    {
        $this->showToastMessage = Config::get('comment-buddy.show_message', true);
    }
    public function submit()
    {
        $this->validate();

        $comment = $this->commentService->create([
            'post_id' => $this->postId,
            'parent_id' => $this->parentId,
            'user_id' => Auth::id(),
            'body' => $this->body,
        ]);

        $this->reset(['body']);
        if ($this->showToastMessage){
            $this->dispatch(AppEventListener::TOAST_MESSAGE, details: [
                'message' => 'Reply posted',
                'type' => MessageType::SUCCESS
            ]);
        }

        $this->dispatch('comment-added', $comment->id);
    }

    public function render()
    {
        return View::make($this->view);
    }
}
