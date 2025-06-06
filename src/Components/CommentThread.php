<?php

namespace CommentBuddy\Components;

use CommentBuddy\Models\Comment;
use CommentBuddy\Services\CommentServiceInterface;
use CommentBuddy\Utils\Constants\AppEventListener;
use CommentBuddy\Utils\Constants\MessageType;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\View;
use Livewire\Component;

class CommentThread extends Component
{
    protected $view = 'comment-buddy::livewire.comment-thread';
    public $comment;
    public $replyingTo;
    public $depth = 0;
    public $maxDepth = 3;

    public $editingCommentId = null;
    public $editingBody = '';
    public bool $showToastMessage;

    protected $rules = [
        'editingBody' => 'required|string|max:1000',
    ];

    protected $listeners = ['comment-added' => 'handleCommentAdded'];

    protected CommentServiceInterface $commentService;

    public function boot(CommentServiceInterface $commentService)
    {
        $this->commentService = $commentService;
    }
    public function mount()
    {
        $this->showToastMessage = Config::get('comment-buddy.show_message', true);
    }
    public function setEditingComment($commentId)
    {
        $this->editingCommentId = $commentId;
        $this->editingBody = Comment::find($commentId)->body;
    }

    public function cancelEdit()
    {
        $this->editingCommentId = null;
        $this->editingBody = '';
    }

    public function updateComment($commentId)
    {
        $this->validate();

        $this->comment = $this->commentService->update($commentId, ['body' => $this->editingBody]);
        $this->editingCommentId = null;
        $this->editingBody = '';

        if ($this->showToastMessage) {
            $this->dispatch(AppEventListener::TOAST_MESSAGE, details: [
                'message' => 'Edited successfully',
                'type' => MessageType::SUCCESS
            ]);
        }
        $this->dispatch('refresh-comments')->to(CommentSection::class);
    }

    public function deleteComment($commentId)
    {
        $comment = Comment::find($commentId);
        $comment->delete();

        $this->comment = $comment->fresh(['user', 'replies.user']);

        if ($this->showToastMessage) {
            $this->dispatch(AppEventListener::TOAST_MESSAGE, details: [
                'message' => 'Deleted successfully',
                'type' => MessageType::SUCCESS
            ]);
        }

        $this->dispatch('refresh-comments')->to(CommentSection::class);
    }

    public function handleCommentAdded($id)
    {
        $this->replyingTo = null;
    }

    public function setReplyingTo($commentId)
    {
        $this->replyingTo = $this->replyingTo === $commentId ? null : $commentId;
    }

    public function getRepliesProperty()
    {
        return $this->commentService->replies($this->comment);
    }

    public function render()
    {
        return View::make($this->view);
    }
}
