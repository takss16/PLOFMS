<x-app-layout>
    <div class="container text-center">
        <h3>Create Case</h3>
    </div>
    @if (session('error'))
    <div class="alert alert-danger">
        {{ session('error') }}
    </div>
    @endif

    <div class="container mt-4 mb-4">
        <div class="card mx-auto" style="max-width: 500px;">
            <div class="card-body">
                <!-- Form for creating a case -->
                <form action="{{ route('store.case') }}" method="POST" enctype="multipart/form-data">
                    @csrf <!-- CSRF protection -->
                    <div class="form-group">
                        <label for="case_number">Case Number:</label>
                        <input type="text" class="form-control" id="case_number" name="case_number">
                    </div>
                    <div class="form-group">
                        <label for="docker_number">Docker Number:</label>
                        <input type="text" class="form-control" id="docker_number" name="docker_number">
                    </div>
                    <div class="form-group">
                        <label for="date">Date:</label>
                        <input type="date" class="form-control" id="date" name="date">
                    </div>
                    <div class="form-group">
                        <label for="name">Name:</label>
                        <input type="text" class="form-control" id="name" name="name">
                    </div>
                  
                    <button type="submit" class="btn btn-primary">Submit</button>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>