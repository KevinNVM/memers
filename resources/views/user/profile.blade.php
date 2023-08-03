<x-app-layout>

    <style>
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
    </style>

    <x-navbar />


    <div class="max-w-screen-sm mx-auto my-8 ">

        <h2 class="text-lg font-semibold dark:text-white text-center">
            Profile
        </h2>


        <div class="mx-auto max-w-xl my-12 px-2">

            <x-errors />

            <form action="{{ route('user.update') }}" method="POST" class="space-y-5" enctype="multipart/form-data">

                @csrf @method('put')

                <div class="grid grid-cols-3 items-center">
                    <label for="Profile Picture" class="col-span-1 block text-sm font-medium text-gray-500">Profile
                        Picture</label>
                    <div class="col-span-2">

                        @php($image = str_replace('public/', 'storage/', $user->image));
                        <div x-data="{ imagePreview: @js(url($image)) }">
                            <!-- Image preview -->
                            <img x-bind:src="imagePreview" alt="{{ $user->username }}"
                                class="aspect-square w-24 rounded-lg mb-2">

                            <!-- File input -->
                            <input id="example1" type="file"
                                x-on:change="imagePreview = URL.createObjectURL($event.target.files[0])"
                                class="dark:text-white block w-full text-sm file:mr-4 file:rounded-md file:border-0 file:bg-blue-500 file:py-2.5 file:px-4 file:text-sm file:font-semibold file:text-white hover:file:bg-blue-700 focus:outline-none disabled:pointer-events-none disabled:opacity-60"
                                name="image" />
                        </div>


                    </div>
                </div>

                <div class="grid grid-cols-3 items-center">
                    <label for="username" class="col-span-1 block text-sm font-medium text-gray-500">Username</label>
                    <div class="col-span-2">
                        <input type="text" autocomplete="username" id="username"
                            class="block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-400 focus:ring focus:ring-blue-200 focus:ring-opacity-50 disabled:cursor-not-allowed disabled:bg-gray-50 disabled:text-gray-500 p-2"
                            placeholder="Username" name="username" required value="{{ $user->username }}" />
                    </div>
                </div>
                <div class="grid grid-cols-3 items-center">
                    <label for="Password" class="col-span-1 block text-sm font-medium text-gray-500">Password</label>
                    <div class="col-span-2">
                        <input type="password" autocomplete="Password" id="Password"
                            class="block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-400 focus:ring focus:ring-blue-200 focus:ring-opacity-50 disabled:cursor-not-allowed disabled:bg-gray-50 disabled:text-gray-500 p-2"
                            placeholder="Enter New Password" name="password" />
                    </div>
                </div>

                <div class="grid grid-cols-3 items-center">
                    <div class="col-span-2 col-start-2">
                        <button
                            class="rounded-lg border border-blue-500 bg-blue-500 px-5 py-2.5 text-center text-sm font-medium text-white shadow-sm transition-all hover:border-blue-700 hover:bg-blue-700 focus:ring focus:ring-blue-200 disabled:cursor-not-allowed disabled:border-blue-300 disabled:bg-blue-300">Submit</button>
                    </div>
                </div>
            </form>
        </div>



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
