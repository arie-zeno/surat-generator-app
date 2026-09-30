@extends('layouts.app')
@section('content')
    <h2 class="text-2xl font-semibold mb-2">Isi Data Surat {{ $template->nama_surat }}</h2>

    <div class="flex gap-5">
        <div class="bg-white p-3 rounded shadow w-8/12">
            <form action="{{ route('surat.generate', $template) }}" method="POST">
                @csrf


                @foreach($placeholders as $field)
                    <label for="{{$field}}" class="block mb-2 text-sm font-medium text-gray-900 ">{{ ucfirst($field) }}</label>
                    {{--                <label>{{ ucfirst($field) }}</label><br>--}}

                    @php
                        $lower = strtolower($field);
                        $type = 'text';
    //                    if (str_contains($lower, 'tanggal')) $type = 'date';
                    @endphp

                    @if(str_contains($lower, 'alamat') || str_contains($lower, 'keterangan'))
                        <textarea name="{{ $field }}" rows="3" cols="30"></textarea>
                    @else
                        <input type="{{$type}}" id="{{$field}}" name="{{$field}}" class="mb-2 shadow-xs bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5"  required />
                        {{--                    <input type="{{ $type }}" name="{{ $field }}">--}}
                    @endif
                @endforeach

                <button id="btn_download" type="submit" name="type" value="docx" class="mt-3 text-white bg-gradient-to-br from-purple-600 to-blue-500 hover:bg-gradient-to-bl focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center me-2 mb-2">Download Template</button>



                {{--        <button type="submit" name="type" value="docx">Download DOCX</button>--}}
                {{--        <button type="submit" name="type" value="pdf">Download PDF</button>--}}
            </form>
        </div>
    </div>

        <div class="w-3/12 bg-white shadow p-3 fixed right-0 top-0 mt-14 bottom-0 overflow-y-auto">
            <h1 class="text-2xl font-semibold">Helper</h1>

            <div class="py-2 px-4 shadow rounded">

                <div class="relative mb-3">
                    <div class="absolute inset-y-0 start-0 flex items-center ps-3 pointer-events-none">
                        <svg class="w-4 h-4 text-gray-500" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 20 20" stroke-width="1.5" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" d="m19.5 19.5-4.5-4.5m2.25-4.5a8.25 8.25 0 1 1-16.5 0 8.25 8.25 0 0 1 16.5 0Z" />
                        </svg>
                    </div>
                    <label for="cari-helper" class="sr-only">Cari helper</label>
                    <input type="search" id="cari-helper" class="ps-10 p-2.5 w-full text-sm text-gray-900 bg-gray-50 border border-gray-300 rounded-lg focus:ring-blue-500 focus:border-blue-500" placeholder="Cari nama, NIP, keterangan..." />
                </div>

                <p id="helper-paste-hint" class="text-xs text-gray-500 mb-3">
                    Pilih kolom surat yang mau diisi, lalu klik ikon salin di baris helper.
                </p>

                <p id="helper-empty" class="hidden mb-3 text-sm text-gray-500">
                    Tidak ada helper yang cocok.
                </p>

                @foreach($helper as $data)
                    <ul class=" mb-3  text-sm  text-gray-900 bg-white border border-gray-200 rounded-lg   " data-search="{{ $data->nama }} {{ $data->nip }} {{ $data->ket }}">
                        <li class="w-full px-4 py-2 border-b border-gray-200 rounded-t-lg flex items-center justify-between gap-2">
                            <span class="min-w-0 break-words"><span class="font-semibold">Nama</span> : {{$data->nama}}</span>
                            <button type="button" class="shrink-0 p-1.5 rounded-lg text-gray-500 hover:text-blue-600 hover:bg-blue-50 focus:outline-none focus:ring-2 focus:ring-blue-500" data-paste-value="{{ $data->nama }}" title="Salin ke kolom yang dipilih">
                                <svg class="w-4 h-4" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M15.666 3.888A2.25 2.25 0 0013.5 2.25h-3c-1.03 0-1.9.693-2.166 1.638m7.332 0c.055.194.084.4.084.612v0a.75.75 0 01-.75.75H9a.75.75 0 01-.75.75v0c0-.212.03-.418.084-.612m7.332 0c.646.049 1.288.11 1.927.184 1.1.128 1.907 1.077 1.907 2.185V19.5a2.25 2.25 0 01-2.25 2.25H6.75A2.25 2.25 0 014.5 19.5V6.257c0-1.108.806-2.057 1.907-2.185a48.208 48.208 0 011.927-.184" />
                                </svg>
                            </button>
                        </li>
                        <li class="w-full px-4 py-2 border-b border-gray-200 flex items-center justify-between gap-2">
                            <span class="min-w-0 break-words"><span class="font-semibold">NIP</span> : {{$data->nip}}</span>
                            <button type="button" class="shrink-0 p-1.5 rounded-lg text-gray-500 hover:text-blue-600 hover:bg-blue-50 focus:outline-none focus:ring-2 focus:ring-blue-500" data-paste-value="{{ $data->nip }}" title="Salin ke kolom yang dipilih">
                                <svg class="w-4 h-4" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M15.666 3.888A2.25 2.25 0 0013.5 2.25h-3c-1.03 0-1.9.693-2.166 1.638m7.332 0c.055.194.084.4.084.612v0a.75.75 0 01-.75.75H9a.75.75 0 01-.75.75v0c0-.212.03-.418.084-.612m7.332 0c.646.049 1.288.11 1.927.184 1.1.128 1.907 1.077 1.907 2.185V19.5a2.25 2.25 0 01-2.25 2.25H6.75A2.25 2.25 0 014.5 19.5V6.257c0-1.108.806-2.057 1.907-2.185a48.208 48.208 0 011.927-.184" />
                                </svg>
                            </button>
                        </li>
                        <li class="w-full px-4 py-2 rounded-b-lg flex items-center justify-between gap-2">
                            <span class="min-w-0 break-words"><span class="font-semibold">Keterangan</span> : {{$data->ket}}</span>
                            <button type="button" class="shrink-0 p-1.5 rounded-lg text-gray-500 hover:text-blue-600 hover:bg-blue-50 focus:outline-none focus:ring-2 focus:ring-blue-500" data-paste-value="{{ $data->ket }}" title="Salin ke kolom yang dipilih">
                                <svg class="w-4 h-4" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M15.666 3.888A2.25 2.25 0 0013.5 2.25h-3c-1.03 0-1.9.693-2.166 1.638m7.332 0c.055.194.084.4.084.612v0a.75.75 0 01-.75.75H9a.75.75 0 01-.75.75v0c0-.212.03-.418.084-.612m7.332 0c.646.049 1.288.11 1.927.184 1.1.128 1.907 1.077 1.907 2.185V19.5a2.25 2.25 0 01-2.25 2.25H6.75A2.25 2.25 0 014.5 19.5V6.257c0-1.108.806-2.057 1.907-2.185a48.208 48.208 0 011.927-.184" />
                                </svg>
                            </button>
                        </li>
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
<script>
        (function () {
            const form = document.querySelector('form[action*="/surat/generate/"]');
            if (!form) return;

            const hint = document.getElementById('helper-paste-hint');
            const highlight = ['ring-2', 'ring-blue-500', 'border-blue-500'];
            let target = null;

            function mark(el) {
                if (target && target !== el) target.classList.remove(...highlight);
                target = el;
                el.classList.add(...highlight);
            }

            form.addEventListener('focusin', function (e) {
                if (!e.target.matches('input, textarea')) return;
                mark(e.target);
                if (hint) hint.classList.add('hidden');
            });

            form.addEventListener('input', function (e) {
                if (e.target.matches('input, textarea')) mark(e.target);
            });

            document.querySelectorAll('[data-paste-value]').forEach(function (btn) {
                btn.addEventListener('click', function () {
                    if (!target) {
                        if (hint) hint.classList.remove('hidden');
                        return;
                    }
                    target.value = btn.dataset.pasteValue;
                    target.dispatchEvent(new Event('input', { bubbles: true }));
                    target.focus();
                });
            });

            const cari = document.getElementById('cari-helper');
            const cards = [...document.querySelectorAll('[data-search]')];
            const kosong = document.getElementById('helper-empty');

            if (cari && cards.length) {
                const terapkan = function () {
                    const q = cari.value.trim().toLowerCase();
                    let tampil = 0;

                    cards.forEach(function (card) {
                        const cocok = q === '' || card.dataset.search.toLowerCase().includes(q);
                        card.classList.toggle('hidden', !cocok);
                        if (cocok) tampil++;
                    });

                    if (kosong) kosong.classList.toggle('hidden', tampil !== 0);
                };

                cari.addEventListener('input', terapkan);
                cari.addEventListener('search', terapkan);
            }
        })();
    </script>
@endsection
