<?php

namespace App\Http\Controllers;

use App\Models\FeeStructure;
use App\Models\AcademicYear;
use App\Models\Classes;
use App\Models\FeeHead;
use Illuminate\Http\Request;

class FeeStructureController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {   
        $columns = collect([]);
        $columns['academic_year_id'] = __('Year');
        $columns['class_id'] = __('Class');
        $columns['fee_head_id'] = __('Fee');

        $months = $this->getMonths(true);

        $columns = $columns->merge($months);
       
        $data = [];        
        $data['academicYears'] = AcademicYear::all();
        $data['classes'] = Classes::all();
        
        $items = FeeStructure::query()->with(['FeeHead','Classes','AcademicYear'])->latest();        

        if($request->filled('class')){
            //$items->where('class_id', $request->query('class'));
        }

        if($request->filled('year')){
            //$items->where('academic_year_id', $request->query('year'));
        }

        $items = $items->get();

        $data['months'] = $months;
        $data['columns'] = $columns;
        $data['items'] = $items;
        $data['class_id'] = $request->query('class');
        $data['academic_year_id'] = $request->query('year');
        return view('admin.fee-structure.index',$data);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $data = [];
        $data['months_fields'] = $this->getMonths(false);
        $data['academicYears'] = AcademicYear::all();
        $data['classes'] = Classes::all();
        $data['feeHeads'] = FeeHead::all();
        $data['defaultFee'] = '400';
        return view('admin.fee-structure.create',$data);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'academic_year_id' => 'required',
            'fee_head_id' => 'required',
            'class_id' => 'required',
        ]);

        try {

            // Create the new academic year
            FeeStructure::create($request->all());
        
            // Return success response (optional)
            return redirect()->route('fee-structure.index')->with('success', __('Fee Structure created successfully!'));

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
    public function show(FeeStructure $feeStructure)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(FeeStructure $feeStructure)
    {
        $data = [];
        $data['months_fields'] = $this->getMonths(false);
        $data['academicYears'] = AcademicYear::all();
        $data['classes'] = Classes::all();
        $data['feeHeads'] = FeeHead::all();
        $data['defaultFee'] = '';
        $data['item'] = FeeStructure::find($feeStructure->id);    
        return view('admin.fee-structure.edit',$data);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, FeeStructure $feeStructure)
    {
        $validatedData = $request->validate([
            'academic_year_id' => 'required',
            'fee_head_id' => 'required',
            'class_id' => 'required',
        ]);
        
        try {

            $item = FeeStructure::find($request->id);
            $item->update($request->all());
        
            // Return success response (optional)
            return redirect()->route('fee-structure.index')->with('success', __('Fee Structure updated successfully!'));

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
    public function destroy(FeeStructure $feeStructure)
    {
        $feeStructure->delete($feeStructure);
        return redirect()->route('fee-structure.index')->with(['success'=> __('Fee Structure deleted successfully.')]);
    }

    function getMonths($short = false)
    {
        $startMonth = 'June'; // Fetch dynamically from the database or settings

        // List of all months
        if($short){
            $startMonth = substr($startMonth,0,3);
            $months = collect([
                __('Jan'), __('Febr'), __('Mar'), __('Apr'), __('May'), __('Jun'), __('Jul'), __('Aug'), __('Sept'), __('Oct'), __('Nov'), __('Dec')
            ]);
        }else{
            $months = collect([
                __('January'), __('February'), __('March'), __('April'), __('May'), __('June'),__('July'), __('August'), __('September'), __('October'), __('November'), __('December')
            ]);
        }
        

        // Find the starting index for the given start month
        $startIndex = $months->search($startMonth);

        // Rotate the months array to start from the configured month
        $orderedMonths = $months->slice($startIndex)->merge($months->take($startIndex));

        // Generate the months_fields array dynamically
        $months_fields = $orderedMonths->mapWithKeys(function ($month, $index) {
            $key = 'month' . str_pad($index + 1, 2, '0', STR_PAD_LEFT);
            return [$key => __($month)];
        });

        // Convert to an array if needed
        $months_fields = $months_fields->toArray();

        
        return $months_fields;
    }
}
