<?php

namespace App\Http\Controllers;

use App\Models\Cases;
use App\Models\Folders;
use App\Models\Casefolder;
use App\Models\Filecases;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Barryvdh\DomPDF\Facade\Pdf as PDF;

class FilecasesController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function viewFolders()
    {
        $cases = Cases::with('folders')->get();

        return view('backend.index', compact('cases'));
    }

    public function viewPDF($caseId, $folderId)
    {
        // Find the case or fail
        $case = Cases::findOrFail($caseId);
    
        // Find the folder with its associated casefolders and files or fail
        $folder = Folders::with('casefolders.fileCases')->findOrFail($folderId);
    
        // Pass the case and folder data to the view
        $pdf = PDF::loadView('backend.case_pdf', compact('case', 'folder'));
    
        // Stream the generated PDF
        return $pdf->stream('folder_'.$folder->folder_name.'_case_'.$case->case_number.'.pdf');
    }
    

    public function dashboard()
    {
        // Retrieve the authenticated user
        $user = Auth::user();

        return view('dashboard', compact('user'));
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
    $request->validate([
        'file_name.*' => 'required|file|mimes:jpg,jpeg,png',
        'casefolder_id' => 'required|exists:casefolders,id',
    ]);

    try {
        foreach ($request->file('file_name') as $file) {
            $fileName = time() . '_' . $file->getClientOriginalName();
            $filePath = $file->storeAs('files', $fileName, 'public');

            // Create Filecases record with casefolder_id
            Filecases::create([
                'casefolder_id' => $request->casefolder_id,
                'file_name' => $fileName,
            ]);
        }

        return redirect()->back()->with('success', 'Files uploaded successfully.');
    } catch (\Exception $e) {
        // Log the error message for debugging
        \Log::error('File upload error: ' . $e->getMessage());

        // Display an error message
        return redirect()->back()->with('error', 'An error occurred: ' . $e->getMessage());
    }
}


    /**
     * Display the specified resource.
     */
    public function show(Filecases $filecases)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Filecases $filecases)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Filecases $filecases)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $fileCase = FileCases::findOrFail($id);
        $filePath = 'files/' . $fileCase->file_name;

        if (Storage::disk('public')->exists($filePath)) {
            Storage::disk('public')->delete($filePath);
        }

        $fileCase->delete();

        return redirect()->back()->with('success', 'File deleted successfully.');
    }

    // /**
    //  * Display the file cases for a specific case folder.
    //  */
    // public function viewFileCases($encryptedCaseId, $encryptedFolderId, $encryptedCasefolderId)
    // {
    //     $caseId = decrypt($encryptedCaseId);
    //     $folderId = decrypt($encryptedFolderId);
    //     $casefolderId = decrypt($encryptedCasefolderId);

    //     $case = Cases::findOrFail($caseId);
    //     $folder = Folders::findOrFail($folderId);
    //     $casefolder = Casefolder::with('fileCases')->findOrFail($casefolderId);

    //     return view('backend.view_filecases', compact('case', 'folder', 'casefolder'));
    // }
}
