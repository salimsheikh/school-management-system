<?php

namespace App\Http\Controllers;

use App\Models\AcademicYear;
use Illuminate\Http\Request;
use Illuminate\Database\Eloquent\ModelNotFoundException;

class AcademicYearController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $items = AcademicYear::latest()->get();
        return view('admin.academic-year.index', compact('items'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.academic-year.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'name' => 'required|string|unique:academic_years,name',
        ]);
        
        try {

            // Create the new academic year
            AcademicYear::create($validatedData);
        
            // Return success response (optional)
            return redirect()->route('academic-year.index')->with('success', __('Academic Year created successfully!'));

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
    public function show(AcademicYear $academicYear)
    {
       
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        $item = AcademicYear::find($id);        
        return view('admin.academic-year.edit',compact('item'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, AcademicYear $academicYear)
    {
       
        $validatedData = $request->validate([
            'name' => 'required|string|unique:academic_years,name,'.$request->id,
        ]);
        
        try {

            $item = AcademicYear::find($request->id);
            $item->update($validatedData);
        
            // Return success response (optional)
            return redirect()->route('academic-year.index')->with('success', __('Academic Year updated successfully!'));

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
            $item = AcademicYear::findOrFail($id);
            $item->delete();
            return redirect()->route('academic-year.index')->with(['success'=> __('Academic Year deleted successfully.')]);
        } catch (ModelNotFoundException $e) {
            return redirect()->route('academic-year.index')->with('error', __('Record not found.'));
        } catch (Exception $e) {            
            return redirect()->route('academic-year.index')->with('error', __('An error occurred while deleting the record.'));
        }
    }
}
