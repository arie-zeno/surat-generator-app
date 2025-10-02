@extends('layouts.app')
@section('content')

    <div class="flex flex-col bg-white py-4 px-5 shadow rounded">

        <h1 class="text-3xl font-semibold">Daftar Template Surat</h1>

        @if(session('success'))
            <p style="color:green">{{ session('success') }}</p>
        @endif




        <div class="w-full">
            <!-- Start coding here -->
            <div class="bg-white  relative shadow-md sm:rounded-lg overflow-hidden">
                <div class="flex flex-col md:flex-row items-center justify-between space-y-3 md:space-y-0 md:space-x-4 p-4">
                    <div class="w-full ">
                        <form class="flex items-center">
                            <label for="simple-search" class="sr-only">Search</label>
                            <div class="relative w-full">
                                <div class="absolute inset-y-0 left-0 flex items-center pl-3 pointer-events-none">
                                    <svg aria-hidden="true" class="w-5 h-5 text-gray-500 " fill="currentColor" viewbox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                                        <path fill-rule="evenodd" d="M8 4a4 4 0 100 8 4 4 0 000-8zM2 8a6 6 0 1110.89 3.476l4.817 4.817a1 1 0 01-1.414 1.414l-4.816-4.816A6 6 0 012 8z" clip-rule="evenodd" />
                                    </svg>
                                </div>
                                <input type="text" id="simple-search" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full pl-10 p-2      " placeholder="Search" required="">
                            </div>

                        </form>
                    </div>
                    <div class="w-full md:w-auto flex flex-col md:flex-row space-y-2 md:space-y-0 items-stretch md:items-center justify-end md:space-x-3 flex-shrink-0">
                        <button class="relative inline-flex items-center justify-center p-0.5  overflow-hidden text-sm font-medium text-gray-900 rounded-lg group bg-gradient-to-br from-purple-600 to-blue-500 group-hover:from-purple-600 group-hover:to-blue-500 hover:text-white  focus:ring-4 focus:outline-none focus:ring-blue-300 " data-modal-target="modal-tambah" data-modal-toggle="modal-tambah">
                            <span class="relative px-3 py-2 transition-all ease-in duration-75 bg-white  rounded-md group-hover:bg-transparent ">
                            Tambah Template Surat
                            </span>
                        </button>
                    </div>
                        <!-- Main modal -->
                        <div id="modal-tambah" tabindex="-1" aria-hidden="true" class="hidden overflow-y-auto overflow-x-hidden fixed top-0 right-0 left-0 z-50 justify-center items-center w-full md:inset-0 h-[calc(100%-1rem)] max-h-full">
                            <div class="relative p-4 w-full max-w-2xl max-h-full">
                                <!-- Modal content -->
                                <div class="relative bg-white rounded-lg shadow-sm ">
                                    <!-- Modal header -->
                                    <div class="flex items-center justify-between p-4 md:p-5 border-b rounded-t  border-gray-200">
                                        <h3 class="text-xl font-semibold text-gray-900 ">
                                            Tambah Template Surat
                                        </h3>
                                        <button type="button" class="text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm w-8 h-8 ms-auto inline-flex justify-center items-center  " data-modal-hide="modal-tambah">
                                            <svg class="w-3 h-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 14 14">
                                                <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m1 1 6 6m0 0 6 6M7 7l6-6M7 7l-6 6"/>
                                            </svg>
                                            <span class="sr-only">Close modal</span>
                                        </button>
                                    </div>
                                    <!-- Modal body -->
                                    <div class="p-4 md:p-5 space-y-4">
                                        <form action="{{ route('templates.upload') }}" method="POST" enctype="multipart/form-data">
                                            @csrf
                                            <div class="mb-5">
                                                <label for="password" class="block mb-2 text-sm font-medium text-gray-900 ">Nama Template Surat</label>
                                                <input name="nama_surat" type="text" id="password" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5      " required placeholder="Contoh : Surat Balasan"/>
                                            </div>

                                            <label class="block mb-2 text-sm font-medium text-gray-900 " for="user_avatar">Upload file template (.docx)</label>
                                            <input name="template" class="block w-full text-sm text-gray-900 border border-gray-300 rounded-lg cursor-pointer bg-gray-50  focus:outline-none   " aria-describedby="user_avatar_help" id="user_avatar" type="file" required>
                                    </div>
                                    <!-- Modal footer -->
                                    <div class="flex items-center p-4 md:p-5 border-t border-gray-200 rounded-b ">

                                        <button type="submit" class="relative inline-flex items-center justify-center p-0.5 overflow-hidden text-sm font-medium text-gray-900 rounded-lg group bg-gradient-to-br from-purple-600 to-blue-500 group-hover:from-purple-600 group-hover:to-blue-500 hover:text-white  focus:ring-4 focus:outline-none focus:ring-blue-300 ">
                                            <span class="relative px-2 py-1 transition-all ease-in duration-75 bg-white  rounded-md group-hover:bg-transparent ">
                                            Tambah
                                            </span>
                                        </button>
                                        </form>

                                        <button data-modal-hide="modal-tambah" type="button" class="py-1 px-3 ms-3 text-sm font-medium text-gray-900 focus:outline-none bg-white rounded-lg border border-gray-200 hover:bg-gray-100 hover:text-blue-700 focus:z-10 focus:ring-4 focus:ring-gray-100     ">Batal</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                </div>
                <div class="overflow-x-auto">
                    <table class="w-full text-sm text-left text-gray-500 ">
                        <thead class="text-xs text-gray-700 bg-gray-50  ">
                        <tr>
                            <th scope="col" class="px-4 py-3">Nama Template Surat</th>
                            <th scope="col" class="px-4 py-3">File</th>
                            <th scope="col" class="px-4 py-3">
                                <span class="sr-only">Actions</span>
                            </th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($templates as $t)

                            <tr class="border-b">
                                <td class="px-4 py-3">{{ $t->nama_surat }}</td>
                                <td class="px-4 py-3">{{ $t->nama_file }}</td>
                                {{--                                <td class="px-4 py-3">{{ basename($t) }}</td>--}}
                                <td class="px-4 py-3 flex items-center gap-1">
                                    <a href="{{ route('surat.create', $t->id) }}">
                                        <button class="relative inline-flex items-center justify-center p-0.5 overflow-hidden text-sm font-medium text-gray-900 rounded-lg group bg-gradient-to-br from-cyan-500 to-blue-500 group-hover:from-cyan-500 group-hover:to-blue-500 hover:text-white  focus:ring-4 focus:outline-none focus:ring-cyan-200 ">
                                        <span class="relative px-3 py-1 transition-all ease-in duration-75 bg-white  rounded-md group-hover:bg-transparent ">
                                        Gunakan
                                        </span>
                                        </button>
                                    </a>

                                    <a href="{{ asset('storage/templates/' . $t->id) }}" target="_blank">
                                        <button class="relative inline-flex items-center justify-center p-0.5 overflow-hidden text-sm font-medium text-gray-900 rounded-lg group bg-gradient-to-br from-cyan-500 to-blue-500 group-hover:from-cyan-500 group-hover:to-blue-500 hover:text-white  focus:ring-4 focus:outline-none focus:ring-cyan-200 ">
                                        <span class="relative px-3 py-1 transition-all ease-in duration-75 bg-white  rounded-md group-hover:bg-transparent ">
                                        Lihat
                                        </span>
                                        </button>
                                    </a>
                                    <a href="/surat/hapus/{{$t->id}}">
                                        <button class="relative inline-flex items-center justify-center p-0.5  overflow-hidden text-sm font-medium text-gray-900 rounded-lg group bg-gradient-to-br from-red-200 via-red-300 to-yellow-200 group-hover:from-red-200 group-hover:via-red-300 group-hover:to-yellow-200   focus:ring-4 focus:outline-none focus:ring-red-100 ">
<span class="relative px-3 py-1 transition-all ease-in duration-75 bg-white  rounded-md group-hover:bg-transparent ">
Hapus
</span>
                                        </button>
                                    </a>
                                </td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                </div>

            </div>
        </div>
    </div>
@endsection
