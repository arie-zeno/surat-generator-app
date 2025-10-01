@extends('layouts.app')
@section('content')

    <div class="flex flex-col bg-white py-4 px-5 shadow rounded">

        <h1 class="text-3xl font-semibold">Data Helper</h1>

        @if(session('success'))
            <p style="color:green">{{ session('success') }}</p>
        @endif




        <div class="w-full">
            <!-- Start coding here -->
            <div class="bg-whitedark:bg-gray-800 relative shadow-md sm:rounded-lg overflow-hidden">
                <div class="flex flex-col items-center justify-between space-y-3 md:space-y-0 md:space-x-4 p-4 ">
                    <div class="w-full flex flex-col md:flex-row space-y-2 md:space-y-0 items-stretch md:items-center justify-end md:space-x-3 flex-shrink-0">
                        <button class="relative inline-flex items-center justify-center p-0.5  overflow-hidden text-sm font-medium text-gray-900 rounded-lg group bg-gradient-to-br from-purple-600 to-blue-500 group-hover:from-purple-600 group-hover:to-blue-500 hover:text-white dark:text-white focus:ring-4 focus:outline-none focus:ring-blue-300 dark:focus:ring-blue-800" data-modal-target="modal-tambah" data-modal-toggle="modal-tambah">
                            <span class="relative px-3 py-2 transition-all ease-in duration-75 bg-white dark:bg-gray-900 rounded-md group-hover:bg-transparent group-hover:dark:bg-transparent">
                            Tambah Data
                            </span>
                        </button>
                        <!-- Main modal -->
                        <div id="modal-tambah" tabindex="-1" aria-hidden="true" class="hidden overflow-y-auto overflow-x-hidden fixed top-0 right-0 left-0 z-50 justify-center items-center w-full md:inset-0 h-[calc(100%-1rem)] max-h-full">
                            <div class="relative p-4 w-full max-w-2xl max-h-full">
                                <!-- Modal content -->
                                <div class="relative bg-white rounded-lg shadow-sm dark:bg-gray-700">
                                    <!-- Modal header -->
                                    <div class="flex items-center justify-between p-4 md:p-5 border-b rounded-t dark:border-gray-600 border-gray-200">
                                        <h3 class="text-xl font-semibold text-gray-900 dark:text-white">
                                            Tambah Data
                                        </h3>
                                        <button type="button" class="text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm w-8 h-8 ms-auto inline-flex justify-center items-center dark:hover:bg-gray-600 dark:hover:text-white" data-modal-hide="modal-tambah">
                                            <svg class="w-3 h-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 14 14">
                                                <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m1 1 6 6m0 0 6 6M7 7l6-6M7 7l-6 6"/>
                                            </svg>
                                            <span class="sr-only">Close modal</span>
                                        </button>
                                    </div>
                                    <!-- Modal body -->
                                    <div class="p-4 md:p-5 space-y-4">
                                        <form action="{{ route('helper.upload') }}" method="POST" >
                                            @csrf
                                            <div class="mb-5">
                                                <label for="password" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Nama</label>
                                                <input name="nama" type="text" id="password" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" required placeholder="Contoh : Thari Maulida"/>
                                            </div>

                                            <div class="mb-5">
                                                <label for="nip" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">NIP</label>
                                                <input name="nip" type="text" id="nip" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" required placeholder="Contoh : 2378213 8237 82378 88"/>
                                            </div>

                                            <div class="mb-5">
                                                <label for="ket" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Keterangan</label>
                                                <input name="ket" type="text" id="ket" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" required placeholder="Contoh : Kelompok pokja 2"/>
                                            </div>

                                            <!-- Modal footer -->
                                            <div class="flex items-center p-4 md:p-5 border-t border-gray-200 rounded-b dark:border-gray-600">

                                                <button type="submit" class="relative inline-flex items-center justify-center p-0.5 overflow-hidden text-sm font-medium text-gray-900 rounded-lg group bg-gradient-to-br from-purple-600 to-blue-500 group-hover:from-purple-600 group-hover:to-blue-500 hover:text-white dark:text-white focus:ring-4 focus:outline-none focus:ring-blue-300 dark:focus:ring-blue-800">
                                            <span class="relative px-2 py-1 transition-all ease-in duration-75 bg-white dark:bg-gray-900 rounded-md group-hover:bg-transparent group-hover:dark:bg-transparent">
                                            Tambah
                                            </span>
                                                </button>
                                        </form>

                                        <button data-modal-hide="modal-tambah" type="button" class="py-1 px-3 ms-3 text-sm font-medium text-gray-900 focus:outline-none bg-white rounded-lg border border-gray-200 hover:bg-gray-100 hover:text-blue-700 focus:z-10 focus:ring-4 focus:ring-gray-100 dark:focus:ring-gray-700 dark:bg-gray-800 dark:text-gray-400 dark:border-gray-600 dark:hover:text-white dark:hover:bg-gray-700">Batal</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                </div>
                <div class="overflow-x-auto w-full">
                    <table class="w-full text-sm text-left text-gray-500 dark:text-gray-400">
                        <thead class="text-xs text-gray-700 bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
                        <tr>
                            <th scope="col" class="px-4 py-3">Nama</th>
                            <th scope="col" class="px-4 py-3">NIP</th>
                            <th scope="col" class="px-4 py-3">Keterangan</th>
                            <th scope="col" class="px-4 py-3">
                                <span class="sr-only">Actions</span>
                            </th>
                        </tr>
                        </thead>
                        <tbody>

                        @foreach($data as $t)

                            <tr class="border-b dark:border-gray-700">
                                <td class="px-4 py-3">{{ $t->nama }}</td>
                                <td class="px-4 py-3">{{ $t->nip }}</td>
                                <td class="px-4 py-3">{{ $t->ket }}</td>
                                <td class="px-4 py-3 flex items-center gap-1">

                                    <a href="#">
                                        <button class="relative inline-flex items-center justify-center p-0.5 overflow-hidden text-sm font-medium text-gray-900 rounded-lg group bg-gradient-to-br from-cyan-500 to-blue-500 group-hover:from-cyan-500 group-hover:to-blue-500 hover:text-white dark:text-white focus:ring-4 focus:outline-none focus:ring-cyan-200 dark:focus:ring-cyan-800">
                                            <span class="relative px-3 py-1 transition-all ease-in duration-75 bg-white dark:bg-gray-900 rounded-md group-hover:bg-transparent group-hover:dark:bg-transparent">
                                            Edit
                                            </span>
                                        </button>
                                    </a>
                                    <a href="{{ route('helper.remove', $t->id) }}">
                                        <button class="relative inline-flex items-center justify-center p-0.5  overflow-hidden text-sm font-medium text-gray-900 rounded-lg group bg-gradient-to-br from-red-200 via-red-300 to-yellow-200 group-hover:from-red-200 group-hover:via-red-300 group-hover:to-yellow-200 dark:text-white dark:hover:text-gray-900 focus:ring-4 focus:outline-none focus:ring-red-100 dark:focus:ring-red-400">
                                            <span class="relative px-3 py-1 transition-all ease-in duration-75 bg-white dark:bg-gray-900 rounded-md group-hover:bg-transparent group-hover:dark:bg-transparent">
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
