<?php

namespace App\Http\Controllers;

use App\Models\Cases;
use App\Models\Folders;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf as PDF;

class FolderController extends Controller
{

    public function index()
    {
        // Display all folders initially, paginated
        $folders = Folders::with('cases')->paginate(8);
      
        return view('backend.folders-index', compact('folders'));
    }

    public function filter(Request $request)
    {
        $query = Folders::query();

        if ($request->has('type') && !empty($request->type)) {
            $query->where('type', $request->type);
        }

        $folders = $query->with('cases')->paginate(8);

        return view('backend.folders-index', compact('folders'));
    }

    public function viewFolderFileCases($encryptedCaseId, $encryptedFolderId)
    {
        $caseId = decrypt($encryptedCaseId);
        $folderId = decrypt($encryptedFolderId);

        $case = Cases::findOrFail($caseId);
        $folder = Folders::with('fileCases')->findOrFail($folderId);

        return view('backend.folder_file_cases', compact('case', 'folder'));
    }




    public function storeFolder(Request $request)
    {
        // Validate the request
        $validatedData = $request->validate([
            'cases_id' => 'required|exists:cases,id',
            'folder_name' => 'required|string|max:255',
            'type' => 'required|string|in:criminal case,civil case,admin case,nps docketed,pending case,land transfer,annulment,blue box,land issue',
            // Add more validation rules if needed
        ]);
    
        // Create the folder
        Folders::create([
            'cases_id' => $validatedData['cases_id'],
            'folder_name' => $validatedData['folder_name'],
            'type' => $validatedData['type'],
            // Add other fields if needed
        ]);
    
        // Redirect back with success message
        return redirect()->back()->with('success', 'Folder created successfully');
    }
    

    public function update(Request $request, Folders $folder)
    {
        // Validate the incoming request data
        $validatedData = $request->validate([
            'folder_name' => 'required|string|max:255',
            'type' => 'required|string|in:criminal case,civil case,admin case,nps docketed,pending case,land transfer,annulment,blue box,land issue',
        ]);
    
        try {
            // Update the folder name and type
            $folder->update([
                'folder_name' => $validatedData['folder_name'],
                'type' => $validatedData['type'],
            ]);
    
            return redirect()->back()->with('success', 'Folder updated successfully');
        } catch (\Exception $e) {
            // Handle any exceptions
            return redirect()->back()->with('error', 'An error occurred: ' . $e->getMessage());
        }
    }
    


    public function destroy($caseId, $folderId)
    {
        // Find the folder by its ID
        $folder = Folders::findOrFail($folderId);

        // Check if the folder belongs to the given case
        if ($folder->cases_id != $caseId) {
            abort(404); // Or handle the error as per your requirement
        }

        // Delete the folder
        $folder->delete();

        // Redirect back with success message
        return redirect()->back()->with('success', 'Folder deleted successfully');
    }
}


