<?php

namespace App\Services\Website;

use App\Models\Dashboard\Seo\Seo;
use App\Models\Dashboard\Setting\Setting;
use Mcamara\LaravelLocalization\Facades\LaravelLocalization;
use RalphJSmit\Laravel\SEO\Support\AlternateTag;
use RalphJSmit\Laravel\SEO\Support\SEOData;
use RalphJSmit\Laravel\SEO\SchemaCollection;

class SeoService
{
    protected array $pageTypes;
    protected array $schemaTypes;

    public function __construct()
    {
        $this->pageTypes = Seo::PAGETYPES;
        $this->schemaTypes = Seo::SCHEMATPES;
    }

    public function generateSeoData(string $pageType, array $additionalData = [], string $schemaType = null): SEOData
    {
        if (!array_key_exists($pageType, $this->pageTypes)) {
            throw new \InvalidArgumentException("Invalid page type: {$pageType}");
        }

        $baseData = $this->getBaseSeoData($pageType);

        // Merge base data with additional data
        $seoData = array_merge($baseData, $additionalData);

        // Generate schema collection if provided and valid
        $schemaCollection = null;
        if ($schemaType && array_key_exists($schemaType, $this->schemaTypes)) {
            $schemaCollection = $this->generateSchemaCollection($schemaType, $seoData);
            $seoData['schema'] = $schemaCollection;
        }

        // Pass individual parameters to SEOData constructor
        return new SEOData(...$seoData);
    }

    public function generateElementSeoData(array $elementData = [], string $schemaType = null): SEOData
    {
        if (!$elementData) {
            throw new \InvalidArgumentException("Seo Data not Passed to this view");
        }


        $seoData = [
            'title' => $elementData['title'] ,
            'description' => $elementData['description'],
            'image' => $elementData['image'],
            'url' =>$elementData['url'],
            'favicon' => $elementData['favicon'],
            // for href lang urls
            'alternates' => $this->generateElementAlternateTags($elementData['url']),
            'robots' => $elementData['robots']
        ];


        // Generate schema collection if provided and valid
        $schemaCollection = null;
        if ($schemaType && array_key_exists($schemaType, $this->schemaTypes)) {
            $schemaCollection = $this->generateSchemaCollection($schemaType, $seoData);
            $seoData['schema'] = $schemaCollection;
        }

        // Pass individual parameters to SEOData constructor
        return new SEOData(...$seoData);
    }


    protected function getBaseSeoData(string $pageType): array
    {
        $settings = Setting::firstOrFail();
        $seoDynamicData = Seo::where('page_type',$pageType)->firstOrFail();


        // Define base SEO data for each page type
        $baseData = [
            'title' => $seoDynamicData->meta_title ? $seoDynamicData->meta_title : config('app.name') . ' | ' . ucwords(str_replace('-', ' ', $pageType)),
            'description' => $seoDynamicData->meta_desc ? $seoDynamicData->meta_desc : $this->getDefaultDescription($pageType),

            'url' => $pageType === 'home'
                ? LaravelLocalization::getLocalizedURL(null, '/')
                : LaravelLocalization::getLocalizedURL(null, $pageType),

            'favicon' =>  \App\Helper\Path::uploadedImage('settings',$settings->fav_icon),

            // for href lang urls
            'alternates' => $this->generateAlternateTags($pageType),
            'robots' => ($seoDynamicData && $seoDynamicData->index == 1) ? 'index,follow' : 'noindex,nofollow'
        ];

        // Add page-specific defaults
        switch ($pageType) {
            case 'home':
                $baseData['image'] = \App\Helper\Path::uploadedImage('settings', $settings->logo);
                break;
            case 'about_us':
                $baseData['image'] = \App\Helper\Path::uploadedImage('settings', $settings->logo);
                break;
            case 'contact_us':
                $baseData['image'] = \App\Helper\Path::uploadedImage('settings', $settings->logo);
                break;
            case 'courses':
                $baseData['image'] = \App\Helper\Path::uploadedImage('settings', $settings->logo);
                break;
            case 'featured_courses':
                $baseData['image'] = \App\Helper\Path::uploadedImage('settings', $settings->logo);
                break;
            case 'my_courses':
                $baseData['image'] = \App\Helper\Path::uploadedImage('settings', $settings->logo);
                break;
            case 'my_trainings':
                $baseData['image'] = \App\Helper\Path::uploadedImage('settings', $settings->logo);
                break;
            case 'my_certificates':
                $baseData['image'] = \App\Helper\Path::uploadedImage('settings', $settings->logo);
                break;
            case 'my_orders':
                $baseData['image'] = \App\Helper\Path::uploadedImage('settings', $settings->logo);
                break;
            case 'wish_list':
                $baseData['image'] = \App\Helper\Path::uploadedImage('settings', $settings->logo);
                break;
            case 'cart':
                $baseData['image'] = \App\Helper\Path::uploadedImage('settings', $settings->logo);
                break;
            case 'categories':
                $baseData['image'] = \App\Helper\Path::uploadedImage('settings', $settings->logo);
                break;
            case 'blogs':
                $baseData['image'] = \App\Helper\Path::uploadedImage('settings', $settings->logo);
                break;
            case 'profile':
                $baseData['image'] = \App\Helper\Path::uploadedImage('settings', $settings->logo);
                break;
            case 'account_settings':
                $baseData['image'] = \App\Helper\Path::uploadedImage('settings', $settings->logo);
                break;
            case 'certificate_verfication':
                $baseData['image'] = \App\Helper\Path::uploadedImage('settings', $settings->logo);
                break;
            case 'fields':
                $baseData['image'] = \App\Helper\Path::uploadedImage('settings', $settings->logo);
                break;
            case 'album_images':
                $baseData['image'] = \App\Helper\Path::uploadedImage('settings', $settings->logo);
                break;
            case 'album_videos':
                $baseData['image'] = \App\Helper\Path::uploadedImage('settings', $settings->logo);
                break;
            case 'login':
                $baseData['image'] = \App\Helper\Path::uploadedImage('settings', $settings->logo);
                break;
            case 'register':
                $baseData['image'] = \App\Helper\Path::uploadedImage('settings', $settings->logo);
                break;
            case 'instructors':
                $baseData['image'] = \App\Helper\Path::uploadedImage('settings', $settings->logo);
                break;
            default:
                // Fallback image for any unhandled page types
                $baseData['image'] = \App\Helper\Path::uploadedImage('settings', $settings->logo);
                break;
        }

        return $baseData;
    }

    protected function getDefaultDescription(string $pageType): string
    {
        $descriptions = [
            'home' => 'Welcome to ' . config('app.name') . ' - Your premier destination for  a quality.',
            'about-us' => 'Learn more about ' . config('app.name') . ' and our mission to provide excellent for you.',
            'contact-us' => 'Get in touch with ' . config('app.name') . ' for any inquiries or support.',
            'courses' => 'Browse our wide range of courses at ' . config('app.name') . '.',
            'categories' => 'Explore course categories at ' . config('app.name') . '.',
            'blogs' => 'Explore course blogs at ' . config('app.name') . '.',
            // add other pages if you want :)
        ];

        return $descriptions[$pageType] ?? 'Discover more at ' . config('app.name');
    }


    protected function generateAlternateTags(string $pageType): array
    {
        $alternates = [];
        $languages = config('languages'); // Default to English if no config

        // Add x-default (points to default language)
        $defaultUrl = $pageType === 'home' ? '/' : $pageType;
        $alternates[] = new AlternateTag(
            hreflang: 'x-default',
            href: LaravelLocalization::localizeUrl($defaultUrl)
        );

        // Add other languages
        foreach ($languages as $langCode => $language) {
            $url = $pageType === 'home' ? '/' : $pageType;
            $alternates[] = new AlternateTag(
                hreflang: $langCode,
                href: LaravelLocalization::localizeUrl($url, $langCode)
            );
        }

        return $alternates;
    }


    protected function generateElementAlternateTags($url): array
    {
        $alternates = [];
        $languages = config('languages'); // Default to English if no config

        // Add x-default (points to default language)
        $defaultUrl = $url;
        $alternates[] = new AlternateTag(
            hreflang: 'x-default',
            href: LaravelLocalization::localizeUrl($defaultUrl)
        );

        // Add other languages
        foreach ($languages as $langCode => $language) {
            $alternates[] = new AlternateTag(
                hreflang: $langCode,
                href: LaravelLocalization::localizeUrl($url, $langCode)
            );
        }

        return $alternates;
    }

    protected function generateSchemaCollection(string $schemaType, array $data): SchemaCollection
    {
        switch ($schemaType) {
            case 'FAQPage':
                return $this->generateFAQSchema($data);
            default:
                return SchemaCollection::make();
        }
    }

    protected function generateFAQSchema(array $data): SchemaCollection
    {
        return SchemaCollection::make()
            ->add(function (SEOData $SEOData) use ($data) {
                // You can customize this to accept dynamic FAQs from $data
                return [
                    '@context' => 'https://schema.org',
                    '@type' => 'FAQPage',
                    'mainEntity' => [
                        [
                            '@type' => 'Question',
                            'name' => $data['faq_question'] ?? 'Your question goes here',
                            'acceptedAnswer' => [
                                '@type' => 'Answer',
                                'text' => $data['faq_answer'] ?? 'Your answer goes here',
                            ],
                        ],
                        // Add more questions as needed
                    ],
                ];
            });
    }
}
