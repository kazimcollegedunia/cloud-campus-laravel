<?php

namespace App\Http\Requests\Api;

class FeeIndexRequest extends BaseQueryRequest
{
    protected function specificRules(): array
    {
        return [
            'class_id'   => ['nullable', 'integer'],
            'section_id' => ['nullable', 'integer'],
            'status'     => ['nullable', 'in:active,inactive'],
            'frequency'  => ['nullable', 'in:monthly,quarterly,yearly'],
        ];
    }
}
