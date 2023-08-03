<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Welcome</title>
    @livewireStyles

    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css">
    <style>
        .splide {
            width: 100%;
            height: 100%;
        }
    </style>
    <script defer src="https://cdn.jsdelivr.net/npm/@alpinejs/intersect@3.x.x/dist/cdn.min.js"></script>
    <script src="https://polyfill.io/v3/polyfill.min.js?features=IntersectionObserver"></script>

    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sharer.js@latest/sharer.min.js"></script>
    <script>
        window.addEventListener('DOMContentLoaded', () => {

            var elms = document.getElementsByClassName('splide');
            var splides = [];

            var splideConfig = {
                lazyLoad: true,
                autoHeight: true,
                rewind: true,
                rewindByDrag: true,
            }

            // Create and mount Splide instances, and store them in the array
            for (var i = 0; i < elms.length; i++) {
                var splide = new Splide(elms[i], splideConfig).mount();
                splides.push(splide);
            }

            function loadSlide() {
                // Later, when you want to destroy all instances:
                for (var i = 0; i < splides.length; i++) {
                    splides[i].destroy();
                }

                // And remount them again:
                for (var i = 0; i < elms.length; i++) {
                    var splide = new Splide(elms[i], splideConfig).mount();
                    splides[i] = splide; // Replace the destroyed instance with the new one in the array
                }
            }


            /**
             * @argument imageUrl
             * @return [R, G, B]
             **/
            function getAverageColorFromImage(imageUrl, callback) {
                const canvas = document.createElement('canvas');
                const context = canvas.getContext('2d');
                const image = new Image();

                image.src = imageUrl;
                image.onload = () => {
                    const aspectRatio = image.width / image.height;

                    // New size for the canvas
                    const newWidth = 100;
                    const newHeight = newWidth / aspectRatio;

                    canvas.width = newWidth;
                    canvas.height = newHeight;

                    context.drawImage(image, 0, 0, newWidth, newHeight);

                    const imageData = context.getImageData(0, 0, newWidth, newHeight);
                    const data = imageData.data;
                    const colors = [];
                    for (let i = 0; i < data.length; i += 4) {
                        const r = data[i];
                        const g = data[i + 1];
                        const b = data[i + 2];
                        colors.push({
                            r,
                            g,
                            b
                        });
                    }

                    let totalR = 0;
                    let totalG = 0;
                    let totalB = 0;
                    for (const color of colors) {
                        totalR += color.r;
                        totalG += color.g;
                        totalB += color.b;
                    }
                    const avgR = Math.round(totalR / colors.length);
                    const avgG = Math.round(totalG / colors.length);
                    const avgB = Math.round(totalB / colors.length);

                    const averageColor = [avgR, avgG, avgB];
                    callback(averageColor);
                };
            }


            function refreshSlide() {
                loadSlide();
                document.querySelectorAll('.splide__slide').forEach(slide => {
                    const imageUrl = slide.querySelector('object')?.getAttribute('data') || slide
                        .querySelector('img')?.getAttribute('src');
                    if (!imageUrl) return;
                    getAverageColorFromImage(imageUrl, (averageColor) => {
                        slide.style.backgroundColor = `rgb(${averageColor.join()}, 0.8)`
                        slide.style.backdropFilter = 'blur(8px)'
                    });
                });
            }

            refreshSlide()
            window.refreshSlide = refreshSlide


            Alpine.store('player', {
                playing: null,
                play(el) {
                    if (this.playing) {
                        this.playing.pause();
                    }
                    this.playing = el;
                    this.playing.play();
                }
            });




        })
    </script>
    <script src="/deps/Toast.min.js"></script>
    <link rel="stylesheet" href="/deps/Toast.min.css">
</head>

<body class="min-h-screen dark:bg-gray-900 antialiased font-sans">


    <div>
        {{ $slot }}
    </div>

    @livewireScripts



</body>

</html>
