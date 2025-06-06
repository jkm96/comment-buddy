<div class="ml-{{ $depth }} mt-2 relative text-left">
    @if(!empty($comment))
        <div
            class="p-2 {{ $depth > 0 ? 'bg-gray-600' : 'bg-gray-700' }} shadow-md text-sm transition-all hover:bg-gray-600">

            @if($editingCommentId === $comment->id)
                <form wire:submit.prevent="updateComment({{ $comment->id }})">
                <textarea wire:model.defer="editingBody" rows="2" class="w-full p-2 text-sm bg-gray-700 border border-gray-500 rounded focus:outline-none
                                    focus:border-gray-400 focus:ring-1 focus:ring-gray-400 focus:ring-opacity-50"
                          placeholder="Edit your comment...">{{ $comment->body }}</textarea>
                    @error('editingBody') <p class="text-red-500 text-xs">{{ $message }}</p> @enderror

                    <button type="submit"
                            class="{{ get_theme_setting('theme_button_style') }} text-xs py-1 px-2">
                        <span wire:loading.remove> Save Changes</span>
                        <span wire:loading>
                       Loading...
                    </span>
                    </button>

                    <button type="button" wire:click="cancelEdit"
                            class="text-xs py-1 px-2 bg-gray-500">
                        Cancel
                    </button>
                </form>
            @else
                <p class="text-md mb-1"><span class="font-bold">{{ $comment->user->name ?? 'Anonymous' }}</span> •
                    <span class="text-gray-400">{{ $comment->created_at->diffForHumans() }}</span></p>
                <p>{{ $comment->body }}</p>
            @endif

            @auth
                <button
                    wire:click="setReplyingTo({{ $comment->id }})"
                    class="text-xs text-blue-400 hover:underline mt-1">
                    {{ $replyingTo === $comment->id ? 'Cancel' : 'Reply' }}
                </button>

                @if(auth()->id() === $comment->user_id)
                    <button wire:click="setEditingComment({{ $comment->id }})"
                            class="text-xs text-blue-400 hover:underline mt-1">
                        Edit
                    </button>

                    <button wire:click="deleteComment({{ $comment->id }})"
                            class="text-xs text-red-400 hover:underline mt-1">
                        Delete
                    </button>
                @endif

                @if ($replyingTo === $comment->id)
                    <livewire:blog.comment-form
                        :postId="$comment->post_id"
                        :parentId="$comment->id"
                        wire:key="reply-form-{{ $comment->id }}"
                    />
                @endif
            @endauth
        </div>

        <div
            class="absolute top-0 left-0 h-full border-l-2 {{ $depth > 0 ? 'border-gray-500' : 'border-gray-600' }}"></div>

        @if ($depth < $maxDepth)
            @foreach ($comment->replies as $child)
                <livewire:blog.comment-thread
                    :comment="$child"
                    :replyingTo="$replyingTo"
                    :depth="$depth + 1"
                    wire:key="thread-{{ $child->id }}-{{ $child->updated_at->timestamp }}"
                />
            @endforeach
        @endif
    @endif
</div>
