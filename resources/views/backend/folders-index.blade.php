<x-app-layout>
    <div class="container">
        <div class="card mt-4">
            <div class="card-body">
                <div class="mb-5">
                    <form action="{{ route('folders.filter') }}" method="GET">
                        <div class="form-group">
                            <label for="type"><h2 class="mt-4">Filter Folders</h2></label>
                            <select class="form-control" id="type" name="type">
                                <option value="">Select Type</option>
                                <option value="criminal case">Criminal Case</option>
                                <option value="civil case">Civil Case</option>
                                <option value="admin case">Admin Case</option>
                                <option value="nps docketed">NPS Docketed</option>
                                <option value="pending case">Pending Case</option>
                                <option value="land transfer">Land Transfer</option>
                                <option value="annulment">Annulment</option>
                                <option value="blue box">Blue Box</option>
                                <option value="land issue">Land Issue</option>
                            </select>
                        </div>
                        <button type="submit" class="btn btn-primary">Filter</button>
                    </form>
                </div>
            </div>
        </div>

        <!-- Display Folders -->
        <div class="mt-4">
            <h2>Filtered Folders</h2>
            <div class="row">
                @foreach($folders as $folder)
                    <div class="col-lg-3 col-md-4 col-sm-6 mb-4">
                        <div class="card">
                            <div class="card-body">
                                    <a href="{{ route('case.casefolder', ['case' => encrypt($folder->cases->id), 'folder' => encrypt($folder->id), 'casefolder' => encrypt($folder->id)]) }}" style="text-decoration: none;">
                                        <div class="text-center mt-2">
                                            <img src="{{ asset('admin_assets/img/folder.png') }}" alt="Folder Image" style="max-width: 50px; margin-bottom: 10px;">
                                            <h4 style="margin: 0; color: inherit;">{{ $folder->folder_name }}</h4>
                                            <p>{{ $folder->type }}</p>
                                            <p>Case: {{ $folder->cases->case_number }} - {{ $folder->cases->name }}</p>
                                            <p>Date: {{ $folder->cases->date }}</p>
                                        </div>
                                    </a>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>

        <!-- Pagination -->
        <div class="mt-4">
            <ul class="pagination justify-content-center">
                {{-- Previous Page Link --}}
                @if ($folders->onFirstPage())
                    <li class="page-item disabled">
                        <span class="page-link">&laquo;</span>
                    </li>
                @else
                    <li class="page-item">
                        <a class="page-link" href="{{ $folders->previousPageUrl() }}" rel="prev">&laquo;</a>
                    </li>
                @endif

                {{-- Total Pages Count --}}
                <li class="page-item disabled">
                    <span class="page-link">Page {{ $folders->currentPage() }} of {{ $folders->lastPage() }}</span>
                </li>

                {{-- Next Page Link --}}
                @if ($folders->hasMorePages())
                    <li class="page-item">
                        <a class="page-link" href="{{ $folders->nextPageUrl() }}" rel="next">&raquo;</a>
                    </li>
                @else
                    <li class="page-item disabled">
                        <span class="page-link">&raquo;</span>
                    </li>
                @endif
            </ul>
        </div>
    </div>
</x-app-layout>
