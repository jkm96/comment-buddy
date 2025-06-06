<?php

namespace CommentBuddy\Services;

use CommentBuddy\Models\Comment;

interface CommentServiceInterface
{
    public function all($post);

    public function find(int $id): ?Comment;

    public function create(array $data): Comment;

    public function update(int $id, array $data): Comment;

    public function delete(int $id);

    public function replies($comment);
}
