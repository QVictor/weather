<?php

namespace App\Http\Requests;

use App\Models\OpenWeatherData;
use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;

class GetStatisticsRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    protected function prepareForValidation()
    {
        $this->merge([
            'city_id' => $this->route('cityId')
        ]);
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, ValidationRule|array|string>
     */
    public function rules(): array
    {
        return [
            'city_id' => 'required|exists:cities,open_weather_city_id',
            'group_by' => 'nullable|in:' . implode(',',OpenWeatherData::STATISTIC_GROUP_BY_NAMES)
        ];
    }
}
