<?php

namespace Database\Seeders;

use App\Models\Dashboard\About\AboutUs;
use App\Models\Dashboard\Project\Project;
use App\Models\Dashboard\Project\ProjectImage;
use App\Models\Dashboard\Sections\CompanySection;
use App\Models\Dashboard\Sections\CompanySubSection;
use App\Models\Dashboard\Sections\CompanySubSectionItem;
use App\Models\Dashboard\Seo\CompanySeo;
use App\Models\Dashboard\Service\Service;
use App\Models\Dashboard\Setting\Setting;
use App\Models\Dashboard\Slider\Slider;
use App\Models\Dashboard\WebsiteStatistics\WebsiteStatistics;
use Illuminate\Database\Seeder;

class CompanyHomeSeeder extends Seeder
{
    const IMAGE = 'https://img.freepik.com/free-photo/low-angle-view-skyscrapers_1359-1105.jpg?semt=ais_hybrid&w=740&q=80';

    public function run(): void
    {
        $this->seedSettings();
        $this->seedSliders();
        $this->seedAbout();
        $this->seedStatistics();
        $this->seedServices();
        $this->seedSections();
        $this->seedProjects();
        $this->seedSeo();
    }

    // ─── Settings (contact + social) ─────────────────────────────────
    private function seedSettings(): void
    {
        $settings = Setting::updateOrCreate(
            ['id' => 1],
            [
                'phone1'            => '01120149797',
                'contact_email'     => 'Info@koia-eg.com',
                'address1'          => 'zahraa nasr city - Build 2013 - office no 1 - in front of jewel sport city Hotel',
                'address_en_1'      => 'zahraa nasr city - Build 2013 - office no 1 - in front of jewel sport city Hotel',
                'facebook_address'  => 'https://facebook.com/koia-eg',
                'twitter_address'   => 'https://twitter.com/koia-eg',
                'instagram_address' => 'https://instagram.com/koia-eg',
                'linkedin_address'  => 'https://linkedin.com/company/koia-eg',
                'youtube_address'   => 'https://youtube.com/@koia-eg',
                'whatsapp_address'  => 'https://wa.me/201120149797',
                'tiktok_address'    => 'https://tiktok.com/@koia-eg',
                'snapchat_address'  => 'https://snapchat.com/add/koia-eg',
                'threads_address'   => 'https://threads.net/@koia-eg',
                'pinterest_address' => 'https://pinterest.com/koia-eg',
            ]
        );

        // Handle translatable fields the same way other seeders do
        $settings->handleTranslations([
            'site_name_en' => 'KOIA',
            'site_name_ar' => 'كويا',
            'site_desc_en' => 'Controlled execution, Deadline driven delivery',
            'site_desc_ar' => 'تنفيذ منضبط وتسليم في الموعد المحدد',
        ], ['site_name', 'site_desc'], false);
    }

    // ─── Sliders ─────────────────────────────────────────────────────
    private function seedSliders(): void
    {
        $sloganEn = 'Controlled execution. Deadline driven delivery.';
        $sloganAr  = 'تنفيذ دقيق. تسليم في الموعد.';

        for ($i = 1; $i <= 4; $i++) {
            Slider::create([
                'title'     => "KOIA - Slide {$i}",
                'text'      => $i % 2 === 0 ? $sloganAr : $sloganEn,
                'link'      => 'https://koia-eg.com',
                'lang'      => $i % 2 === 0 ? 'ar' : 'en',
                'status'    => 'published',
                'image'     => self::IMAGE,
                'alt_image' => 'KOIA corporate interior slide ' . $i,
                'order'     => $i,
            ]);
        }
    }

    // ─── About ───────────────────────────────────────────────────────
    private function seedAbout(): void
    {
        $about = AboutUs::create([
            'image'    => self::IMAGE,
            'alt_image' => 'KOIA about us visual',
        ]);

        $about->handleTranslations([
            'title_en'       => 'KOIA Built for Business Not Just Interiors',
            'title_ar'       => 'كويا .. مبنية للأعمال وليس فقط للديكور',
            'description_en' => 'KOIA specializes in performance driven commercial environments corporate offices, medical facilities, and retail commercial spaces where compliance, precision, and operational readiness are critical We Deliver with Confidence',
            'description_ar' => 'تتخصص كويا في البيئات التجارية عالية الأداء — المكاتب، المنشآت الطبية، والفضاءات التجارية حيث الدقة والجاهزية التشغيلية أمر بالغ الأهمية. نحن نسلّم بثقة.',
            'badges_en'      => 'QUALITY-CLARITY-TIME SAVING',
            'badges_ar'      => 'الجودة-الوضوح-توفير الوقت',
        ], ['title', 'description', 'badges'], false);
    }

    // ─── Statistics ──────────────────────────────────────────────────
    private function seedStatistics(): void
    {
        $stats = [
            ['en' => 'Projects Delivered',       'ar' => 'مشاريع منجزة',          'count' => '50'],
            ['en' => 'Collaborations',            'ar' => 'شراكات',                'count' => '145'],
            ['en' => 'Business Clients Reached',  'ar' => 'عملاء أعمال وصلنا إليهم', 'count' => '300'],
            ['en' => 'Projects Per Year',         'ar' => 'مشاريع سنوياً',         'count' => '8'],
        ];

        foreach ($stats as $stat) {
            $record = WebsiteStatistics::create([
                'count'  => $stat['count'],
                'status' => 'published',
            ]);
            $record->handleTranslations([
                'title_en' => $stat['en'],
                'title_ar' => $stat['ar'],
            ], ['title'], false);
        }
    }

    // ─── Services ────────────────────────────────────────────────────
    private function seedServices(): void
    {
        $services = [
            [
                'en' => ['name' => 'Corporate',    'short_desc' => 'High-performance corporate office environments built for productivity, compliance, and executive-ready delivery.'],
                'ar' => ['name' => 'مكاتب شركات',   'short_desc' => 'بيئات مكتبية عالية الأداء مصممة للإنتاجية والامتثال والتسليم الجاهز.'],
            ],
            [
                'en' => ['name' => 'Commercial',   'short_desc' => 'Retail and commercial spaces designed for operational readiness and brand impact.'],
                'ar' => ['name' => 'تجاري',          'short_desc' => 'مساحات بيع بالتجزئة وتجارية مصممة للجاهزية التشغيلية وتأثير العلامة التجارية.'],
            ],
            [
                'en' => ['name' => 'Medical',      'short_desc' => 'Medical facilities built to the highest compliance standards with functional precision.'],
                'ar' => ['name' => 'طبي',            'short_desc' => 'منشآت طبية مبنية وفق أعلى معايير الامتثال بدقة وظيفية.'],
            ],
            [
                'en' => ['name' => 'Residential',  'short_desc' => 'Premium residential interiors that balance aesthetics with quality and timely delivery.'],
                'ar' => ['name' => 'سكني',           'short_desc' => 'ديكورات داخلية سكنية متميزة تجمع بين الجماليات والجودة والتسليم في الموعد.'],
            ],
        ];

        foreach ($services as $i => $svc) {
            $record = Service::create([
                'image'  => self::IMAGE,
                'status' => 'published'
            ]);

            $record->handleTranslations([
                'name_en'       => $svc['en']['name'],
                'name_ar'       => $svc['ar']['name'],
                'short_desc_en' => $svc['en']['short_desc'],
                'short_desc_ar' => $svc['ar']['short_desc'],
                'slug_en'       => \Illuminate\Support\Str::slug($svc['en']['name']),
                'slug_ar'       => \Illuminate\Support\Str::slug($svc['ar']['name']),
            ], ['name', 'short_desc', 'slug'], false);
        }
    }

    // ─── Sections ────────────────────────────────────────────────────
    private function seedSections(): void
    {
        $section = CompanySection::create([
            'key'       => 'executions',
            'is_active' => 1,
            'sort_order' => 1,
        ]);

        $section->handleTranslations([
            'title_en'       => 'How We Execute',
            'title_ar'       => 'كيف ننفّذ',
            'description_en' => 'Our execution standards define every project we deliver from start to handover.',
            'description_ar' => 'معايير التنفيذ لدينا تحدد كل مشروع نسلّمه من البداية حتى التسليم.',
        ], ['title', 'description'], false);

        $subSections = [
            [
                'title'       => ['en' => 'Standards',                      'ar' => 'المعايير'],
                'description' => ['en' => 'Execution Standard',             'ar' => 'معيار التنفيذ'],
                'layout'      => 'title_desc',
                'items' => [
                    ['en' => ['title' => 'Deadline Precision',          'description' => 'Every deliverable is tied to a strict timeline with zero tolerance for drift.'],
                     'ar' => ['title' => 'دقة المواعيد النهائية',         'description' => 'كل مخرج مرتبط بجدول زمني صارم دون تسامح مع الانحراف.']],
                    ['en' => ['title' => 'Scope Control',               'description' => 'We define every boundary before work begins to prevent creep and cost overrun.'],
                     'ar' => ['title' => 'التحكم في النطاق',              'description' => 'نحدد كل حد قبل بدء العمل لمنع التمدد وتجاوز التكاليف.']],
                    ['en' => ['title' => 'Structured Reporting',        'description' => 'Clients receive regular status updates to maintain full visibility throughout.'],
                     'ar' => ['title' => 'التقارير المنظمة',              'description' => 'يتلقى العملاء تحديثات منتظمة للحفاظ على الرؤية الكاملة طوال المشروع.']],
                ],
            ],
            [
                'title'       => ['en' => 'Step-by-Step Execution',         'ar' => 'التنفيذ خطوة بخطوة'],
                'description' => ['en' => 'A clear phased approach to delivery', 'ar' => 'نهج واضح متعدد المراحل للتسليم'],
                'layout'      => 'title_desc',
                'items' => [
                    ['en' => ['title' => 'Phase 1 - Briefing & Scope',  'description' => 'We align with the client on objectives, constraints, and timeline.'],
                     'ar' => ['title' => 'المرحلة 1 - الإحاطة والنطاق',  'description' => 'نتوافق مع العميل على الأهداف والقيود والجدول الزمني.']],
                    ['en' => ['title' => 'Phase 2 - Design Execution',  'description' => 'Technical drawings and compliance-backed design are finalized.'],
                     'ar' => ['title' => 'المرحلة 2 - تنفيذ التصميم',    'description' => 'يتم إنهاء الرسومات التقنية والتصميم المتوافق مع المعايير.']],
                    ['en' => ['title' => 'Phase 3 - Site Handover',     'description' => 'Punch list cleared and final handover documentation delivered.'],
                     'ar' => ['title' => 'المرحلة 3 - تسليم الموقع',     'description' => 'تم مسح قائمة الملاحظات وتسليم وثائق التسليم النهائي.']],
                ],
            ],
            [
                'title'       => ['en' => 'Our Quality Control Process',     'ar' => 'عملية ضبط جودتنا'],
                'description' => ['en' => 'Zero-defect delivery framework',  'ar' => 'إطار التسليم بدون عيوب'],
                'layout'      => 'title_desc',
                'items' => [
                    ['en' => ['title' => 'Material Verification',       'description' => 'All materials are checked against spec before use on site.'],
                     'ar' => ['title' => 'التحقق من المواد',             'description' => 'يتم فحص جميع المواد مقابل المواصفات قبل الاستخدام في الموقع.']],
                    ['en' => ['title' => 'On-Site Inspections',         'description' => 'Structured inspections are run at every major milestone.'],
                     'ar' => ['title' => 'الفحوصات الميدانية',            'description' => 'يتم إجراء فحوصات منظمة عند كل معلم رئيسي.']],
                    ['en' => ['title' => 'Client Sign-Off Protocol',    'description' => 'No phase closes without a formal client sign-off.'],
                     'ar' => ['title' => 'بروتوكول موافقة العميل',        'description' => 'لا تُغلق أي مرحلة دون موافقة رسمية من العميل.']],
                ],
            ],
            [
                'title'       => ['en' => 'How We Control Project Risks',    'ar' => 'كيف ندير مخاطر المشاريع'],
                'description' => ['en' => 'Proactive risk management',       'ar' => 'إدارة المخاطر بشكل استباقي'],
                'layout'      => 'title_desc',
                'items' => [
                    ['en' => ['title' => 'Early Risk Identification',   'description' => 'We map risks at project start before they can become blockers.'],
                     'ar' => ['title' => 'التعرف المبكر على المخاطر',    'description' => 'نخطط للمخاطر في بداية المشروع قبل أن تصبح عوائق.']],
                    ['en' => ['title' => 'Contingency Planning',        'description' => 'Documented backup plans are in place for all critical path items.'],
                     'ar' => ['title' => 'تخطيط الطوارئ',               'description' => 'خطط احتياطية موثقة لجميع بنود المسار الحرج.']],
                    ['en' => ['title' => 'Transparent Escalation',      'description' => 'Issues are communicated to clients immediately with proposed resolutions.'],
                     'ar' => ['title' => 'التصعيد الشفاف',              'description' => 'يتم إبلاغ العملاء بالمشاكل فوراً مع الحلول المقترحة.']],
                ],
            ],
        ];

        foreach ($subSections as $i => $sub) {
            $subRecord = CompanySubSection::create([
                'section_id' => $section->id,
                'layout'     => $sub['layout'],
                'sort_order' => $i + 1
            ]);

            $subRecord->handleTranslations([
                'title_en'       => $sub['title']['en'],
                'title_ar'       => $sub['title']['ar'],
                'description_en' => $sub['description']['en'],
                'description_ar' => $sub['description']['ar'],
            ], ['title', 'description'], false);

            foreach ($sub['items'] as $j => $item) {
                $itemRecord = CompanySubSectionItem::create([
                    'sub_section_id' => $subRecord->id,
                    'sort_order'     => $j + 1,
                ]);

                $itemRecord->handleTranslations([
                    'title_en'       => $item['en']['title'],
                    'title_ar'       => $item['ar']['title'],
                    'description_en' => $item['en']['description'],
                    'description_ar' => $item['ar']['description'],
                ], ['title', 'description'], false);
            }
        }
    }

    // ─── Projects ────────────────────────────────────────────────────
    private function seedProjects(): void
    {
        $projects = [
            [
                'en' => ['name' => 'Al Nour Corporate Tower',  'short_desc' => 'A 4-floor corporate interior fit-out delivered in 90 days with full compliance sign-off.',      'badges' => 'Corporate-Office-Cairo'],
                'ar' => ['name' => 'برج النور للأعمال',         'short_desc' => 'تجديد داخلي لأربعة طوابق مكتبية تم تسليمه في 90 يوماً مع اعتماد الامتثال الكامل.',             'badges' => 'شركات-مكتب-القاهرة'],
            ],
            [
                'en' => ['name' => 'MedCare Clinic - Nasr City', 'short_desc' => 'Medical-grade fit-out for a multi-specialty clinic including sterilization zones and patient flow.', 'badges' => 'Medical-Clinic-Healthcare'],
                'ar' => ['name' => 'عيادة ميدكير - مدينة نصر',   'short_desc' => 'تجهيز طبي المستوى لعيادة متعددة التخصصات يشمل مناطق التعقيم وتدفق المرضى.',                 'badges' => 'طبي-عيادة-رعاية صحية'],
            ],
            [
                'en' => ['name' => 'Horizon Retail Boulevard',  'short_desc' => 'Commercial fit-out for a flagship retail brand covering 2,400 sqm with operational handover in 60 days.', 'badges' => 'Retail-Commercial-Flagship'],
                'ar' => ['name' => 'بوليفارد هورايزون للتجزئة',  'short_desc' => 'تجهيز تجاري لعلامة تجزئة رائدة يغطي 2400 متر مربع مع تسليم تشغيلي في 60 يوماً.',            'badges' => 'تجزئة-تجاري-رئيسي'],
            ],
            [
                'en' => ['name' => 'Executive Residences - New Cairo', 'short_desc' => 'Premium residential compound interior covering 8 units delivered ahead of schedule.',           'badges' => 'Residential-Premium-New Cairo'],
                'ar' => ['name' => 'المجمع السكني التنفيذي - القاهرة الجديدة', 'short_desc' => 'ديكور داخلي فاخر لمجمع سكني يضم 8 وحدات سُلّم قبل الموعد المحدد.',                'badges' => 'سكني-فاخر-القاهرة الجديدة'],
            ],
        ];

        foreach ($projects as $i => $proj) {
            $record = Project::create([
                'status'     => 'published'
            ]);

            $record->handleTranslations([
                'name_en'       => $proj['en']['name'],
                'name_ar'       => $proj['ar']['name'],
                'short_desc_en' => $proj['en']['short_desc'],
                'short_desc_ar' => $proj['ar']['short_desc'],
                'badges_en'     => $proj['en']['badges'],
                'badges_ar'     => $proj['ar']['badges'],
                'slug_en'       => \Illuminate\Support\Str::slug($proj['en']['name']),
                'slug_ar'       => \Illuminate\Support\Str::slug($proj['ar']['name']),
            ], ['name', 'short_desc', 'badges', 'slug'], false);

            // Featured project image
            ProjectImage::create([
                'project_id'  => $record->id,
                'image'       => self::IMAGE,
                'alt'         => $proj['en']['name'],
                'sort_order'  => 1,
                'is_featured' => true,
            ]);
        }
    }

    // ─── Company SEO ─────────────────────────────────────────────────
    private function seedSeo(): void
    {
        $seo = CompanySeo::firstOrCreate([]);

        $seo->update([
            'content_type' => 'text/html',
            'robots'       => 'index,follow',
            'open_graph'   => [
                'og:type'        => 'website',
                'og:url'         => 'https://koia-eg.com',
                'og:image'       => self::IMAGE,
                'og:title'       => 'KOIA – Performance-Driven Commercial Interiors',
                'og:description' => 'KOIA specializes in corporate offices, medical facilities, and retail commercial environments. Deadline driven. Compliance backed.',
            ],
            'twitter_card' => [
                'twitter:card'        => 'summary_large_image',
                'twitter:image'       => self::IMAGE,
                'twitter:title'       => 'KOIA – Performance-Driven Commercial Interiors',
                'twitter:description' => 'We deliver structured interior projects with operational precision.',
            ],
            'hreflang_tags' => [
                'en'        => '/en',
                'ar'        => '/ar',
                'x-default' => '/',
            ],
            'schema' => [
                [
                    '@context' => 'https://schema.org',
                    '@type'    => 'Organization',
                    'name'     => 'KOIA',
                    'url'      => 'https://koia-eg.com',
                    'logo'     => self::IMAGE,
                    'contactPoint' => [
                        '@type'             => 'ContactPoint',
                        'telephone'         => '+201120149797',
                        'contactType'       => 'customer service',
                    ],
                ],
            ],
        ]);

        $seo->handleTranslations([
            'title_en'       => 'KOIA – Performance-Driven Commercial Interiors',
            'title_ar'       => 'كويا – ديكورات تجارية عالية الأداء',
            'author_en'      => 'KOIA Design & Build',
            'author_ar'      => 'كويا للتصميم والبناء',
            'description_en' => 'KOIA specializes in performance driven commercial environments — corporate offices, medical facilities, and retail spaces. Compliance, precision, and on-time delivery.',
            'description_ar' => 'تتخصص كويا في البيئات التجارية الموجهة للأداء — المكاتب والمنشآت الطبية والمساحات التجارية. الامتثال والدقة والتسليم في الوقت المحدد.',
            'canonical_en'   => 'https://koia-eg.com/en',
            'canonical_ar'   => 'https://koia-eg.com/ar',
        ], ['title', 'author', 'description', 'canonical'], false);
    }
}
