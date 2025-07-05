<?php

namespace App\Traits;

use App\Helper\Media;
use Illuminate\Support\Str;
use Illuminate\Http\Request;

trait HandlesTranslationsAndMedia
{
    /**
     * Handle translations for the model
     */
    public function handleTranslations(array $dataValidated, array $translatableFields = null, bool $autoGenerateSlug = true): self {

        $languages = array_keys(config('languages'));

        $translatableFields = $translatableFields ?? ['name', 'short_desc', 'long_desc', 'slug', 'meta_title', 'meta_desc'];

        foreach ($languages as $lang) {
            foreach ($translatableFields as $field) {
                $fieldKey = "{$field}_{$lang}";

                if (!isset($dataValidated[$fieldKey]) && $field !== 'slug') {
                    continue;
                }

                $value = $dataValidated[$fieldKey] ?? null;

                if ($field === 'slug' && $autoGenerateSlug && empty($value) && isset($dataValidated["name_{$lang}"])) {
                    $value = Str::slug($dataValidated["name_{$lang}"]);
                }

                if (!empty($value)){
                    $this->setTranslation($field, $lang, $value);
                }
            }
        }

        $this->save();
        return $this;
    }

    /**
     * Handle media uploads for the model
     */
    public function handleMedia(Request $request, array $dataValidated, string $mediaType, array $mediaFields = ['icon', 'image','banner','logo','dark_logo','white_logo','fav_icon','certificate_example']): self {
        foreach ($mediaFields as $field) {
            if ($request->hasFile($field)) {
                if ($this->{$field}) {
                    Media::removeFile($mediaType, $this->{$field});
                }
                Media::uploadAndAttachImages($dataValidated, $this, $mediaType);

                $altField = "alt_{$field}";
                if ($request->has($altField)) {
                    $this->{$altField} = $request->{$altField};
                }

                $this->save();
            }
        }
        return $this;
    }
}
