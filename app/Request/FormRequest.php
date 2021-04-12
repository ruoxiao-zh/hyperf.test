<?php

declare(strict_types=1);

namespace App\Request;

use Hyperf\Validation\Request\FormRequest as BaseFormRequest;

class FormRequest extends BaseFormRequest
{
    public function authorize(): bool
    {
        return true;
    }
}
