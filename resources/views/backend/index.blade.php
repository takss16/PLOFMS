<x-app-layout>
    <div class="container text-center">
        <h3>FOLDER MANAGEMENT</h3>
    </div>
    <div class="card mx-auto" style="max-width: auto; margin-left:20px !important; margin-right:20px !important;"> <!-- Adjust max-width as needed -->
        <div class="card-body">
            <a href="{{ route('case') }}" class="btn btn-success">Add new case</a>
            <div class="row justify-content-center">
                <div class="col-md-8 text-center">
                    {{-- <div class="input-group">
                        <input type="text" class="form-control bg-light border-0 small" placeholder="Search for..." aria-label="Search" aria-describedby="basic-addon2">
                        <div class="input-group-append">
                            <button href="{{route('case')}}" class="btn btn-primary" type="button">
                                <i class="fas fa-search fa-sm"></i>
                            </button>
                        </div>
                    </div> --}}
                </div>
            </div>
        </div>
        <hr >
        {{-- table start --}}
        <div class="card shadow mb-4">
            <div class="card-header py-3">
                <h6 class="m-0 font-weight-bold text-primary">Cases Folder</h6>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table id="dataTable" class="table table-bordered" width="100%" cellspacing="0">
                        <thead>
                            <tr>
                                <th>Case No#.</th>
                                <th>Docker No#.</th>
                                <th>File</th>
                                <th>Name</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($cases as $case)
                            <tr>
                                <td>{{ $case->case_number }}</td>
                                <td>{{ $case->docker_number }}</td>
                                <td class="text-center">
                                    <a href="{{ route('case.folders', encrypt($case->id)) }}">
                                        <img src="{{ asset('admin_assets/img/folder.png') }}" alt="Folder Image" class="img-fluid" style="max-width: 50px; cursor: pointer;">
                                    </a>

                                </td>
                                <td>{{ $case->name }}</td>
                                <td>
                                    @hasrole('admin')
                                    <a href="{{ route('case.edit', $case->id) }}" class="btn btn-primary">Update</a>
                                    @elserole('assistant')
                                    not allowed for this action
                                    @endrole

                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
