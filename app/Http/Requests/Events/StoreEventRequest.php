<?php

namespace App\Http\Requests\Events;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class StoreEventRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Prepare the data for validation.
     */
    protected function prepareForValidation(): void
    {
        $this->merge([
            'ada_sertifikat' => filter_var($this->input('ada_sertifikat', true), FILTER_VALIDATE_BOOLEAN),
        ]);
    }

    /**
     * Get the validation rules that apply to the request.
     */
    public function rules(): array
    {
        return [
            'nama_event' => 'required|string|max:255',
            'tanggal_mulai' => 'required',
            'tanggal_selesai' => 'required',
            'ada_sertifikat' => 'required|boolean',
            'kode_sertifikat' => [
                Rule::requiredIf(fn () => $this->boolean('ada_sertifikat')),
                'nullable',
                'max:100',
            ],
            'template_sertifikat' => [
                Rule::requiredIf(fn () => $this->boolean('ada_sertifikat')),
                'nullable',
                'image',
                'max:8000',
            ],
            'nama_ncs' => 'required|string|max:150',
            'callsign_ncs' => 'required|string|max:150',
            'poster' => 'required|image|max:8000',
        ];
    }
}
