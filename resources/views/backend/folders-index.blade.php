<x-app-layout>
    <div class="container">
        <div class="card mt-4">
            <div class="card-body">
                <div class="mb-5">
                    <form action="{{ route('folders.filter') }}" method="GET">
                        <div class="form-group">
                            <label for="type">Filter by Type</label>
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
        <!-- Filtered Results -->
        <h2 class="mt-4">Filtered Folders</h2>
        @foreach($folders as $folder)
        <div style="display: inline-block; margin: 10px;">
            <div style="width: 200px; border: 1px solid #ccc; border-radius: 8px; padding: 10px; text-align: center; box-shadow: 0 2px 4px rgba(0,0,0,0.1);">
                <a href="{{ route('case.folderFiles', ['case' => encrypt($folder->cases_id), 'folder' => encrypt($folder->id)]) }}" style="text-decoration: none;">
                    <div class="card">
                        <div class="text-center mt-2">
                            <img src="{{ asset('admin_assets/img/folder.png') }}" alt="Folder Image" style="max-width: 50px; margin-bottom: 10px;">
                            <h4 style="margin: 0; color: inherit;">{{ $folder->folder_name }}</h4>
                            <p>{{ $folder->type }}</p>
                            <p>Case: {{ $folder->cases->case_number }} - {{ $folder->cases->name }}</p>
                            <p>Date: {{ $folder->cases->date }}</p>
                        </div>
                    </div>
                </a>
            </div>
        </div>
        @endforeach


    </div>
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

</x-app-layout>