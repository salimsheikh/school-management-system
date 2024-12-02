<?php

namespace App\Http\Controllers;

use App\Models\FeeHead;
use Illuminate\Http\Request;

class FeeHeadController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $items = FeeHead::latest()->get();
        return view('admin.fee-head.index', compact('items'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.fee-head.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'name' => 'required|string|unique:fee_heads,name',
        ]);
        
        try {

            // Create the new academic year
            FeeHead::create($validatedData);
        
            // Return success response (optional)
            return redirect()->route('fee-head.index')->with('success', __('Fee Head created successfully!'));

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
    public function show(FeeHead $feeHead)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(FeeHead $feeHead)
    {
        $item = FeeHead::find($feeHead->id);        
        return view('admin.fee-head.edit',compact('item'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, FeeHead $feeHead)
    {
        $validatedData = $request->validate([
            'name' => 'required|string|unique:fee_heads,name,'.$request->id,
        ]);
        
        try {

            $item = FeeHead::find($request->id);
            $item->update($validatedData);
        
            // Return success response (optional)
            return redirect()->route('fee-head.index')->with('success', __('Fee Head updated successfully!'));

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
    public function destroy(FeeHead $feeHead)
    {
        $feeHead->delete($feeHead);
        return redirect()->route('fee-head.index')->with(['success'=> __('Fee Head deleted successfully.')]);
    }
}
