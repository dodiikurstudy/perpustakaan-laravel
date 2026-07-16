<!DOCTYPE html>
<html>

<head>

    <title>{{ $book->judul }}</title>

    <meta name="csrf-token" content="{{ csrf_token() }}">

    @vite([
        'resources/css/app.css',
        'resources/js/ebook.js'
    ])

</head>


<body>

<div class="min-h-screen bg-gray-100 flex justify-center items-start p-10">

    <div class="bg-white shadow-lg rounded-xl p-6">


        <h1 class="text-xl font-bold mb-5 text-center">
            {{ $book->judul }}
        </h1>



        <div 
            id="pdf-container"
            class="flex justify-center"
        >

            <canvas

                id="pdf-canvas"

                data-pdf="{{ route('ebooks.file', ['book' => $book->id]) }}"

                data-progress="{{ route('ebooks.progress', ['book' => $book->id]) }}"

                data-max-pages="{{ $maxPages }}"

                data-last-page="{{ $lastPage ?? 1 }}"

                data-name="{{ $watermark['name'] }}"

                data-npm="{{ $watermark['npm'] }}"

                class="border"

            ></canvas>


        </div>




        <div class="flex justify-center items-center gap-5 mt-5">


            <button

                id="prev-page"

                class="px-4 py-2 bg-gray-800 text-white rounded-lg"

            >

                ◀ Sebelumnya

            </button>




            <span

                id="page-info"

                class="font-bold"

            >

                Halaman 1

            </span>




            <button

                id="next-page"

                class="px-4 py-2 bg-violet-600 text-white rounded-lg"

            >

                Berikutnya ▶

            </button>


        </div>


    </div>


</div>



</body>

</html>