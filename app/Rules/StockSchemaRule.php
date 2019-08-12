<?php

namespace App\Rules;

use JsonSchema\Validator;
use App\Schemas\StockUpdateSchema;
use Illuminate\Contracts\Validation\Rule;

class StockSchemaRule implements Rule
{
    protected $schema = [
        'banker_name',
        'is_in_bags',
        'bag_number',
        'slot_number',
        'item',
        'count',
    ];

    protected $validator;

    /**
     * Create a new rule instance.
     *
     * @return void
     */
    public function __construct(Validator $validator)
    {
        $this->validator = $validator;
    }

    /**
     * Determine if the validation rule passes.
     *
     * @param  string  $attribute
     * @param  mixed  $value
     * @return bool
     */
    public function passes($attribute, $value)
    {
        $decoded = json_decode($value);

        $this->validator->validate($decoded, (new StockUpdateSchema)->decode());

        return $this->validator->isValid();
    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message()
    {
        return (object) [
            'message' => 'The uploaded stock does not match the required schema.',
            'detail'  => $this->validator->getErrors()
        ];
    }
}
