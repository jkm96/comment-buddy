<div class="my-2">
    @if($isAuthenticated)
        <form wire:submit.prevent="submit" class="mb-4 text-left">
            <textarea wire:model.defer="body" rows="2" class="w-full p-2 text-sm bg-gray-700 border border-gray-500 rounded focus:outline-none
                                    focus:border-gray-400 focus:ring-1 focus:ring-gray-400 focus:ring-opacity-50" placeholder="Write a comment..."></textarea>
            @error('body') <p class="text-red-500 text-xs mb-1">{{ $message }}</p> @enderror

            <button type="submit"
                    class="text-xs py-1 px-2 rounded-md flex items-center justify-center gap-2">
                <span wire:loading.remove>Post Comment</span>
                <span wire:loading>
                   Loading...
                </span>
            </button>
        </form>
    @else
        <p class="text-sm text-gray-600">
            You must be logged in to comment.
        </p>
    @endif

    @forelse($comments as $comment)
        <livewire:blog.comment-thread
            :comment="$comment"
            :depth="0"
            :key="'comment-'.$comment->id.'-'.$comment->updated_at"
        />
    @empty
        <p class="text-sm text-gray-500">No comments yet.</p>
    @endforelse
</div>
