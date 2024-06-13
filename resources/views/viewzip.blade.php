<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-2xl text-gray-900 leading-tight">View Zip</h2>
    </x-slot>

    <div class="container mx-auto px-4 py-8 w-10/12">
        <form action="{{ route('upload_zip') }}" method="post" enctype="multipart/form-data">
            @csrf
            <div class="bg-white shadow-md rounded px-8 pt-6 pb-8 mb-4">
                <div class="mb-4">
                    <label class="block text-gray-700 text-sm font-bold mb-2" for="zipFile">
                        Upload ZIP File
                    </label>
                    <input type="file"
                        class="text-sm text-stone-500 file:mr-5 file:py-1 file:px-3 file:border-[1px] file:text-xs file:font-medium file:bg-stone-50 file:text-stone-700 hover:file:cursor-pointer hover:file:bg-blue-50 hover:file:text-blue-700"
                        id="zipFile" name="zipFile" required>
                </div>
                <div class="mb-4">
                    <label class="block text-gray-700 text-sm font-bold mb-2" for="password">
                        ZIP Password (if any)
                    </label>
                    <input type="password"
                        class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline"
                        id="password" name="password" placeholder="Enter password if needed">
                </div>
                <div class="flex items-center justify-between">
                    <button
                        class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline"
                        type="submit">
                        Submit
                    </button>
                </div>
            </div>
        </form>

        @if (isset($filenames) && count($filenames) > 0)
            <div class="bg-white shadow-md rounded px-8 pt-6 pb-8 mb-4">
                <h3 class="font-semibold text-lg text-gray-900 leading-tight">Extracted Files</h3>
                <ul>
                    @foreach ($filenames as $filename)
                        <li>
                            <button onclick="openModal('{{ str_replace('/', '-', $filename) }}')"
                                class="text-blue-500 underline">
                                {{ basename($filename) }}
                            </button>
                        </li>
                    @endforeach
                </ul>
            </div>
        @endif

        @if (isset($filenames) && count($filenames) > 0)
            @foreach ($filenames as $filename)
                <div id="modal-{{ str_replace('/', '-', $filename) }}"
                    class="fixed z-10 inset-0 overflow-y-auto hidden">
                    <div class="flex items-end justify-center min-h-screen pt-4 px-4 pb-20 text-center sm:block sm:p-0">
                        <div class="fixed inset-0 transition-opacity" aria-hidden="true">
                            <div class="absolute inset-0 bg-gray-500 opacity-75"></div>
                        </div>
                        <span class="hidden sm:inline-block sm:align-middle sm:h-screen" aria-hidden="true">​</span>
                        <div
                            class="inline-block align-bottom bg-white rounded-lg text-left overflow-hidden shadow-xl transform transition-all sm:my-8 sm:align-middle sm:max-w-4xl sm:w-full">
                            <div class="bg-white px-4 pt-5 pb-4 sm:p-6 sm:pb-4">
                                <iframe src="{{ route('view_file', ['filename' => $filename]) }}"
                                    class="w-full h-96 sm:h-120 border-0"></iframe>
                            </div>
                            <div class="bg-gray-50 px-4 py-3 sm:px-6 sm:flex sm:flex-row-reverse">
                                <button type="button" onclick="closeModal('{{ str_replace('/', '-', $filename) }}')"
                                    class="mt-3 w-full inline-flex justify-center rounded-md border border-gray-300 shadow-sm px-4 py-2 bg-white text-base font-medium text-gray-700 hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 sm:mt-0 sm:ml-3 sm:w-auto sm:text-sm">
                                    Close
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            @endforeach
        @endif

    </div>

    <x-slot name="scripts">
        <script>
            function openModal(id) {
                document.getElementById('modal-' + id).classList.remove('hidden');
            }

            function closeModal(id) {
                document.getElementById('modal-' + id).classList.add('hidden');
            }
            window.addEventListener('beforeunload', function(e) {
                // Make an AJAX request to delete the extracted folder
                fetch('/delete-extracted-folder')
                    .then(response => {
                        if (!response.ok) {
                            console.error('Failed to delete extracted folder');
                        }
                    })
                    .catch(error => {
                        console.error('Error:', error);
                    });
            });
        </script>
    </x-slot>
</x-app-layout>
