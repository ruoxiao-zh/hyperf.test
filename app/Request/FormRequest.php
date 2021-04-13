<?php

declare(strict_types=1);

namespace App\Request;

use App\Request\Traits\RequestHelper;
use Hyperf\Validation\Request\FormRequest as BaseFormRequest;

class FormRequest extends BaseFormRequest
{
    use RequestHelper;

    public function authorize(): bool
    {
        return true;
    }
}
