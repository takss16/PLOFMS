<x-app-layout>
    <div class="container">
        <h3><b>{{ $case->name }}</b> Case Folders</h3>
        <div class="card">
            <div class="card-body">
                @hasrole('admin')
                <div class="mt-3 mb-3">
                    <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#addFolderModal">Add Folder</button>
                </div>
                @endrole()

                @if($case->folders->isEmpty())
                    <p>No folders found.</p>
                @else
                @foreach($case->folders as $folder)

                <div style="display: inline-block; margin: 10px;">
                        <div style="width: 200px; border: 1px solid #ccc; border-radius: 8px; padding: 10px; text-align: center; box-shadow: 0 2px 4px rgba(0,0,0,0.1);">
                            <a href="{{ route('case.folderFiles', ['case' => encrypt($case->id), 'folder' => encrypt($folder->id)]) }}" style="text-decoration: none;">
                                <div class="card">
                                    <div class="text-center mt-2">
                                        <img src="{{ asset('admin_assets/img/folder.png') }}" alt="Folder Image" style="max-width: 50px; margin-bottom: 10px;">
                                        <h4 style="margin: 0; color: inherit;">{{ $folder->folder_name }}</h4>
                                    </div>
                                </div>
                            </a>

                            <hr>
                            @hasrole('admin')
                            <button type="button" class="btn btn-sm btn-danger" data-toggle="modal" data-target="#deleteFolderModal{{ $folder->id }}">
                                <i class="fas fa-trash"></i>
                            </button>
                            <button type="button" class="btn btn-sm btn-primary" data-toggle="modal" data-target="#editFolderModal{{ $folder->id }}">
                                <i class="fas fa-pencil-alt"></i>
                            </button>
                            @endrole

                        </div>

                        <div class="modal fade" id="editFolderModal{{ $folder->id }}" tabindex="-1" role="dialog" aria-labelledby="editFolderModalLabel{{ $folder->id }}" aria-hidden="true">
                            <div class="modal-dialog" role="document">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title" id="editFolderModalLabel{{ $folder->id }}">Edit Folder</h5>
                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                            <span aria-hidden="true">&times;</span>
                                        </button>
                                    </div>
                                    <div class="modal-body">
                                        <!-- Edit folder form -->
                                        <form action="{{ route('folder.update', ['folder' => $folder->id]) }}" method="POST">
                                            @csrf
                                            @method('PUT')
                                            <div class="form-group">
                                                <label for="folder_name">Folder Name</label>
                                                <input type="text" class="form-control" id="folder_name" name="folder_name" value="{{ $folder->folder_name }}" required>
                                            </div>
                                            <div class="modal-footer">
                                            <button type="submit" class="btn btn-primary">Update Folder</button>
                                        </form>
                                           <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                                    </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!-- Delete Folder Modal -->
                        <div class="modal fade" id="deleteFolderModal{{ $folder->id }}" tabindex="-1" role="dialog" aria-labelledby="deleteFolderModalLabel{{ $folder->id }}" aria-hidden="true">
                            <div class="modal-dialog" role="document">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title" id="deleteFolderModalLabel{{ $folder->id }}">Delete Folder</h5>
                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                            <span aria-hidden="true">&times;</span>
                                        </button>
                                    </div>
                                    <div class="modal-body">
                                        <p>Are you sure you want to delete the folder "{{ $folder->folder_name }}"?</p>
                                    </div>
                                    <div class="modal-footer">
                                        <form action="{{ route('folder.destroy', ['case' => $case->id, 'folder' => $folder->id]) }}" method="POST">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-danger">Delete</button>
                                        </form>
                                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                </div>
            @endforeach

                @endif

                <div class="mt-5">
                    <a href="{{ route('folders') }}" class="btn btn-secondary">Back to Cases</a>
                </div>
            </div>
        </div>
    </div>

    <!-- Add Folder Modal -->
    <div class="modal fade" id="addFolderModal" tabindex="-1" role="dialog" aria-labelledby="addFolderModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="addFolderModalLabel">Add Folder</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <!-- Add your form elements for adding a folder here -->
                    <form action="{{ route('folder.store') }}" method="POST">
                        @csrf
                        <input type="hidden" name="cases_id" value="{{ $case->id }}">
                        <div class="form-group">
                            <label for="folder_name">Folder Name</label>
                            <input type="text" class="form-control" id="folder_name" name="folder_name" required>
                        </div>
                        <div class="modal-footer">
                        <button type="submit" class="btn btn-primary">Add Folder</button>
                    </form>
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                        </div>

                </div>
            </div>
        </div>
    </div>


</x-app-layout>
