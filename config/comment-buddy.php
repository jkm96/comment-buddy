<?php


use CommentBuddy\Models\Comment;

return [
    /*
    |--------------------------------------------------------------------------
    | Comment Model
    |--------------------------------------------------------------------------
    |
    | This is the Eloquent model used to store and retrieve comments.
    | You may change this to your own model if you need to customize
    | relationships, behaviors, or table names.
    |
    */
    'comment_model' => Comment::class,

    /*
   |--------------------------------------------------------------------------
   | Show Success Message After Commenting
   |--------------------------------------------------------------------------
   |
   | When set to true, a success toast or message will be dispatched after
   | a comment or reply is posted. To capture and display the message,
   | you must register a Livewire listener for the "toast-message" event
   | in your Blade view where the CommentSection component is used.
   |
   | Example:
   | <script>
   |     Livewire.on('toast-message', details => {
   |         alert(details.message);
   |     });
   | </script>
   |
   */
    'show_message' => true,
];
