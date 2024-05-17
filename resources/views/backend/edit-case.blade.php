<x-app-layout>
    <div class="container text-center">
        <h3>Edit Case</h3>
    </div>
    @if (session('error'))
    <div class="alert alert-danger">
        {{ session('error') }}
    </div>
    @endif

    <div class="container mt-4 mb-4">
        <div class="card mx-auto" style="max-width: 800px;">

            <div class="card-body">
                <form action="{{ route('case.update', $case->id) }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="form-group">
                        <label for="case_number">Case Number</label>
                        <input type="text" name="case_number" class="form-control" value="{{ $case->case_number }}" required>
                    </div>
                    <div class="form-group">
                        <label for="docker_number">Docker Number</label>
                        <input type="text" name="docker_number" class="form-control" value="{{ $case->docker_number }}">
                    </div>
                    <div class="form-group">
                        <label for="name">Name</label>
                        <input type="text" name="name" class="form-control" value="{{ $case->name }}" required>
                    </div>

                    <button type="submit" class="btn btn-primary">Update Case</button>
                </form>

            </div>
        </div>
    </div>
</x-app-layout>
