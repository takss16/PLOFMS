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

    public function showFolders($encryptedId)
    {
        $id = decrypt($encryptedId);
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
        return $pdf->stream('case_' . $case->case_number . '.pdf');
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
            'name' => 'required|string',
            'date' => 'required|date', // Validate the date field
        ]);
    
        try {
            // Create a new case
            $case = Cases::create([
                'case_number' => $validatedData['case_number'],
                'docker_number' => $validatedData['docker_number'] ?? null,
                'name' => $validatedData['name'],
                'date' => $validatedData['date'],
            ]);
    
            return redirect('folders')->with('success', 'Case stored successfully');
        } catch (\Exception $e) {
            // Handle any exceptions
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
