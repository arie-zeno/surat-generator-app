<div class="container mx-auto">


    <div class="relative overflow-x-auto shadow-md sm:rounded-lg pt-5">
        <h1 class="font-semibold text-3xl">Table Users</h1>
        <table class="w-full text-sm text-left rtl:text-right text-gray-500 dark:text-gray-400">
            <thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
            <tr>
                <th scope="col" class="px-6 py-3">
                    id
                </th>
                <th scope="col" class="px-6 py-3">
                    Name
                </th>
                <th scope="col" class="px-6 py-3">
                    Action
                </th>
            </tr>
            </thead>
            <tbody>
            @foreach($users as $user)

                <tr class="bg-white border-b dark:bg-gray-800 dark:border-gray-700 border-gray-200 hover:bg-gray-50 dark:hover:bg-gray-600">
                    <th scope="row" class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap dark:text-white">
                        {{$user->id}}
                    </th>
                    <td class="px-6 py-4">
                        {{$user->name}}
                    </td>
                    <td class="px-6 py-4 text-right">


                        <!-- Modal toggle -->
                        <button data-modal-target="modal-{{$user->id}}" data-modal-toggle="modal-{{$user->id}}" class="block text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800" type="button">
                            Test Modal
                        </button>

                        <!-- Main modal -->
                        <div id="modal-{{$user->id}}" tabindex="-1" aria-hidden="true" class="hidden overflow-y-auto overflow-x-hidden fixed top-0 right-0 left-0 z-50 justify-center items-center w-full md:inset-0 h-[calc(100%-1rem)] max-h-full">
                            <div class="relative p-4 w-full max-w-2xl max-h-full">
                                <!-- Modal content -->
                                <div class="relative bg-white rounded-lg shadow-sm dark:bg-gray-700">
                                    <!-- Modal header -->
                                    <div class="flex items-center justify-between p-4 md:p-5 border-b rounded-t dark:border-gray-600 border-gray-200">
                                        <h3 class="text-xl font-semibold text-gray-900 dark:text-white">
                                            Terms of Service
                                        </h3>
                                        <button type="button" class="text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm w-8 h-8 ms-auto inline-flex justify-center items-center dark:hover:bg-gray-600 dark:hover:text-white" data-modal-hide="modal-{{$user->id}}">
                                            <svg class="w-3 h-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 14 14">
                                                <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m1 1 6 6m0 0 6 6M7 7l6-6M7 7l-6 6"/>
                                            </svg>
                                            <span class="sr-only">Close modal</span>
                                        </button>
                                    </div>
                                    <!-- Modal body -->
                                    <div class="p-4 md:p-5 space-y-4">
                                        <p class="text-base leading-relaxed text-gray-500 dark:text-gray-400">
                                            {{$user->name}}
                                        </p>
                                    </div>
                                    <!-- Modal footer -->
                                    <div class="flex items-center p-4 md:p-5 border-t border-gray-200 rounded-b dark:border-gray-600">
                                        <button data-modal-hide="modal-{{$user->id}}" type="button" class="text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800">I accept</button>
                                        <button data-modal-hide="modal-{{$user->id}}" type="button" class="py-2.5 px-5 ms-3 text-sm font-medium text-gray-900 focus:outline-none bg-white rounded-lg border border-gray-200 hover:bg-gray-100 hover:text-blue-700 focus:z-10 focus:ring-4 focus:ring-gray-100 dark:focus:ring-gray-700 dark:bg-gray-800 dark:text-gray-400 dark:border-gray-600 dark:hover:text-white dark:hover:bg-gray-700">Decline</button>
                                    </div>
                                </div>
                            </div>
                        </div>

                    </td>
                </tr>
            @endforeach

            </tbody>
        </table>
    </div>

    <div>
        {{ $users->links() }}
    </div>
</div>
