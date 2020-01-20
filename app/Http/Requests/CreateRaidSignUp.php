<?php

namespace App\Http\Requests;

use App\Raiding\Raid;
use Illuminate\Validation\Rule;
use App\Blizzard\Warcraft\Classes;
use Illuminate\Foundation\Http\FormRequest;

class CreateRaidSignUp extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules(Classes $classes)
    {
        $classes = $classes->getClassicClasses(config('blizzard.faction'));

        return [
            'character_name' => 'required|string|max:12',
            'class_id' => [
                'required',
                Rule::in($classes->pluck('id')->toArray()),
            ],
            'role' => [
                'required',
                Rule::in(Raid::getAllowedRoles())
            ],
        ];
    }
}
