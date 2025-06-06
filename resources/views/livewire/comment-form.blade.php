<form wire:submit.prevent="submit" class="mt-2">
    <textarea
        wire:model.defer="body"
        rows="2"
        class="w-full p-2 text-sm bg-gray-900 border border-gray-600 rounded focus:outline-none focus:ring focus:border-blue-400"
        placeholder="Write a reply..."></textarea>
    @error('body') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror

    <button type="submit"
            class="text-xs py-1 px-2 rounded-md flex items-center justify-center gap-2">
        <span wire:loading.remove>Post Reply</span>
        <span wire:loading>
           Loading...
        </span>
    </button>
</form>
