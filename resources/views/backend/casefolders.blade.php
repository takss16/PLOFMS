<x-app-layout>
    <div class="container">
        <h3>Case Folders for Folder: {{ $folder->folder_name }} (Case #{{ $case->case_number }})</h3>
        <div class="card mt-4">
            <div class="card-body">
                @if ($errors->any())
                    <div class="alert alert-danger">
                        <ul>
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                @hasrole('admin')
                <div class="mt-3 mb-3">
                    <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#addFolderModal">Add Folder</button>
                </div>
                @endrole

                <form action="{{ route('case.casefolder', ['case' => encrypt($case->id), 'folder' => encrypt($folder->id)]) }}" method="GET">
                    <div class="input-group mb-3">
                        <input type="text" class="form-control" name="query" placeholder="Search for case folders..." value="{{ request('query') }}">
                        <div class="input-group-append">
                            <button class="btn btn-primary" type="submit">Search</button>
                        </div>
                    </div>
                </form>

                @if($casefolders->isEmpty())
                    <p>No case folders available in this folder.</p>
                @else
                <div class="row">
                    @foreach($casefolders as $casefolder)
                        <div class="col-lg-3 col-md-4 col-sm-6 col-12 mb-4 mt-3">
                            <div class="card">
                                <div class="card-body">
                                    <div class="text-center">
                                        <div class="mb-3">
                                        <a href="{{ route('case.folderFiles', ['case' => encrypt($case->id), 'folder' => encrypt($folder->id), 'casefolder' => encrypt($casefolder->id)]) }}" style="text-decoration: none;">
                                            <div class="card">
                                                <div class="text-center mt-2">
                                                    <img src="{{ asset('admin_assets/img/casefolder.jpg') }}" alt="Folder Image" style="max-width: 50px; margin-bottom: 10px;">
                                                    <p class="card-title">{{ $casefolder->folder_name }}</p>
                                                </div>
                                            </div>
                                        </a>  
                                        </div>                                    
                                        @hasrole('admin')
                                        <!-- Edit Button -->
                                        <button type="button" class="btn btn-sm btn-warning" data-toggle="modal" data-target="#editCasefolderModal{{ $casefolder->id }}">
                                            <i class="fas fa-edit"></i>
                                        </button>

                                        <!-- Delete Button -->
                                        <button type="button" class="btn btn-sm btn-danger" data-toggle="modal" data-target="#deleteCasefolderModal{{ $casefolder->id }}">
                                            <i class="fas fa-trash"></i>
                                        </button>
                                        @endrole
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Edit Casefolder Modal -->
                        <div class="modal fade" id="editCasefolderModal{{ $casefolder->id }}" tabindex="-1" role="dialog" aria-labelledby="editCasefolderModalLabel{{ $casefolder->id }}" aria-hidden="true">
                            <div class="modal-dialog" role="document">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title" id="editCasefolderModalLabel{{ $casefolder->id }}">Edit Case Folder</h5>
                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                            <span aria-hidden="true">&times;</span>
                                        </button>
                                    </div>
                                    <form action="{{ route('casefolder.update', $casefolder->id) }}" method="POST">
                                        @csrf
                                        @method('PUT')
                                        <div class="modal-body">
                                            <div class="form-group">
                                                <label for="folder_name">Case Folder Name</label>
                                                <input type="text" class="form-control" id="folder_name" name="folder_name" value="{{ $casefolder->folder_name }}" required>
                                            </div>
                                        </div>
                                        <div class="modal-footer">
                                            <button type="submit" class="btn btn-primary">Save changes</button>
                                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>

                        <!-- Delete Casefolder Modal -->
                        <div class="modal fade" id="deleteCasefolderModal{{ $casefolder->id }}" tabindex="-1" role="dialog" aria-labelledby="deleteCasefolderModalLabel{{ $casefolder->id }}" aria-hidden="true">
                            <div class="modal-dialog" role="document">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title" id="deleteCasefolderModalLabel{{ $casefolder->id }}">Delete Case Folder</h5>
                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                            <span aria-hidden="true">&times;</span>
                                        </button>
                                    </div>
                                    <div class="modal-body">
                                        <p>Are you sure you want to delete the case folder "{{ $casefolder->folder_name }}"?</p>
                                    </div>
                                    <div class="modal-footer">
                                        <form action="{{ route('casefolder.destroy', $casefolder->id) }}" method="POST">
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
                    <a href="{{ route('case.folders', encrypt($case->id)) }}" class="btn btn-secondary me-2">Back to Folders</a>
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
                    <form action="{{ route('casefolder.store') }}" method="POST">
                        @csrf
                        <input type="hidden" name="folder_id" value="{{ $folder->id }}">
                        <div class="form-group">
                            <label for="folder_name">Add Case Folder</label>
                            <input type="text" class="form-control" id="folder_name" name="folder_name" required>
                        </div>
                        <div class="modal-footer">
                            <button type="submit" class="btn btn-primary">Add Folder</button>
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
