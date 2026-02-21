<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ConsultationGeneral;
use App\Models\ConsultationProduct;
use App\Models\ConsultationCustomProduct;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class ConsultationController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Display the consultation settings page
     */
    public function index()
    {
        // Ambil data (hanya 1 baris masing-masing)
        $general = ConsultationGeneral::first();
        $product = ConsultationProduct::first();
        $custom = ConsultationCustomProduct::first();

        return view('pages.admin.settings.consultations.index', compact('general', 'product', 'custom'));
    }

    /**
     * Update General Consultation
     */
    public function updateGeneral(Request $request, $id)
    {
        $consultation = ConsultationGeneral::findOrFail($id);

        $validator = Validator::make($request->all(), [
            'phone_number' => 'required|string|max:20',
            'display_text' => 'required|string|max:100',
            'message_template' => 'nullable|string',
            'is_active' => 'boolean'
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput()
                ->with('tab', 'general');
        }

        try {
            $consultation->update([
                'phone_number' => $request->phone_number,
                'display_text' => $request->display_text,
                'message_template' => $request->message_template,
                'is_active' => $request->boolean('is_active')
            ]);

            return redirect()->route('admin.settings.consultations.index')
                ->with('success', 'General consultation settings updated successfully.');

        } catch (\Exception $e) {
            return redirect()->back()
                ->with('error', 'Failed to update: ' . $e->getMessage())
                ->withInput();
        }
    }

    /**
     * Update Product Consultation
     */
    public function updateProduct(Request $request, $id)
    {
        $consultation = ConsultationProduct::findOrFail($id);

        $validator = Validator::make($request->all(), [
            'phone_number' => 'required|string|max:20',
            'display_text' => 'required|string|max:100',
            'message_template' => 'nullable|string',
            'include_product_url' => 'boolean',
            'is_active' => 'boolean'
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput()
                ->with('tab', 'product');
        }

        try {
            $consultation->update([
                'phone_number' => $request->phone_number,
                'display_text' => $request->display_text,
                'message_template' => $request->message_template,
                'include_product_url' => $request->boolean('include_product_url'),
                'is_active' => $request->boolean('is_active')
            ]);

            return redirect()->route('admin.settings.consultations.index')
                ->with('success', 'Product consultation settings updated successfully.');

        } catch (\Exception $e) {
            return redirect()->back()
                ->with('error', 'Failed to update: ' . $e->getMessage())
                ->withInput();
        }
    }

    /**
     * Update Custom Product Consultation
     */
    public function updateCustom(Request $request, $id)
    {
        $consultation = ConsultationCustomProduct::findOrFail($id);

        $validator = Validator::make($request->all(), [
            'phone_number' => 'required|string|max:20',
            'display_text' => 'required|string|max:100',
            'message_template' => 'nullable|string',
            'is_active' => 'boolean'
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput()
                ->with('tab', 'custom');
        }

        try {
            $consultation->update([
                'phone_number' => $request->phone_number,
                'display_text' => $request->display_text,
                'message_template' => $request->message_template,
                'is_active' => $request->boolean('is_active')
            ]);

            return redirect()->route('admin.settings.consultations.index')
                ->with('success', 'Custom product consultation settings updated successfully.');

        } catch (\Exception $e) {
            return redirect()->back()
                ->with('error', 'Failed to update: ' . $e->getMessage())
                ->withInput();
        }
    }
}