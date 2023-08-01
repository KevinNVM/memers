<x-app-layout>

    <style>
        h2 {
            margin: 50px 0;
        }

        section {
            flex-grow: 1;
        }

        .file-drop-area {
            position: relative;
            display: flex;
            align-items: center;
            width: 450px;
            max-width: 100%;
            padding: 25px;
            border: 1px dashed rgba(255, 255, 255, 0.4);
            border-radius: 3px;
            transition: 0.2s;

            &.is-active {
                background-color: rgba(255, 255, 255, 0.05);
            }
        }

        .fake-btn {
            flex-shrink: 0;
            background-color: rgba(255, 255, 255, 0.04);
            border: 1px solid rgba(255, 255, 255, 0.1);
            border-radius: 3px;
            padding: 8px 15px;
            margin-right: 10px;
            font-size: 12px;
            text-transform: uppercase;
        }

        .file-msg {
            font-size: small;
            font-weight: 300;
            line-height: 1.4;
            white-space: nowrap;
            overflow: hidden;
            text-overflow: ellipsis;
        }

        .file-input {
            position: absolute;
            left: 0;
            top: 0;
            height: 100%;
            width: 100%;
            cursor: pointer;
            opacity: 0;

            &:focus {
                outline: none;
            }
        }

        .preview-image {
            width: 100%;
            height: auto;
            object-fit: cover;
            margin-right: 10px;
        }

        .preview-video {
            width: 100%;
            height: auto;
            margin-bottom: 10px;
        }

        .previews-area {
            max-height: 500px;
            overflow-y: auto;
        }
    </style>

    <x-navbar />

    <div class="px-2 max-w-screen-sm mx-auto my-8 dark:text-white">
        <h1 class="text-lg font-semibold ">Create New Meme</h1>

        <x-errors />

        <form action="{{ route('memes.store') }}" method="POST" enctype="multipart/form-data">
            @csrf


            <div class="flex flex-col gap-4">
                <div>
                    <label for="name-with-label" class="dark:text-gray-200">
                        Location
                    </label>
                    <input type="text" id="name-with-label"
                        class=" rounded-lg border-transparent flex-1 appearance-none border border-gray-300 w-full py-2 px-4 bg-white text-gray-700 placeholder-gray-400 shadow-sm text-base focus:outline-none focus:ring-2 focus:ring-purple-600 focus:border-transparent"
                        name="location" placeholder="Location (Optional)" value="{{ old('location') }}" />
                </div>

                <div class="sources images">
                    <div class="previews-area grid grid-cols-2 "></div>
                    <div class="file-drop-area mt-2">
                        <span class="fake-btn">Choose files</span>
                        <span class="file-msg">or drag and drop files here</span>
                        <input class="file-input" type="file" multiple name="sources[]" required>
                    </div>
                </div>


                <div>

                    <label class="dark:text-gray-200" for="name">
                        Caption
                        <textarea
                            class="flex-1 w-full px-4 py-2 text-base text-gray-700 placeholder-gray-400 bg-white border border-gray-300 rounded-lg appearance-none focus:outline-none focus:ring-2 focus:ring-purple-600 focus:border-transparent"
                            id="caption" placeholder="Enter your caption" name="caption" rows="5" cols="40">{{ old('caption') }}</textarea>
                    </label>

                </div>
            </div>


            <button
                class="px-6 py-2 font-medium tracking-wide text-white capitalize transition-colors duration-300 transform bg-blue-600 rounded-lg hover:bg-blue-500 focus:outline-none focus:ring focus:ring-blue-300 focus:ring-opacity-80">
                Submit
            </button>


        </form>

    </div>

    <script>
        var fileInput = document.querySelector('.file-input');
        var droparea = document.querySelector('.file-drop-area');
        var selectedFiles = 0;


        fileInput.addEventListener('dragenter', function() {
            droparea.classList.add('is-active');
        });

        fileInput.addEventListener('dragleave', function() {
            droparea.classList.remove('is-active');
        });

        fileInput.addEventListener('blur', function() {
            droparea.classList.remove('is-active');
        });

        fileInput.addEventListener('drop', function() {
            droparea.classList.remove('is-active');
        });

        fileInput.addEventListener('change', function() {
            var filesCount = this.files.length;
            var textContainer = this.previousElementSibling;

            if (filesCount === 1) {
                var fileName = this.value.split('\\').pop();
                textContainer.textContent = fileName;
            } else {
                textContainer.textContent = filesCount + ' files selected';
            }
        });

        fileInput.addEventListener('change', handleFileSelect);

        function handleFileSelect(event) {
            var files = event.target.files;
            var previewsArea = document.querySelector('.previews-area');
            previewsArea.innerHTML = '';

            // if (selectedFiles >= 5) {
            //     alert('Maximum limit of 5 files reached');
            //     return;
            // }

            for (var i = 0; i < files.length; i++) {
                var file = files[i];
                var fileType = file.type;

                if (fileType.startsWith('image/') || fileType.startsWith('video/')) {
                    var reader = new FileReader();

                    reader.onload = (function(file) {
                        return function(e) {
                            selectedFiles++;

                            if (fileType.startsWith('image/')) {
                                var img = document.createElement('img');
                                img.classList.add('preview-image');
                                img.src = e.target.result;
                                previewsArea.appendChild(img);
                            } else if (fileType.startsWith('video/')) {
                                var video = document.createElement('video');
                                video.classList.add('preview-video');
                                video.src = e.target.result;
                                video.controls = true;
                                previewsArea.appendChild(video);
                            }
                        };
                    })(file);

                    reader.readAsDataURL(file);
                }
            }
        }
    </script>

</x-app-layout>
