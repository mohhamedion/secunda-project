<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class OrganisationIndexRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }


    public function rules(): array
    {
        return [
            'building_id' => ['integer'],
            'activity_id' => ['integer'],

            'min_lat' => ['numeric'],
            'max_lat' => ['numeric'],
            'min_long' => ['numeric'],
            'max_long' => ['numeric'],

            'organisation_name' => ['string']
        ];
    }
}
