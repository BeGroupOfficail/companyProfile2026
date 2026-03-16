<?php

namespace App\Services\Dashboard\Seo;

use App\Models\Dashboard\Seo\CompanySeo;
use Illuminate\Support\Facades\DB;

class CompanySeoService
{
    public function getSeo()
    {
        // Use firstOrCreate to ensure a single record always exists
        return CompanySeo::firstOrCreate([]);
    }

    public function updateSeo(array $dataValidated)
    {
        DB::beginTransaction();

        try {
            $companySeo = $this->getSeo();

            $elementsToRemove = [
                'title_en', 'title_ar', 
                'author_en', 'author_ar', 
                'description_en', 'description_ar', 
                'canonical_en', 'canonical_ar',
                'hreflang_keys', 'hreflang_values',
                'schema'
            ];

            $data = array_diff_key($dataValidated, array_flip($elementsToRemove));

            if (!empty($dataValidated['schema'])) {
                $decodedSchema = json_decode($dataValidated['schema'], true);
                $data['schema'] = json_last_error() === JSON_ERROR_NONE ? $decodedSchema : null;
            } else {
                $data['schema'] = null;
            }

            $hreflangTags = [];
            if (!empty($dataValidated['hreflang_keys']) && !empty($dataValidated['hreflang_values'])) {
                foreach ($dataValidated['hreflang_keys'] as $index => $key) {
                    if (!empty($key)) {
                        $hreflangTags[$key] = $dataValidated['hreflang_values'][$index] ?? '';
                    }
                }
            }
            $data['hreflang_tags'] = !empty($hreflangTags) ? $hreflangTags : null;

            $companySeo->update($data);

            // Handle translations using the model trait
            $companySeo->handleTranslations(
                $dataValidated,
                ['title', 'author', 'description', 'canonical'],
                false // Don't generate slug
            );

            DB::commit();

            return $companySeo;
        } catch (\Exception $e) {
            DB::rollBack();
            throw $e;
        }
    }
}
