<!DOCTYPE html>
<html>
<head>
    <title>Folder Files PDF</title>
    <style>
        body {
            font-family: DejaVu Sans, sans-serif;
        }
        .file-case {
            display: inline-block;
            margin: 10px;
            text-align: center;
        }
        .file-case img {
            max-height: 200px;
            object-fit: cover;
        }
    </style>
</head>
<body>
    <h3>Folder: {{ $folder->folder_name }} (Case #{{ $case->case_number }})</h3>
    @if($folder->fileCases->isEmpty())
        <p>No file cases available in this folder.</p>
    @else
        @foreach($folder->fileCases as $fileCase)
            <div class="file-case">
                <img src="{{ public_path('storage/files/' . $fileCase->file_name) }}" alt="{{ $fileCase->file_name }}">
                <p>{{ $fileCase->file_name }}</p>
            </div>
        @endforeach
    @endif
</body>
</html>
