<form wire:submit="submit" class="p-6 bg-white rounded-lg shadow-xl">
    {{ $this->form }}

    <button type="submit"
        class="mt-6 px-6 py-2 text-white bg-blue-500 rounded-lg hover:bg-blue-600 transition duration-300">
        SUBMIT
    </button>

    @if (session()->has('success'))
        <div class="mt-4 p-3 bg-green-100 text-green-700 rounded-lg">
            {{ session('success') }}
        </div>
    @endif

</form>
