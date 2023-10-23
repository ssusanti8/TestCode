<?php

namespace App\Rules;

use Illuminate\Contracts\Validation\Rule;

class PdfRule implements Rule
{
    public function passes($attribute, $value)
    {
        // Check if the file is a PDF
        return $value->getClientOriginalExtension() === 'pdf';
    }

    public function message()
    {
        return 'The :attribute must be a PDF file.';
    }
}
