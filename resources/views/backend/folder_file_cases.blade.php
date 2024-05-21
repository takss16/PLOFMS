<x-app-layout>
    <div class="container">
        <h3>File Cases for Folder: {{ $folder->folder_name }} (Case #{{ $case->case_number }})</h3>
        <div class="card mt-4">
            <div class="card-body">
                <div class="mb-5">
                    @hasrole('admin')
                    <form action="{{ route('file.store') }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        <input type="hidden" name="folders_id" value="{{ $folder->id }}">
                        <div class="form-group">
                            <label for="file_name">Upload File</label>
                            <input type="file" class="form-control" id="file_name" name="file_name" required>
                        </div>
                        <button type="submit" class="btn btn-primary mt-3">Add File</button>
                    </form>
                    @endrole()

                </div>
<hr>
                @if($folder->fileCases->isEmpty())
                    <p>No file cases available in this folder.</p>
                @else
                    <div class="row">
                        @foreach($folder->fileCases as $fileCase)
                            <div class="col-md-3 mb-4 col-3 mt-3">
                                <div class="card">
                                    <div class="zoom">
                                        <a href="{{ asset('storage/files/' . $fileCase->file_name) }}" data-lightbox="image-{{ $fileCase->id }}" data-title="{{ $fileCase->file_name }}">
                                            <img src="{{ asset('storage/files/' . $fileCase->file_name) }}" alt="{{ $fileCase->file_name }}" class="card-img-top" style="max-height: 200px; object-fit: cover;">
                                        </a>

                                    </div>
                                    <div class="card-body">
                                        <div class="text-center">
                                            <p class="card-title">{{ $fileCase->file_name }}</p>
                                            @hasrole('admin')
                                            <button type="button" class="btn btn-sm btn-danger" data-toggle="modal" data-target="#deleteFileModal{{ $fileCase->id }}">
                                                <i class="fas fa-trash"></i>
                                            </button>
                                            @endrole

                                        </div>

                                    </div>
                                </div>
                            </div>

                            <!-- Delete File Modal -->
                            <div class="modal fade" id="deleteFileModal{{ $fileCase->id }}" tabindex="-1" role="dialog" aria-labelledby="deleteFileModalLabel{{ $fileCase->id }}" aria-hidden="true">
                                <div class="modal-dialog" role="document">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h5 class="modal-title" id="deleteFileModalLabel{{ $fileCase->id }}">Delete File</h5>
                                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                <span aria-hidden="true">&times;</span>
                                            </button>
                                        </div>
                                        <div class="modal-body">
                                            <p>Are you sure you want to delete the file "{{ $fileCase->file_name }}"?</p>
                                        </div>
                                        <div class="modal-footer">
                                            <form action="{{ route('file.destroy', $fileCase->id) }}" method="POST">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-danger">Delete</button>
                                            </form>
                                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                @endif
                <div class="d-flex mt-3">
                    <a href="{{ route('case.folders', $case->id) }}" class="btn btn-primary me-2">Back to Folders</a>
                    <a href="{{ route('folder.viewPDF', ['caseId' => $case->id, 'folderId' => $folder->id]) }}" class="btn btn-primary">View PDF</a>
                </div>

            </div>
        </div>
    </div>
    <script>
        lightbox.option({
            'resizeDuration': 200,
            'wrapAround': true,
            'alwaysShowNavOnTouchDevices': true,
            'disableScrolling': true,
            'showImageNumberLabel': true,
            'albumLabel': "Image %1 of %2",
            'positionFromTop': 50,
            'fadeDuration': 600,
            'imageFadeDuration': 600,
            'resizeDuration': 700
        });
    </script>
</x-app-layout>
