<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\Language\LanguageListResource;
use App\Services\Interfaces\LanguageServiceInterface;
use Illuminate\Http\Resources\Json\JsonResource;

/**
 * @group Languages
 */
class LanguageController extends Controller
{
    /**
     * @param LanguageServiceInterface $service
     */
    public function __construct(
        private LanguageServiceInterface $service
    )
    {
    }

    /**
     * List all languages supported by the API
     *
     * @return JsonResource
     *
     * @responseFile storage/responses/language/success.language.list.json
     */
    public function index(): JsonResource
    {
        return LanguageListResource::collection($this->service->all());
    }
}
