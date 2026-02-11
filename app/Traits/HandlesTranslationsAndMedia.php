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
    public function handleTranslations(array $dataValidated, array $translatableFields = null, bool $autoGenerateSlug = true): self
    {

        $languages = array_keys(config('languages'));
        $translatableFields = $translatableFields ?? ['name', 'short_desc', 'long_desc', 'slug','preparation_notes','aftercare_notes'];

        foreach ($languages as $lang) {
            foreach ($translatableFields as $field) {
                $fieldKey = "{$field}_{$lang}";

                if (!isset($dataValidated[$fieldKey]) && $field !== 'slug') {
                    $this->setTranslation($field, $lang, null);
                    continue;
                }
                $value = $dataValidated[$fieldKey] ?? null;

                if ($field === 'slug' && $autoGenerateSlug) {
                    if (empty($value) && isset($dataValidated["name_{$lang}"])) {
                        $value = $dataValidated["name_{$lang}"];
                    }

                    if (!empty($value)) {
                        // Replace spaces, slashes, and backslashes with a dash
                        $value = preg_replace('/[\/\\\\\s]+/u', '-', $value);

                        // Convert to lowercase
                        $value = mb_strtolower($value, 'UTF-8');

                        // Trim extra dashes from start/end
                        $value = trim($value, '-');
                    }
                }


                if (!is_null($value)) {
                    $this->setTranslation($field, $lang, $value);
                }
            }
        }

        $this->save();
        return $this;
    }

    public function handleMedia(
        Request $request,
        array $dataValidated,
        string $mediaType,
        array $mediaFields = ['icon', 'image','image_en', 'banner','banner_en', 'logo', 'dark_logo', 'white_logo', 'fav_icon', 'certificate_example']
    ): self {
        foreach ($mediaFields as $field) {
            $removeField = "{$field}_remove";

            // 1. Handle removal
            if ($request->has($removeField) && $request->input($removeField) == '1') {
                if ($this->{$field}) {
                    Media::removeFile($mediaType, $this->{$field});
                }
                $this->{$field} = null;

                $altField = "alt_{$field}";
                $this->{$altField} = null;

                $this->save();
            }
            // 2. Handle new file upload
            if ($request->hasFile($field)) {
                if ($this->{$field}) {
                    Media::removeFile($mediaType, $this->{$field});
                }
                Media::uploadAndAttachImages($dataValidated, $this, $mediaType);

                $altField = "alt_{$field}";
                if ($request->has($altField)) {
                    $this->{$altField} = $request->input($altField);
                }

                $this->save();
            }
            $altField = "alt_{$field}";
            if ($request->has($altField) && $this->{$field} && !$request->hasFile($field)) {
                $this->{$altField} = $request->input($altField);
                $this->save();
            }
        }

        return $this;
    }



}
