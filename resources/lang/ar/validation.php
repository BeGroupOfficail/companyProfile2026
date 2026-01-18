<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Validation Language Lines
    |--------------------------------------------------------------------------
    |
    | The following language lines contain the default error messages used by
    | the validator class. Some of these rules have multiple versions such
    | as the size rules. Feel free to tweak each of these messages here.
    |
    */


    'accepted' => 'يجب قبول :attribute.',
    'accepted_if' => 'يجب قبول :attribute عندما يكون :other هو :value.',
    'active_url' => 'يجب أن يكون :attribute رابطًا صالحًا.',
    'after' => 'يجب أن يكون :attribute تاريخًا بعد :date.',
    'after_or_equal' => 'يجب أن يكون :attribute تاريخًا بعد أو يساوي :date.',
    'alpha' => 'يجب أن يحتوي :attribute على حروف فقط.',
    'alpha_dash' => 'يجب أن يحتوي :attribute على حروف، أرقام، شرطات وشرطات سفلية فقط.',
    'alpha_num' => 'يجب أن يحتوي :attribute على حروف وأرقام فقط.',
    'array' => 'يجب أن يكون :attribute مصفوفة.',
    'ascii' => 'يجب أن يحتوي :attribute على رموز وحروف أبجدية رقمية أحادية البايت فقط.',
    'before' => 'يجب أن يكون :attribute تاريخًا قبل :date.',
    'before_or_equal' => 'يجب أن يكون :attribute تاريخًا قبل أو يساوي :date.',
    'between' => [
        'array' => 'يجب أن يحتوي :attribute على بين :min و :max عناصر.',
        'file' => 'يجب أن يكون حجم :attribute بين :min و :max كيلوبايت.',
        'numeric' => 'يجب أن يكون :attribute بين :min و :max.',
        'string' => 'يجب أن يكون طول :attribute بين :min و :max حروف.',
    ],
    'boolean' => 'يجب أن يكون :attribute إما صحيحًا أو خطأ.',
    'confirmed' => 'تأكيد :attribute غير متطابق.',
    'date' => 'يجب أن يكون :attribute تاريخًا صالحًا.',
    'date_equals' => 'يجب أن يكون :attribute تاريخًا مساويًا لـ :date.',
    'date_format' => 'يجب أن يكون :attribute مطابقًا للتنسيق :format.',
    'different' => 'يجب أن يكون :attribute و :other مختلفين.',
    'digits' => 'يجب أن يحتوي :attribute على :digits أرقام.',
    'digits_between' => 'يجب أن يكون :attribute بين :min و :max أرقام.',
    'email' => 'يجب أن يكون :attribute عنوان بريد إلكتروني صالحًا.',
    'exists' => 'القيمة المحددة لـ :attribute غير صالحة.',
    'file' => 'يجب أن يكون :attribute ملفًا.',
    'image' => 'يجب أن يكون :attribute صورة.',
    'in' => 'القيمة المحددة لـ :attribute غير صالحة.',
    'integer' => 'يجب أن يكون :attribute عددًا صحيحًا.',
    'max' => [
        'array' => 'يجب ألا يحتوي :attribute على أكثر من :max عناصر.',
        'file' => 'يجب ألا يكون حجم :attribute أكبر من :max كيلوبايت.',
        'numeric' => 'يجب ألا يكون :attribute أكبر من :max.',
        'string' => 'يجب ألا يكون طول :attribute أكبر من :max أحرف.',
    ],
    'min' => [
        'array' => 'يجب أن يحتوي :attribute على الأقل على :min عناصر.',
        'file' => 'يجب أن يكون حجم :attribute على الأقل :min كيلوبايت.',
        'numeric' => 'يجب أن يكون :attribute على الأقل :min.',
        'string' => 'يجب أن يكون طول :attribute على الأقل :min أحرف.',
    ],
    'numeric' => 'يجب أن يكون :attribute رقمًا.',
    'password' => 'كلمة المرور غير صحيحة.',
    'regex' => 'تنسيق :attribute غير صالح.',
    'required' => ':attribute مطلوب.',
    'same' => 'يجب أن يتطابق :attribute مع :other.',
    'size' => [
        'array' => 'يجب أن يحتوي :attribute على :size عناصر.',
        'file' => 'يجب أن يكون حجم :attribute :size كيلوبايت.',
        'numeric' => 'يجب أن يكون :attribute :size.',
        'string' => 'يجب أن يكون طول :attribute :size أحرف.',
    ],
    'string' => 'يجب أن يكون :attribute نصًا.',
    'unique' => 'تم استخدام :attribute بالفعل.',
    'url' => 'يجب أن يكون :attribute رابطًا صالحًا.',
    'uuid' => 'يجب أن يكون :attribute معرف UUID صالحًا.',
    'instructor_bag_file_file' => 'يجب أن يكون الملف الخاص بالمدرب ملفًا صالحًا.',
    'instructor_bag_file_mimes' => 'يجب أن يكون الملف الخاص بالمدرب من نوع: pdf, doc, docx, xlsx, xls, csv, ppt, pptx.',
    'instructor_bag_file_min' => 'يجب ألا يقل حجم الملف الخاص بالمدرب عن 3.5 ميجابايت.',
    'instructor_bag_file_max' => 'يجب ألا يزيد حجم الملف الخاص بالمدرب عن 12 ميجابايت.',

    'student_bag_file_file' => 'يجب أن يكون الملف الخاص بالطالب ملفًا صالحًا.',
    'student_bag_file_mimes' => 'يجب أن يكون الملف الخاص بالطالب من نوع: pdf, doc, docx, xlsx, xls, csv, ppt, pptx.',
    'student_bag_file_min' => 'يجب ألا يقل حجم الملف الخاص بالطالب عن 3.5 ميجابايت.',
    'student_bag_file_max' => 'يجب ألا يزيد حجم الملف الخاص بالطالب عن 12 ميجابايت.',
    'The number of days cannot exceed the date range of the course.' => 'عدد الأيام لا يمكن أن يتجاوز نطاق تواريخ  شرح الدورة.',
    'The end time must be after the start time.' => 'يجب أن يكون وقت انتهاء اليوم بعد وقت البدء.',
    'The day date must be within the course start and end date.' => 'يجب أن يكون تاريخ اليوم ضمن تاريخ بدء وانتهاء شرح الدورة.',
    'The end time must be after start time.' => 'تاريخ النهاية يجب ان يكون بعد تاريخ البداية',
    'training_courses' => [
        'required' => 'يجب إضافة دورة تدريبية واحدة على الأقل.',
        'array' => 'يجب أن تكون الدورات التدريبية في شكل مصفوفة.',

        'course_id' => [
            'required' => 'يجب اختيار الدورة التدريبية.',
            'exists' => 'الدورة التدريبية المختارة غير موجودة.',
        ],

        'start_date' => [
            'required' => 'يجب تحديد تاريخ بداية الدورة.',
            'date' => 'تاريخ البداية يجب أن يكون تاريخًا صالحًا.',
        ],

        'end_date' => [
            'required' => 'يجب تحديد تاريخ نهاية الدورة.',
            'date' => 'تاريخ النهاية يجب أن يكون تاريخًا صالحًا.',
            'after_or_equal' => 'تاريخ النهاية يجب أن يكون بعد أو يساوي تاريخ البداية.',
        ],

        'bag_ids' => [
            'array' => 'يجب أن تكون الحقائب في شكل مصفوفة.',
            'integer' => 'يجب أن تكون معرفات الحقائب أرقامًا صحيحة.',
            'exists' => 'إحدى الحقائب المختارة غير موجودة.',
        ],

        'days' => [
            'required' => 'يجب أن تحتوي كل دورة على يوم واحد على الأقل.',
            'array' => 'يجب أن تكون الأيام في شكل مصفوفة.',
            'date' => [
                'required' => 'يجب تحديد تاريخ اليوم.',
                'date' => 'تاريخ اليوم يجب أن يكون بصيغة صحيحة.',
            ],
            'type' => [
                'required' => 'يجب تحديد نوع اليوم (أونلاين أو حضوري).',
                'in' => 'نوع اليوم يجب أن يكون أونلاين أو حضوري فقط.',
            ],
            'learning_type' => [
                'required' => 'يجب تحديد نوع التعلم (نظري أو عملي).',
                'in' => 'نوع التعلم يجب أن يكون نظريًا أو عمليًا فقط.',
            ],
            'center_id' => ['exists' => 'المركز المختار غير صالح.'],
            'hall_id' => ['exists' => 'القاعة المختارة غير صالحة.'],
            'meeting_link' => [
                'string' => 'رابط الاجتماع يجب أن يكون نصًا صالحًا.',
                'max' => 'رابط الاجتماع يجب ألا يتجاوز 255 حرفًا.',
            ],
        ],

        'custom' => [
            'day_within_range' => 'يجب أن يكون تاريخ اليوم ضمن نطاق بداية ونهاية الدورة.',
            'time_after_start' => 'وقت النهاية يجب أن يكون بعد وقت البداية.',
            'days_exceed_range' => 'عدد الأيام لا يمكن أن يتجاوز فترة الدورة.',
        ],
    ],
    /*
    |--------------------------------------------------------------------------
    | Custom Validation Language Lines
    |--------------------------------------------------------------------------
    |
    | Here you may specify custom validation messages for attributes using the
    | convention "attribute.rule" to name the lines. This makes it quick to
    | specify a specific custom language line for a given attribute rule.
    |
    */

    'custom' => [
        'attribute-name' => [
            'rule-name' => 'custom-message',
        ],
    ],

    /*
    |--------------------------------------------------------------------------
    | Custom Validation Attributes
    |--------------------------------------------------------------------------
    |
    | The following language lines are used to swap our attribute placeholder
    | with something more reader friendly such as "E-Mail Address" instead
    | of "email". This simply helps us make our message more expressive.
    |
    */

    'attributes' => [],

];
