@extends('layouts.app')
@section('content')
    <h2 class="text-2xl font-semibold mb-2">Isi Data Surat {{ $template->nama_surat }}</h2>

    <div class="flex gap-5">
        <div class="bg-white p-3 rounded shadow w-8/12">
            <form action="{{ route('surat.generate', $template) }}" method="POST">
                @csrf


                @foreach($placeholders as $field)
                    <label for="{{$field}}" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">{{ ucfirst($field) }}</label>
                    {{--                <label>{{ ucfirst($field) }}</label><br>--}}

                    @php
                        $lower = strtolower($field);
                        $type = 'text';
    //                    if (str_contains($lower, 'tanggal')) $type = 'date';
                    @endphp

                    @if(str_contains($lower, 'alamat') || str_contains($lower, 'keterangan'))
                        <textarea name="{{ $field }}" rows="3" cols="30"></textarea>
                    @else
                        <input type="{{$type}}" id="{{$field}}" name="{{$field}}" class="mb-2 shadow-xs bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500 dark:shadow-xs-light"  required />
                        {{--                    <input type="{{ $type }}" name="{{ $field }}">--}}
                    @endif
                @endforeach

                <button id="btn_download" type="submit" name="type" value="docx" class="mt-3 text-white bg-gradient-to-br from-purple-600 to-blue-500 hover:bg-gradient-to-bl focus:ring-4 focus:outline-none focus:ring-blue-300 dark:focus:ring-blue-800 font-medium rounded-lg text-sm px-5 py-2.5 text-center me-2 mb-2">Download Template</button>



                {{--        <button type="submit" name="type" value="docx">Download DOCX</button>--}}
                {{--        <button type="submit" name="type" value="pdf">Download PDF</button>--}}
            </form>
        </div>
    </div>

        <div class="w-3/12 bg-white shadow p-3 fixed right-0 top-0 mt-14 bottom-0 overflow-y-auto">
            <h1 class="text-2xl font-semibold">Helper</h1>

            <div class="py-2 px-4 shadow rounded">

                @foreach($helper as $data)
                    <ul class=" mb-3  text-sm  text-gray-900 bg-white border border-gray-200 rounded-lg dark:bg-gray-700 dark:border-gray-600 dark:text-white">
                        <li class="w-full px-4 py-2 border-b border-gray-200 rounded-t-lg dark:border-gray-600"><span class="font-semibold">Nama</span> : {{$data->nama}}</li>
                        <li class="w-full px-4 py-2 border-b border-gray-200 dark:border-gray-600"><span class="font-semibold">NIP</span> : {{$data->nip}}</li>
                        <li class="w-full px-4 py-2 rounded-b-lg"><span class="font-semibold">Keterangan</span> : {{$data->ket}}</li>
                    </ul>
                @endforeach








            </div>

        </div>


    {{--<script>--}}
    {{--    document.getElementById('btn_download').addEventListener('click', function(e) {--}}
    {{--        setTimeout(()=>{--}}
    {{--            window.location.href="{{route('templates.index')}}";--}}
    {{--        })--}}
    {{--    }, 4000)--}}
    {{--</script>--}}
@endsection
