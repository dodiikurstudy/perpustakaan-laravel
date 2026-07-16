import * as pdfjsLib from 'pdfjs-dist/build/pdf.mjs';
import workerSrc from 'pdfjs-dist/build/pdf.worker.min.mjs?url';

pdfjsLib.GlobalWorkerOptions.workerSrc = workerSrc;


let pdfDoc = null;
let currentPage = 1;
let progressUrl = null;
let lastPage = 1;


document.addEventListener('DOMContentLoaded', () => {


    const canvas = document.getElementById('pdf-canvas');


    if (!canvas) {
        return;
    }


    const pdfUrl = canvas.getAttribute('data-pdf');

    const maxPages = canvas.dataset.maxPages
        ? parseInt(canvas.dataset.maxPages)
        : null;

    progressUrl = canvas.dataset.progress;

    lastPage = parseInt(canvas.dataset.lastPage) || 1;

    const readerName = canvas.dataset.name;
    const readerNpm = canvas.dataset.npm;

    console.log('PDF URL:', pdfUrl);
    console.log('Batas halaman:', maxPages);
    console.log('Progress URL:', progressUrl);
    console.log('Halaman terakhir:', lastPage);
    console.log('Nama Pembaca:', readerName);
    console.log('NPM:', readerNpm);



    const context = canvas.getContext('2d');


    const pageInfo = document.getElementById('page-info');

    const prevButton = document.getElementById('prev-page');

    const nextButton = document.getElementById('next-page');



    function saveProgress(page)
    {

        if (!progressUrl) {
            return;
        }


        fetch(progressUrl, {

            method: 'POST',

            headers: {

                'Content-Type': 'application/json',

                'X-CSRF-TOKEN':
                    document
                    .querySelector('meta[name="csrf-token"]')
                    .getAttribute('content')

            },


            body: JSON.stringify({

                page: page

            })

        })


        .then(response => response.json())


        .then(data => {

            console.log(
                'Progress tersimpan:',
                page
            );

        })


        .catch(error => {

            console.error(
                'Progress gagal:',
                error
            );

        });


    }

    
    function drawWatermark(context, canvas)
    {
        context.save();

        context.globalAlpha = 0.12;

        context.fillStyle = "#555";

        context.font = "bold 32px Arial";

        context.textAlign = "center";
        context.textBaseline = "middle";

        const text = [
            "PERPUS DK",
            readerName,  
            
        ].join(" | ");


        context.translate(
            canvas.width / 2,
            canvas.height / 2
        );

        context.rotate(-Math.PI / 4);


        const gapX = 350;
        const gapY = 180;


        for(
            let x = -canvas.width;
            x < canvas.width;
            x += gapX
        )
        {
            for(
                let y = -canvas.height;
                y < canvas.height;
                y += gapY
            )
            {

                context.fillText(
                    text,
                    x,
                    y
                );

            }
        }


        context.restore();
    }


    function renderPage(pageNumber)
    {


        pdfDoc.getPage(pageNumber).then(page => {


            const viewport = page.getViewport({
                scale: 1.5
            });



            canvas.width = viewport.width;

            canvas.height = viewport.height;



            page.render({
                canvasContext: context,
                viewport: viewport
            }).promise.then(() => {

                // Gambar watermark setelah PDF selesai dirender
                drawWatermark(context, canvas);

                // Simpan progress membaca
                saveProgress(pageNumber);

            });



            if (maxPages) {


                pageInfo.textContent =
                    `Halaman ${pageNumber} dari ${maxPages} (Preview)`;


            } else {


                pageInfo.textContent =
                    `Halaman ${pageNumber} dari ${pdfDoc.numPages}`;


            }



            saveProgress(pageNumber);


        });


    }





    pdfjsLib.getDocument({

        url: pdfUrl

    }).promise.then(pdf => {


        pdfDoc = pdf;



        console.log(
            'PDF berhasil dibuka:',
            pdf.numPages,
            'halaman'
        );



        currentPage = lastPage;

        renderPage(currentPage);



    })


    .catch(error => {


        console.error(
            'PDF gagal:',
            error
        );


    });





    prevButton.addEventListener('click', () => {



        if (currentPage <= 1) {
            return;
        }



        currentPage--;


        renderPage(currentPage);



    });







    nextButton.addEventListener('click', () => {



        if (!pdfDoc) {
            return;
        }



        if (currentPage >= pdfDoc.numPages) {
            return;
        }



        if (maxPages && currentPage >= maxPages) {


            alert(
                'Batas membaca ebook Anda sudah tercapai, silahkan upgrade akun Anda untuk membaca lebih banyak halaman.'
            );


            return;

        }




        currentPage++;



        renderPage(currentPage);



    });

// ===========================
// Ebook Protection
// ===========================


// Disable klik kanan
document.addEventListener(
    "contextmenu",
    function(e)
    {
        e.preventDefault();
    }
);


// Disable drag
document.addEventListener(
    "dragstart",
    function(e)
    {
        e.preventDefault();
    }
);


// Disable copy
document.addEventListener(
    "copy",
    function(e)
    {
        e.preventDefault();
    }
);


// Disable shortcut
document.addEventListener(
    "keydown",
    function(e)
    {

        if(
            e.ctrlKey &&
            (
                e.key === "s" ||
                e.key === "p" ||
                e.key === "u"
            )
        )
        {
            e.preventDefault();
        }

    }
);




// ===========================
// DevTools Protection
// ===========================


const pdfCanvas = document.getElementById("pdf-canvas");


let devtoolsOpen = false;



function checkDevTools()
{

    const threshold = 160;


    const widthDiff =
        window.outerWidth - window.innerWidth;


    const heightDiff =
        window.outerHeight - window.innerHeight;



    if(
        widthDiff > threshold ||
        heightDiff > threshold
    )
    {
        devtoolsOpen = true;
    }
    else
    {
        devtoolsOpen = false;
    }



    if(devtoolsOpen)
    {
        pdfCanvas.classList.add(
            "pdf-protected-blur"
        );
    }
    else
    {
        pdfCanvas.classList.remove(
            "pdf-protected-blur"
        );
    }

}



setInterval(
    checkDevTools,
    500
);

});