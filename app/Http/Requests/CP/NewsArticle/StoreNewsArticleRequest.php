<?php
namespace App\Http\Requests\CP\NewsArticle;

use App\Models\NewsArticle;
use Illuminate\Foundation\Http\FormRequest;

/**
 *
 */
class StoreNewsArticleRequest extends FormRequest
{
    /**
     * @return \string[][]
     */
    public function rules()
    {
        return NewsArticle::$RULES;
    }
    /**
     * Get the validated data from the request.
     *
     * @return array
     */
    public function validated()
    {
        $validated = parent::validated();
        return $validated;
    }
}
