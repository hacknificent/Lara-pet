<?php

namespace App\Http\Requests;

use App\Models\ProjectIdea;
use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Validation\Rule;

class UpdateProjectIdeaRequest extends ProjectIdeaRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        $is_update_status_ajax_request = $this->isMethod('patch') && $this->has('status') && ! $this->has('description');

        return array_merge($is_update_status_ajax_request ? [] : array_merge($this->titleRules(), $this->descriptionRules()), [
            'status' => ['required', 'integer', Rule::in(array_keys(ProjectIdea::STATUSES))],
            'order' => ['sometimes', 'numeric', 'min:0'],
        ]);
    }

    /**
     * @return array<string, string>
     */
    protected function customMessages(): array
    {
        return [
            'status.required' => 'The status is required.',
            'status.integer' => 'The status must be an integer.',
            'status.in' => 'The selected status is invalid.',
        ];
    }
}
