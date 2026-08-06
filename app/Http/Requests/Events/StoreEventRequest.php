<?php

namespace App\Http\Requests\Events;

use Illuminate\Foundation\Http\FormRequest;

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
     * Get the validation rules that apply to the request.
     */
    public function rules(): array
    {
        return [
            'nama_event' => 'required|string|max:255',
			'tanggal_mulai' => 'required',
			'tanggal_selesai' => 'required',
            'kode_sertifikat' => 'required|max:100',
			'template_sertifikat' => 'required|image|max:8000',
			'nama_ncs' => 'required|string|max:150',
			'callsign_ncs' => 'required|string|max:150',
			'poster' => 'required|image|max:8000',
        ];
    }
}

