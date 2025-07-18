<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\DefaultWeightOption;
use Illuminate\Http\Request;

class DefaultWeightOptionController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $weightOptions = DefaultWeightOption::orderBy('sort_order')->orderBy('min_weight')->get();
        
        return view('admin.weight-options.index', compact('weightOptions'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.weight-options.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $isSetValue = $request->input('option_type') === 'set';
        
        $rules = [
            'value' => 'required|string|max:50|unique:default_weight_options,value',
            'label' => 'required|string|max:255',
            'sort_order' => 'integer|min:0',
            'is_active' => 'boolean',
        ];
        
        if ($isSetValue) {
            $rules['set_weight'] = 'required|numeric|min:0';
        } else {
            $rules['min_weight'] = 'required|numeric|min:0';
            $rules['max_weight'] = 'nullable|numeric|min:0|gt:min_weight';
        }
        
        $request->validate($rules);

        $data = $request->only(['value', 'label', 'sort_order', 'is_active']);
        $data['is_set_value'] = $isSetValue;
        
        if ($isSetValue) {
            $data['set_weight'] = $request->input('set_weight');
        } else {
            $data['min_weight'] = $request->input('min_weight');
            $data['max_weight'] = $request->input('max_weight');
        }

        DefaultWeightOption::create($data);

        return redirect()->route('admin.weight-options.index')
            ->with('success', 'Weight option created successfully.');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(DefaultWeightOption $weightOption)
    {
        return view('admin.weight-options.edit', compact('weightOption'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, DefaultWeightOption $weightOption)
    {
        $request->validate([
            'value' => 'required|string|max:50|unique:default_weight_options,value,' . $weightOption->id,
            'label' => 'required|string|max:255',
            'min_weight' => 'nullable|numeric|min:0',
            'max_weight' => 'nullable|numeric|min:0|gt:min_weight',
            'sort_order' => 'integer|min:0',
            'is_active' => 'boolean',
        ]);

        $weightOption->update($request->all());

        return redirect()->route('admin.weight-options.index')
            ->with('success', 'Weight option updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(DefaultWeightOption $weightOption)
    {
        $weightOption->delete();

        return redirect()->route('admin.weight-options.index')
            ->with('success', 'Weight option deleted successfully.');
    }

    /**
     * Toggle the active status of a weight option.
     */
    public function toggleActive(DefaultWeightOption $weightOption)
    {
        $weightOption->update(['is_active' => !$weightOption->is_active]);

        return redirect()->route('admin.weight-options.index')
            ->with('success', 'Weight option status updated successfully.');
    }
}
