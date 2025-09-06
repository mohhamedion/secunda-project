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

            'min_lat' => ['float'],
            'max_lat' => ['float'],
            'min_long' => ['float'],
            'max_long' => ['float'],

            'organisation_name' => ['string']
        ];
    }
}
