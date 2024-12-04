<?php

namespace App\Http\Controllers;

use App\Models\Classes;
use Illuminate\Http\Request;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Exception;

class ClassesController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $items = Classes::latest()->get();
        return view('admin.class.index', compact('items'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.class.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'name' => 'required|string|unique:classes,name',
        ]);
        
        try {

            // Create the new classes
            Classes::create($validatedData);
        
            // Return success response (optional)
            return redirect()->route('classes.index')->with('success', __('Classes created successfully!'));

        } catch (ValidationException $e) {
            // Handle validation error
            return back()->withErrors($e->errors())->withInput();
        } catch (\Exception $e) {
            // Handle other exceptions
            return back()->with('error', __('Something went wrong. Please try again.'));
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(Classes $classes)
    {
       
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        $item = Classes::find($id);
        return view('admin.class.edit',compact('item'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Classes $classes)
    {
        $validatedData = $request->validate([
            'name' => 'required|string|unique:classes,name,'.$request->id,
        ]);
        
        try {

            $item = Classes::find($request->id);
            $item->update($validatedData);
        
            // Return success response (optional)
            return redirect()->route('classes.index')->with('success', __('Classes updated successfully!'));

        } catch (ValidationException $e) {
            // Handle validation error
            return back()->withErrors($e->errors())->withInput();
        } catch (\Exception $e) {
            // Handle other exceptions
            return back()->with('error', __('Something went wrong. Please try again.'));
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        try {
            $item = Classes::findOrFail($id);
            $item->delete();
            return redirect()->route('classes.index')->with(['success'=> __('Classes deleted successfully.')]);
        } catch (ModelNotFoundException $e) {
            return redirect()->route('classes.index')->with('error', __('Record not found.'));
        } catch (Exception $e) {            
            return redirect()->route('classes.index')->with('error', __('An error occurred while deleting the record.'));
        }
    }
}
