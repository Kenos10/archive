<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Dashboard') }}
        </h2>
    </x-slot>

    <div class="container mx-auto mt-8">
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">

            <!-- File Management -->
            <div class="bg-gradient-to-r from-gray-200 to-gray-300 shadow-lg rounded-lg p-6">
                <h3 class="text-lg font-semibold mb-4">File Management</h3>
                <p class="py-3"><a href="{{ route('files.index') }}" class="block text-blue-700 px-4 text-lg">Uploaded Files:  {{ $fileCount }} </a></p> <!-- count file uploade in db-->
                <p><a href="{{ route('archives.index') }}" class="block text-blue-700 px-4">Zip Files: {{ $zipCount }}</a></p>
            </div>


            <!-- Patient Management-->
            <div class="bg-gradient-to-r from-gray-200 to-gray-300 shadow-lg rounded-lg p-6">
                <h3 class="text-lg font-semibold mb-3">Patient Management</h3>
                <p class="py-3"> <a href="{{ route('patients.index') }}" class="block text-blue-700 px-4">Patient Records: {{ $patientCount }}</a></p>
            </div>



            <!-- Customization and Settings -->
            <div class="bg-gradient-to-r from-gray-200 to-gray-300 shadow-lg rounded-lg p-6">
                <h3 class="text-lg font-semibold mb-4">Customize Settings</h3>
                <a href="{{ route('setting') }}" class="block bg-indigo-600 text-white py-2 px-4 rounded">Go to Settings</a>
            </div>
        </div>
    </div>
</x-app-layout>
