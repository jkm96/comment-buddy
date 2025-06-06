![GitHub release (latest by date)](https://img.shields.io/github/v/release/jkm96/comment-buddy?display_name=tag&color=blue)
![GitHub license](https://img.shields.io/github/license/jkm96/comment-buddy?color=green)
# Comment Buddy

**Comment Buddy** is a plug-and-play Laravel Livewire comment system for posts. It supports nested replies and optional success toasts for a seamless commenting experience.

---

## Installation

Install the package via Composer:

```bash
composer require jkm96/comment-buddy
```

Publish the configuration file:

```bash
php artisan vendor:publish --tag=comment-buddy-config
```

This command creates the configuration file at `config/comment-buddy.php`.

Run the migrations to create the necessary database tables:

```bash
php artisan migrate
```

---

## Configuration

Edit the configuration file `config/comment-buddy.php` to customize the package behavior:

```php
return [
    'comment_model' => Comment::class,
    'show_message' => true,
];
```

- `comment_model` — The Eloquent model used to store comments.
- `show_message` — Enable or disable toast messages on successful actions.

---

## Usage

To include the comment system in a Blade view (e.g., on a post detail page), add:

```blade
<livewire:comment-section :post="$post" />
```

Make sure your post model has an `id` and a relationship to comments.

If `show_message` is enabled, listen for toast messages with Livewire:

```html
<script>
    Livewire.on('toast-message', details => {
        alert(details.message); // Replace this with your own toast notification logic
    });
</script>
```

---

## How It Works

- `comment-section` — renders the entire comment thread along with the comment form.
- `comment-form` — handles submitting new comments and replies.
- `comment-thread` — renders nested replies recursively.
- Uses Livewire for reactive, dynamic UI updates.
- Comments are saved via the model defined in `comment_model` configuration.

---

## Service Provider

Comment Buddy auto-registers Livewire components and loads resources through its service provider:

```php
Livewire::component('comment-form', CommentForm::class);
Livewire::component('comment-section', CommentSection::class);
Livewire::component('comment-thread', CommentThread::class);
```

It also loads views, migrations, and merges the configuration from:

```
__DIR__ . '/../config/comment-buddy.php'
```

---

## Authentication

User authentication is required to post comments. If a user is not logged in, the comment form will not be displayed.

**Note:** Guest commenting is not supported out of the box.

---

Feel free to customize and extend Comment Buddy to fit your project's needs!
