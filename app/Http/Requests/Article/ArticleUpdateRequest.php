<?php

namespace App\Http\Requests\Article;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;
use App\Enums\ArticleStatus;
use App\Models\Article;
use Illuminate\Support\Str;
use App\Rules\ForbiddenWordsRule;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Http\Exceptions\HttpResponseException;

class ArticleUpdateRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */

        protected function prepareForValidation(): void
    {
        if ($this->has('title')) {
            
            $cleanedTitle = trim($this->title);
            $cleanedTitle = str_replace(['/', '\\'], '', $cleanedTitle);
            $cleanedTitle = preg_replace('/\s+/', ' ', $cleanedTitle);
            $cleanedTitle = Str::title($cleanedTitle);
            $this->merge([
                'title' => $cleanedTitle,
            ]);
        }
        
        if ($this->has('content')) {
            
            $cleanedContent = trim($this->content);
            $cleanedContent = str_replace(['/', '\\'], '', $cleanedContent);
            $cleanedContent = preg_replace('/\s+/', ' ', $cleanedContent);
            $this->merge([
                'content' => $cleanedContent,
            ]);
        }
    }
    
    public function authorize(): bool
    {
        $user = $this->user(); 

        if (!$user || $user->role !== 'writer') {
            return false;
        }
        return true;
        
    }

    public function rules(): array
    {
        return [
            'title' => ['sometimes','string','min:10',
                        'max:20','unique:articles,title', 
                        new ForbiddenWordsRule()
                        ],

            'content' => ['sometimes','string','min:100','max:500'
                            ,new ForbiddenWordsRule(),
                        ],

            'status'  => ['sometimes', Rule::enum(ArticleStatus::class)],
            'tags' => 'sometimes|array',
            'tags.*' => 'integer|distinct|exists:tags,id',
        ];
    }

    public function messages(): array
    {
        return [
            'title.min'      => 'The article title must be at least 10 characters long.',
            'title.unique'   => 'This title is already taken by another article. Please choose a unique title.',
            'content.min'    => 'The article content is too short. It must be at least 100 characters long.',
            'status.in'      => 'The provided status is invalid. It must be either: draft, published, or archived.',
            'tags.array'     => 'The tags must be submitted as an array.',
            'tags.*.distinct'=> 'Duplicate tags are not allowed for the same article.',
            'tags.*.exists'  => 'One or more of the selected tags do not exist in our system.',
        ];
    }

    protected function failedValidation(Validator $validator)
    {
        
        throw new HttpResponseException(
            response()->json([
                'status'    => 'custom_validation_error', 
                'message'   => 'The data provided did not pass our platform security checks.',
                'errors'    => $validator->errors(), 
                'meta'      => [
                    'timestamp' => now()->toIso8601String(),
                    'help'      => 'Please ensure no restricted terms are used in the title or content.'
                ]
            ], 422) 
        );
    }
}
