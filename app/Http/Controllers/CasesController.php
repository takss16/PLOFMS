<?php

namespace App\Http\Controllers;

use App\Models\Cases;
use App\Models\Folders;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf as PDF;
use App\Http\Requests\StoreCasesRequest;
use App\Http\Requests\UpdateCasesRequest;

class CasesController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function createCase()
    {
        return view('backend.create-case');
    }

        public function showFolders($id)
    {
        // Find the case or fail, loading its folders and associated files
        $case = Cases::with('folders.fileCases')->findOrFail($id);

        // Return the view with the case data
        return view('backend.case_folders', compact('case'));
    }



    public function viewPDF($id)
    {
        // Find the case or fail
        $case = Cases::with('folders.fileCases')->findOrFail($id);

        // Pass the case data to the view
        $pdf = PDF::loadView('backend.case_pdf', compact('case'));

        // Stream the generated PDF
        return $pdf->stream('case_'.$case->case_number.'.pdf');
    }




    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // Validate the incoming request data
        $validatedData = $request->validate([
            'case_number' => 'required|string',
            'docker_number' => 'nullable|string',
            'files.*' => 'nullable|file',
            'name' => 'required|string',
            'folder_name' => 'nullable|string', // Added validation for folder_name
        ]);

        try {
            // Retrieve or create the case by its case_number
            $case = Cases::firstOrCreate(
                ['case_number' => $validatedData['case_number']],
                ['docker_number' => $validatedData['docker_number'], 'name' => $validatedData['name']]
            );

            // Determine the folder name
            $folderName = $validatedData['folder_name'] ?? 'Folder for ' . $validatedData['case_number'];

            // Create a folder for this case
            $folder = $case->folders()->create([
                'folder_name' => $folderName,
            ]);

            // Upload files if present in the request
            if ($request->hasFile('files')) {
                foreach ($request->file('files') as $file) {
                    if ($file->isValid()) {
                        // Get the original file name
                        $fileName = $file->getClientOriginalName();

                        // Store the file in the 'files' directory using the original file name
                        $filePath = $file->storeAs('public/files', $fileName);

                        // Create a new filecase record with the original file name
                        $folder->fileCases()->create([
                            'file_name' => $fileName,
                            'file_path' => $filePath,
                        ]);
                    } else {
                        return redirect()->back()->with('error', 'Invalid file upload');
                    }
                }
            }

            return redirect('folders')->with('success', 'Files uploaded successfully');
        } catch (\Exception $e) {
            // Handle any exceptions (e.g., file storage errors)
            return redirect()->back()->with('error', 'An error occurred: ' . $e->getMessage());
        }
    }


    /**
     * Display the specified resource.
     */
    public function show(Cases $cases)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        // Find the case or fail
        $case = Cases::with('folders.fileCases')->findOrFail($id);

        return view('backend.edit-case', compact('case'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $case = Cases::findOrFail($id);

        // Validate the incoming request data
        $validatedData = $request->validate([
            'case_number' => 'required|string',
            'docker_number' => 'nullable|string',
            'name' => 'required|string',
        ]);

        // Update case details
        $case->update([
            'case_number' => $validatedData['case_number'],
            'docker_number' => $validatedData['docker_number'],
            'name' => $validatedData['name']
        ]);



        return redirect()->route('folders')->with('success', 'Case updated successfully');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Cases $cases)
    {
        //
    }
}
