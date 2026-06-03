<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;

abstract class ProjectIdeaRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * @return array<string, ValidationRule|array<mixed>|string>
     */
    protected function descriptionRules(): array
    {
        return [
            'description' => ['nullable', 'string', 'min:3', 'max:1000'],
        ];
    }

    protected function titleRules(): array
    {
        return [
            'title' => ['required', 'string', 'min:3', 'max:255'],
        ];
    }

    /**
     * @return array<string, string>
     */
    public function messages(): array
    {
        return array_merge(
            $this->descriptionMessages(),
            $this->titleMessages(),
            $this->customMessages(),
        );
    }

    /**
     * @return array<string, string>
     */
    protected function titleMessages(): array
    {
        return [
            'title.required' => 'The idea title is required.',
            'title.string' => 'The idea title must be a string.',
            'title.min' => 'The idea title must be at least 3 characters long.',
            'title.max' => 'The idea title must be less than 255 characters long.',
        ];
    }

    /**
     * @return array<string, string>
     */
    protected function descriptionMessages(): array
    {
        return [
            // 'description.required' => 'The idea description is required.',
            'description.string' => 'The idea description must be a string.',
            'description.min' => 'The idea description must be at least 3 characters long.',
            'description.max' => 'The idea description must be less than 1000 characters long.',
        ];
    }

    /**
     * @return array<string, string>
     */
    protected function customMessages(): array
    {
        return [];
    }
}
