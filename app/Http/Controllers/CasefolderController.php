<?php

namespace App\Http\Controllers;

use App\Models\Casefolder;
use Illuminate\Http\Request;

class CasefolderController extends Controller
{
    public function create()
    {
        $folders = Folders::all();
        return view('backend.create_casefolder', compact('folders'));
    }

    public function store(Request $request)
    {
        // Validate the request
        $request->validate([
            'folder_id' => 'required|exists:folders,id',
            'folder_name' => 'required|string|max:255',
        ]);

        // Create a new Casefolder
        Casefolder::create([
            'folder_id' => $request->folder_id,
            'folder_name' => $request->folder_name,
        ]);

        // Redirect back with a success message
        return redirect()->back()->with('success', 'Casefolder created successfully.');
    }

    public function update(Request $request, $id)
    {
        // Validate the request
        $request->validate([
            'folder_name' => 'required|string|max:255',
        ]);

        // Find and update the Casefolder
        $casefolder = Casefolder::findOrFail($id);
        $casefolder->update([
            'folder_name' => $request->folder_name,
        ]);

        // Redirect back with a success message
        return redirect()->back()->with('success', 'Casefolder updated successfully.');
    }

    public function destroy($id)
    {
        // Find and delete the Casefolder
        $casefolder = Casefolder::findOrFail($id);
        $casefolder->delete();

        // Redirect back with a success message
        return redirect()->back()->with('success', 'Casefolder deleted successfully.');
    }
}
