<?php

namespace App\Http\Controllers;

use App\Models\FeeStructure;
use App\Models\AcademicYear;
use App\Models\Classes;
use App\Models\FeeHead;
use Illuminate\Http\Request;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Exception;

use App\Services\MonthService;

class FeeStructureController extends Controller
{
    
    protected $monthService;

    public function __construct()
    {
        $this->monthService = new MonthService();
    }

    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {   
        $columns = collect([]);
        $columns['academic_year_id'] = __('Year');
        $columns['class_id'] = __('Class');
        $columns['fee_head_id'] = __('Fee');

        $months = $this->monthService->getMonths(true);

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
        $data['months_fields'] = $this->monthService->getMonths();
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
        $data['months_fields'] = $this->monthService->getMonths();
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
    public function destroy($id)
    {
        try {
            $item = FeeStructure::findOrFail($id);
            $item->delete();
            return redirect()->route('fee-structure.index')->with(['success'=> __('Fee Structure deleted successfully.')]);
        } catch (ModelNotFoundException $e) {
            return redirect()->route('fee-structure.index')->with('error', __('Record not found.'));
        } catch (Exception $e) {            
            return redirect()->route('fee-structure.index')->with('error', __('An error occurred while deleting the record.'));
        }
    }    
}
