<?php

namespace CommentBuddy\Services;

use CommentBuddy\Models\Comment;
use Illuminate\Database\Eloquent\Collection;

class CommentService implements CommentServiceInterface
{
    /**
     * @return mixed
     */
    public function all($post)
    {
      return $post->comments()->with('user', 'replies')->whereNull('parent_id')->get();
    }

    /**
     * @param int $id
     * @return Comment|null
     */
    public function find(int $id): ?Comment
    {
        return Comment::findOrFail($id);
    }

    /**
     * @param array $data
     * @return Comment
     */
    public function create(array $data): Comment
    {
        return Comment::create($data);
    }

    /**
     * @param int $id
     * @param array $data
     * @return Comment
     */
    public function update(int $id, array $data): Comment
    {
        $comment = $this->find($id);
        $comment->update($data);
        return $comment->fresh(['user', 'replies.user']);
    }

    /**
     * @param int $id
     */
    public function delete(int $id)
    {
        $comment = $this->find($id);
        $comment->delete();
    }

    public function replies($comment): Collection
    {
        $existingComment = $this->find($comment->id);
        return $existingComment->replies()->with('user')->get();
    }
}
