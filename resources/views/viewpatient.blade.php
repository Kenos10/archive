{{-- PATIENT DETAIL --}}
<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-2xl text-gray-900 leading-tight">{{ __('Patient Details') }}</h2>
    </x-slot>
    <div class="container mx-auto p-6 w-10/12">
        <div class="alert-container">
            @if ($message = Session::get('success'))
                <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded mb-4" role="alert">
                    <strong>{{ $message }}</strong>
                </div>
            @endif
            @if (count($errors) > 0)
                <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded mb-4" role="alert">
                    <ul>
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif
        </div>

        <div class="card bg-white rounded-lg shadow-lg mb-8">
            <div class="card-body p-6">
                <h5 class="text-xl font-bold mb-4">{{ $patient->fullName }}</h5>
                <p class="text-gray-700">
                    <strong>Hospital Record ID:</strong> {{ $patient->hospitalRecordId }}<br>
                    <strong>Case No:</strong> {{ $patient->caseNo }}<br>
                    <strong>File No:</strong> {{ $patient->fileNo }}<br>
                    <strong>Date of Birth:</strong> {{ $patient->dateOfBirth }}<br>
                    <strong>Zip Password:</strong> {{ $decryptedPassword }}
                </p>

                <hr class="my-4">

                <div class="form-group">
                    <label class="block mb-2">Drag and Drop Files Here</label>

                    <form action="{{ route('files.store') }}" method="POST" enctype="multipart/form-data"
                        class="dropzone" id="myDragAndDropUploader">
                        @csrf
                        <input type="hidden" name="hospitalRecordId" id="hospitalRecordId"
                            value="{{ $patient->hospitalRecordId }}">
                    </form>

                    <p id="message" class="mt-2 text-sm"></p>
                </div>
            </div>
        </div>

        <hr class="my-8">

        <div class="card bg-white rounded-lg shadow-lg mb-8">
            <div class="card-body p-6">
                <form action="{{ route('archives.store') }}" method="POST">
                    @csrf
                    <div class="flex justify-between mb-2 items-center">
                        <h5 class="text-xl font-bold">Patient Records</h5>
                        <button type="submit"
                            class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
                            Zip
                        </button>
                    </div>
                    <table class="min-w-full divide-y divide-gray-300">
                        <thead class="bg-gray-50">
                            <tr>
                                <th
                                    class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    Select</th>
                                <th
                                    class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    Date Uploaded</th>
                                <th
                                    class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    File</th>
                            </tr>
                        </thead>
                        <tbody class="align-middle">
                            @foreach ($files as $file)
                                <tr>
                                    <td class="px-4 py-2"><input type="checkbox" name="files[]"
                                            value="{{ $file->id }}"></td>
                                    <td class="px-4 py-2">
                                        {{ $file->created_at->format('F j, Y, h:i:s a') }}
                                    </td>
                                    <td class="px-4 py-2">{{ $file->fileName }}</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </form>
            </div>
        </div>

        <div class="card bg-white rounded-lg shadow-lg mb-8">
            <div class="card-body p-6">
                <h5 class="text-xl font-bold mb-4">Zip Files</h5>
                <div class="table-responsive">
                    <table class="min-w-full divide-y divide-gray-300">
                        <thead class="bg-gray-50">
                            <tr>
                                <th
                                    class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    Zip</th>
                                <th
                                    class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    Date Created</th>
                                <th
                                    class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    Date Updated</th>
                                <th
                                    class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($zipfile as $zip)
                                <tr>
                                    <td class="px-4 py-2">{{ $zip->hospitalRecordId }}</td>
                                    <td class="px-4 py-2">{{ $zip->created_at->format('F j, Y, h:i:s a') }}</td>
                                    <td class="px-4 py-2">{{ $zip->updated_at->format('F j, Y, h:i:s a') }}</td>
                                    <td class="px-4 py-2">
                                        <div class="btn-group" role="group" aria-label="Zip Actions">
                                            <a href="{{ route('zip', $zip->id) }}"
                                                class="download-link bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded mr-2">Download</a>
                                            <a href="{{ route('store.zip', $zip->id) }}"
                                                class="bg-gray-500 hover:bg-gray-700 text-white font-bold py-2 px-4 rounded">Archive</a>
                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <x-slot name="scripts">
        <script>
            var maxFilesizeVal = 12; // MB
            var maxFilesVal = 5;

            Dropzone.options.myDragAndDropUploader = {
                paramName: "file", // The name that will be used to transfer the file
                maxFilesize: maxFilesizeVal, // MB
                maxFiles: maxFilesVal,
                acceptedFiles: ".jpeg,.jpg,.png,.webp,.csv,.txt,.xlsx,.xls,.ppt,.pptx,.doc,.docx,.pdf",
                addRemoveLinks: false,
                timeout: 60000,
                dictDefaultMessage: "Drop your files here or click to upload",
                dictFallbackMessage: "Your browser doesn't support drag and drop file uploads.",
                dictFileTooBig: "File is too big. Max filesize: " + maxFilesizeVal + "MB.",
                dictInvalidFileType: "Invalid file type. Only JPG, JPEG, PNG, and GIF files are allowed.",
                dictMaxFilesExceeded: "You can only upload up to " + maxFilesVal + " files.",
                maxfilesexceeded: function(file) {
                    this.removeFile(file);
                },
                sending: function(file, xhr, formData) {
                    document.getElementById('message').innerText = 'File Uploading...';
                    // Append the hospitalRecordId to the form data
                    formData.append('hospitalRecordId', document.getElementById('hospitalRecordId').value);
                },
                success: function(file, response) {
                    document.getElementById('message').innerText = 'File has been uploaded successfully.';
                    // Refresh the page after successful upload
                    setTimeout(function() {
                        location.reload();
                    }, 1000); // Optional delay for user feedback
                },
                error: function(file, response) {
                    document.getElementById('message').innerText = 'Something went wrong: ' + response;
                }
            };

            document.addEventListener('DOMContentLoaded', function() {
                // Target all download links
                const downloadLinks = document.querySelectorAll('.download-link');

                downloadLinks.forEach(link => {
                    link.addEventListener('click', function(e) {
                        // Delay to ensure file is downloaded before refresh
                        setTimeout(() => {
                            window.location.reload();
                        }, 2000); // Adjust the delay time as needed
                    });
                });
            });
        </script>
    </x-slot>
</x-app-layout>
