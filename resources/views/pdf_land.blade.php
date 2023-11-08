<!DOCTYPE html>
<html lang="ar">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet"
          integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">

    <style>

        @media print {
            .new-page {
                page-break-before: always;
            }

            td {
                border: 1px solid black !important;
            }
        }

        @page {

            header: page-header;
            footer: page-footer;
            text-align: right;
            direction: rtl;
            text-align: right;
            width: 100%;
        }

        * {
            font-family: dejavu sans;
            direction: rtl;
            width: 100%;
            letter-spacing: 0;
            line-height: 2px;
        }

        .header {
            color: white;
            text-align: center !important;
            line-height: 60px;
            width: 100%;
            font-size: 25px;
            margin-top: 8px;
        }

        .footer {
            font-size: 20px !important;
            color: white;
        !important;
            text-align: center !important;
            line-height: 35px;
        }
    </style>
</head>

<body style="font-family:  amiri-normal;">


<h3 style="text-align: center">
    بسم الله الرحمن الرحيم
</h3>

<htmlpageheader name="page-header">
    <div class="header">
        <img style="opacity: 0.5" src="{{ public_path('frontend/header.png') }}">
    </div>
</htmlpageheader>

<htmlpagefooter name="page-footer">
    <div class="footer" style="margin-top: 8px !important">
        <img style="opacity: 0.5" src="{{ public_path('frontend/footer.png') }}">
    </div>
</htmlpagefooter>

<div style="direction: rtl;text-align: right">
    السادة/ سناد القابضة
    <span style="margin: 0 2em">المحترمين</span>
    <br>
    <p style="margin:1em 3em;display: block">السلام عليكم ورحمة الله وبركاته</p>
    بناء على طلبكم تقييم العقار
    {{ $estate->category->name ?? 'غير محدد' }}
    الواقع في
    {{ $estate->address ?? 'غير محدد' }}
    ، بمساحة اجمالية للارض
    {{ $estate->land_size ?? 'غير محدد' }}
    م2 حسب
    الصك، فقد قمنا بمعاينة العقار على الطبيعة والمستندات والخرائط اللازمة، وبعد إجراء دراسة للمنطقة المحيطة والمجاورة
    للعقار، نرفق لكم التقرير التالي الذي يوفر البيانات اللازمة ويبين الأسباب للوصول الى القيمة السوقية المقدرة للعقار
    بتاريخ ‏13
    {{ $estate->created_at }}
    م، وبناء على الدراسة المنجزة فإننا نقدر القيمة السوقية للعقار على حالته الراهن تساوي
    (
    {{ $option[17]['value'] ?? '' }}
    ريال سعودي) .
    <p style="text-align: center;margin-right: 10em">
        والله الموفق ،،،
    </p>
    <div style="width: 80%">
        .
    </div>
    <div style="text-align: center;width: 20%;float: left">
        <b>اسم المقيم</b>
        <br>
        عبدالعزيز بن بريك العوفي
        <br>
        <br>
        <br>
        <br>
        رقم العضوية: 1210000033
        <br>
        ‏13‏/08‏/2022 م
    </div>
</div>

<p class="new-page"></p>

<div style="text-align: right;direction: rtl" class="page">
    <b style="color: blue">مقدمة:</b>
    <p>
       تم اعداد تقرير التقييم بناء على التعليمات التي تم تلقيها من العميل لتقدير القيمة السوقية  للأصل محل التقييم، وقد اعد بواسطة المقيم / مؤسسة افكار العالمية للخدمات العقارية المعتمد من الهيئة السعودية للمقيمين المعتمدين، وقد قام بالمعاينة بعد فحص العقار محل التقييم وجمع البيانات والمعلومات وتحليلها لتكوين وتطوير رأي محايد عن القيمة السوقية للعقار المذكور ليتناسب مع الغرض الذي تم تحديده مسبقا وتماشيا مع معايير التقييم الدولية (IVSC) الصادرة في 2022م. ويقر المقيم بالاستقلالية وبعدم وجود اي تضارب في المصالح فيما يتعلق بالعميل، والمستخدمين المقصودين، وموضوع الملكية ومالكيها الحاليين، مما يمنعنا من تقديم رأي مستقل وموضوعي في قيمة الاصل محل التقييم.
    </p>
    <table class="table table-bordered">
        <thead>
        <tr>
            <th style="text-align: center" scope="col" colspan="4">بيانات الاصل</th>
        </tr>
        </thead>
        <tbody>
        <tr>
            <th scope="row">اسم المالك</th>
            <td>{{ $estate->user ? $estate->user->name : '' }}</td>
            <th scope="row">طبيعة الاصل:</th>
            <td>{{ $estate->category ? $estate->category->name : '' }}</td>
        </tr>

        <tr>
            <th scope="row">نوع الملكية:</th>
            <?php
            $var = \App\Models\EstateInput::where('estate_id', $estate->id)->where('key', 'نوع الملكية')->first();
            $var2 = \App\Models\EstateInput::where('estate_id', $estate->id)->where('key', 'القيود على العقار')->first();
            $var3 = \App\Models\EstateInput::where('estate_id', $estate->id)->where('key', 'رقم الرخصة')->first();
            $var4 = \App\Models\EstateInput::where('estate_id', $estate->id)->where('key', 'تاريخ الرخصة')->first();
            $var5 = \App\Models\EstateInput::where('estate_id', $estate->id)->where('key', 'مصدر الرخصة')->first();
            ?>
            <td>{{ $var->value ?: 'غير محدد' }}</td>
            <th scope="row">قيود العقار:</th>
            <td>{{ $var2->value ?: 'لا يوجد' }}</td>
        </tr>

        <tr>
            <th scope="row">
                المدينة:
            </th>
            <td>
                {{ $estate->city ? $estate->city->name : '' }}
            </td>
            <th scope="row">
                رقم الصك:
            </th>
            <td>
                {{ $var3->value ?: 'لا يوجد' }}
            </td>
        </tr>

        <tr>
            <th scope="row">
                الحي:
            </th>
            <td>
                النوارية
            </td>
            <th scope="row">
                تاريخ الصك:
            </th>
            <td>
                {{ $var4->value ?: 'لا يوجد' }}
            </td>
        </tr>


        <tr>
            <th scope="row">
                عنوان العقار:
            </th>
            <td>
                {{ $estate->address }}
            </td>
            <th scope="row">
                مصدر الصك:
            </th>
            <td>
                {{ $var5->value ?: '' }}
            </td>
        </tr>

        <tr>
            <th scope="row">
                رابط موقع العقار:
            </th>
            <td>
                <a href="https://maps.google.com/maps?q='+{{ $estate->lat }}+','+{{ $estate->lat }}+'&hl=es&z=14&amp;output=embed">https://maps.google.com/maps?q='+{{ $estate->lat }}+','+{{ $estate->lat }}+'&hl=es&z=14&amp;output=embed</a>
            </td>
            <th scope="row">
                رقم القطعة:
            </th>
            <?php
            $var6 = \App\Models\EstateInput::where('estate_id', $estate->id)->where('key', 'رقم قطعة الارض')->first();
            $var7 = \App\Models\EstateInput::where('estate_id', $estate->id)->where('key', 'رقم المخطوط')->first();
            $var8 = \App\Models\EstateInput::where('estate_id', $estate->id)->where('key', 'الاستخدام')->first();
            $var9 = \App\Models\EstateInput::where('estate_id', $estate->id)->where('key', 'رقم المخطوط')->first();
            ?>
            <td>
                {{ $var6->value ?: 'بدون' }}
            </td>
        </tr>

        <tr>
            <th scope="row">
                الموقع العام:
            </th>
            <td>
                داخل النطاق العمراني
            </td>
            <th scope="row">
                رقم المخطط:
            </th>
            <td>
                {{ $var7->value ?: 'بدون' }}
            </td>
        </tr>


        <tr>
            <th scope="row">
                الاستخدام الحالي:
            </th>
            <td>
                {{ $var8->value ?: 'بدون' }}
            </td>
            <th scope="row">
                اسم المخطط:
            </th>
            <td>
                {{ $var9->value ?: 'بدون' }}
            </td>
        </tr>

        <tr>
            <th scope="row">
                نظام البناء حسب التنظيم:
            </th>
            <td>
            <?php
                $vv = \App\Models\EstateInput::where('estate_id', $estate->id)->where('key', 'نظام البناء حسب التنظيم')->first();
        ?>
                {{ $vv->value ?? '----' }}
            </td>
            <th scope="row">
                مساحة الارض:
            </th>
            <td>
                {{ $estate->land_size ?: '' }} م2
            </td>
        </tr>
        <?php
        $var10 = \App\Models\EstateInput::where('estate_id', $estate->id)->where('key', 'عدد الشوارع')->first();
        $var11 = \App\Models\EstateInput::where('estate_id', $estate->id)->where('key', 'عرض الشارع الرئيسي')->first();
        $var12 = \App\Models\EstateInput::where('estate_id', $estate->id)->where('key', 'واجهات الشوارع')->first();
        ?>
        <tr>
            <th scope="row">
                عدد الشوارع:
            </th>
            <td>
                {{ $var10->value ?? '' }}
            </td>
            <th scope="row">
                عرض الواجهة الرئيسية:
            </th>
            <td>
                {{ $var11->value ?? '' }} م2
            </td>
        </tr>

        <tr>
            <th scope="row">
                واجهة الشوارع:
            </th>
            <td>
                {{ $var12->value ?? '' }}
            </td>
            <th scope="row">
                عرض الشارع الرئيسي:
            </th>
            <td>
                {{ $var11->value ?? '' }} م2
            </td>
        </tr>

        <tr>
            <th scope="row">
                موقع العقار من وسط المدسنة:
            </th>
            <td colspan="3">
                <?php
                $vv1 = \App\Models\EstateInput::where('estate_id', $estate->id)->where('key', 'موقع العقار من وسط المدينة')->first();
                ?>
               {{ $vv1->value ?? '' }}
            </td>
        </tr>


        </tbody>
    </table>
</div>

<p class="new-page"></p>

<div style="text-align: right;direction: rtl" class="page">
    <b style="color: blue">وصف العقار:</b>
    <p>
        <?php
        $vv2 = \App\Models\EstateInput::where('estate_id', $estate->id)->where('key', 'وصف العقار')->first();
        ?>
        {{ $vv2->value ?? '' }}
    </p>
    <b style="color: blue">امكانية الوصول الى العقار:</b>
    <p>

        <?php
        $vv3 = \App\Models\EstateInput::where('estate_id', $estate->id)->where('key', 'سهولة الوصول والاستدلال على الموقع')->first();
        ?>
        {{ $vv3->value ?? '' }}
    </p>

    <br>
    <table class="table">
        <thead>
        <tr>
            <th style="text-align: center" colspan="8">
                المسافة بين العقار والخدمات الرئيسية
            </th>
        </tr>
        </thead>
        <thead>
        <tr>
            <?php $dirictions = \App\EstateDirection::where('estate_id' , $estate->id)->get(); ?>
            @foreach($dirictions as $diriction)
            <th scope="col">{{ $diriction->diriction }} - {{ $diriction->limit }}</th>
            @endforeach
        </tr>
        </thead>
        <tbody>
        <tr>
            @foreach($dirictions as $diriction)
                <td>{{ $diriction->length }} كم2 </td>
            @endforeach
        </tr>
        </tbody>
    </table>
    <br>
    <b style="color: blue">وصف الملكية العقارية : </b>
    <p>
        (حسب الصك )
    </p>
    <br>
    <br>
    <table class="table">
        <thead>
        <tr>
            <th style="text-align: center" colspan="3">
                حدود واطوال العقار
            </th>
        </tr>
        </thead>
        <thead>
        <?php
        $dirs = \App\EstateDirection::where('estate_id', $estate->id)->get();
        ?>
        <tr>
            <th scope="col">الجهه</th>
            <th scope="col">الحد</th>
            <th scope="col">الطول</th>
        </tr>
        </thead>
        <tbody>
        @foreach($dirs as $dir)
            <tr>
                <th scope="row">{{ $dir->direction }}:</th>
                <td>{{ $dir->limit }}</td>
                <td> {{ $dir->length }} م</td>
            </tr>
        @endforeach
        </tbody>
    </table>
    @if($estate->image_url)
    <br>
    <div style="text-align: center">
        <img style="width: 100%; max-height: 300px" src="{{ $estate->image_url }}">
    </div>
    @endif
</div>


<p class="new-page"></p>
<div style="text-align: right;direction: rtl" class="page">
    <table class="table">
        <thead>
        <tr>
            <th style="display: none">#</th>
            <th>
                المساحة التأجيرية
            </th>
            <th>
                اجمالي الايجار السنوي
            </th>
            <th class="">
                ااجمالي القيمة السوقية (ريال)
            </th>
        </tr>
        </thead>
        <tbody>
        <tr>
            <td style="display:none"></td>
            <td class="product-name">{{ $option[0]['value'] ?? '' }}</td>
            <td>{{ $option[1]['value'] ?? '' }}</td>
            <td>{{ $option[24]['value'] ?? '' }}</td>
        </tr>
        </tbody>
    </table>
    <hr>
    <table class="table">
        <thead>
        <tr>
            <th style="display: none">#</th>
            <th class="old">
                الايجار للمتر المربع
            </th>
            <th class="old">
                نسبة المصاريف التشغيلية
            </th>
            <th class="old">
                اجمالي المصاريف التشغيلية
            </th>
            <th class="old">
                صافي الايجار السنوي
            </th>
            <th class="old">
                صافي الايجار السنوي للمتر المربع
            </th>
            <th class="old">
                تاريخ انتهاء العقد

            </th>
            <th class="old">
                الفترة المتبقية لانتهاء العقد
            </th>
            <th class="old">
                معدل العائد للأبدية قبل انتهاء العقد
            </th>
            <th class="old">
                عامل شراء السنوات لفترة محددة
            </th>
            <th class="old">
                القيمة السوقية
            </th>
        </tr>
        </thead>
        <tbody>
        <tr>
            <td style="display:none"></td>
            <td>{{ $option[3]['value'] ?? '' }}</td>
            <td>{{ $option[4]['value'] ?? '' }}</td>
            <td>{{ $option[5]['value'] ?? '' }}</td>
            <td>{{ $option[14]['value'] ?? '' }}</td>
            <td>{{ $option[15]['value'] ?? '' }}</td>
            <td>{{ $option[6]['value'] ?? '' }}</td>
            <td>{{ $option[16]['value'] ?? '' }}</td>
            <td>{{ $option[7]['value'] ?? '' }}</td>
            <td>{{ $option[8]['value'] ?? '' }}</td>
            <td>{{ $option[17]['value'] ?? '' }}</td>
        </tr>
        </tbody>
    </table>
    <hr>
    <table class="table">
        <thead>
        <tr>
            <th style="display: none">#</th>

            <th class="new">
                الايجار للمتر المربع بعد التجديد
            </th>
            <th class="new">
                اجمالي الايجار السنوي
            </th>
            <th class="new">
                نسبة المصاريف التشغيلية
            </th>
            <th class="new">
                اجمالي المصاريف التشغيلية
            </th>
            <th class="new">
                صافي الايجار السنوي
            </th>
            <th class="new">
                الايجار السنوي للمتر المربع
            </th>
            <th class="new">
                معدل الاشغال
            </th>
            <th class="new">
                معدل العائد للأبدية بعد تجديد العقد
            </th>
            <th class="new">
                القيمة الحالية
            </th>
            <th class="new">
                عامل سنوات الشراء للأبد
            </th>
            <th class="new">
                القيمة السوقية
            </th>
        </tr>
        </thead>
        <tbody>
        <tr>
            <td style="display:none"></td>
            <td>{{ $option[11]['value'] ?? '' }}</td>
            <td>{{ $option[18]['value'] ?? '' }}</td>
            <td>{{ $option[10]['value'] ?? '' }}</td>
            <td>{{ $option[19]['value'] ?? '' }}</td>
            <td>{{ $option[20]['value'] ?? '' }}</td>
            <td>{{ $option[23]['value'] ?? '' }}</td>
            <td>{{ $option[12]['value'] ?? '' }}</td>
            <td>{{ $option[9]['value'] ?? '' }}</td>
            <td>{{ $option[13]['value'] ?? '' }}</td>
            <td>{{ $option[21]['value'] ?? '' }}</td>
            <td>{{ $option[22]['value'] ?? '' }}</td>
        </tr>
        </tbody>
    </table>
</div>

<p class="new-page"></p>

<div style="text-align: right;direction: rtl" class="page">
    <b style="color: blue">نطاق العمل ومعايير التقييم:</b>

    <br>
    <table class="table">
        <thead>
        <tr>
            <?php
            $var13 = \App\Models\EstateInput::where('estate_id', $estate->id)->where('key', 'نطاق العمل والاتعاب')->first();
            ?>
            <th style="text-align: center" colspan="8">
                نطاق العمل ({{ $var13->value ?: '' }})
            </th>
        </tr>
        </thead>
        <tbody>
        <tr>
            <th scope="row">العميل:</th>
            <td>
            {{ $estate->user->name }}
            <td>
            <th scope="row">المستخدم:</th>
            <td>العميل فقط
            <td>
        </tr>
        <tr>
            <th scope="row">عملة التقييم:</th>
            <td>الريال السعودي
            <td>
            <th scope="row">تاريخ المعاينة:</th>
            <td>‏13---- م
            <td>
        </tr>
        <tr>
            <?php
            $kk = \App\Models\EstateInput::where('estate_id', $estate->id)->where('key', 'نوع التقرير')->first();
            $kk1 = \App\Models\EstateInput::where('estate_id', $estate->id)->where('key', 'وصف التقرير')->first();
            $kk2 = \App\Models\EstateInput::where('estate_id', $estate->id)->where('key', 'اساس التقرير')->first();
            $kk3 = \App\Models\EstateInput::where('estate_id', $estate->id)->where('key', 'معايير التقييم')->first();
            ?>
            <th scope="row">نوع التقرير:</th>
            <td>{{ $kk->value ?? 'تقرير مختصر' }}
            <td>
            <th scope="row">تاريخ التقييم:</th>
            <td>----- م
            <td>
        </tr>
        <tr>
            <th scope="row">وصف التقرير:</th>
            <td>{{ $kk1->value ?? 'الكتنروني' }}
            <td>
            <th scope="row">تاريخ التقرير:</th>
            <td>‏
                {{ $kk1->created_at ?? '' }} م
            <td>
        </tr>
        <tr>
            <th scope="row">اساس القيمة:</th>
            <td>{{ $kk2->value ?? '' }}
            <td>
            <th scope="row">معايير التقييم:</th>
            <td> {{ $kk3->value ?? '' }}
            <td>
        </tr>
        <?php
        $var14 = \App\Models\EstateInput::where('estate_id', $estate->id)->where('key', 'سبب التقييم')->first();
        $ll = \App\Models\EstateInput::where('estate_id', $estate->id)->where('key', 'فرضية القيمة')->first();
        ?>
        <tr>
            <th scope="row">فرضية القيمة:</th>
            <td>{{ $ll->value ?? '' }}
            <td>
            <th scope="row">الغرض من التقييم:</th>
            <td>
            {{ $var14->value ?: '' }}
            <td>
        </tr>
        {{--<tr>--}}
            {{--<th scope="row">اسلوب التقيم 1:</th>--}}
            {{--<td colspan="3">اسلوب السوق طريقة المقارنة--}}
            {{--<td>--}}
        {{--</tr>--}}
        {{--<tr>--}}
            {{--<th scope="row">اسلوب التقيم 2:</th>--}}
            {{--<td colspan="3">اسلوب الدخل طريقة القيمة المتبقية--}}
            {{--<td>--}}
        {{--</tr>--}}
        </tbody>
    </table>
    <br>
</div>

<p class="new-page"></p>

<div style="text-align: right;direction: rtl" class="page">
    <table class="table">
        <thead>
        <tr>
            <th style="text-align: center" colspan="8">
                نطاق العمل ({{ $var13->value ?: '' }})
            </th>
        </tr>
        </thead>
        <tbody>
        <tr>
            <th scope="row">حالة المقيم:</th>
            <td>
                نقدم رأينا في القيمة بصفتنا مقيم خارجي مستقل وبدون اي مساعدة من مقيمين آخرين ونقر بعدم وجود اي تضارب في
                المصالح فيما يتعلق بالعميل، والمستخدمين المقصودين، وموضوع الملكية ومالكيها الحاليين، مما يمنعنا من تقديم
                رأي مستقل وموضوعي في قيمة العقار محل التقييم
            </td>
        </tr>
        <tr>
            <th scope="row">هوية المقيم:</th>
            <td>
                تم إعداد هذا التقرير من قبل مؤسسة افكار العالمية للخدمات العقارية ، وفريق العمل الذي لديها والذي يتمتع
                بأعلى درجات الكفاءة والحيادية بخبرات متنوعة في مجال التقييم والاستشارات، حيث يتوفر لديهم قاعدة معلومات
                تم بناؤها من خلال خبراتها التقييمية ومن خلال ما قامت به من جمع للبيانات والمعلومات والاحصائيات الصادرة
                عن الجهات الرسمية وغير الرسمية والتي يتم تحديثها بشكل مستمر مما يعطي المقييمين سعة إدراك للقيام بمهامهم
                على أكمل وجه.
            </td>
        </tr>
        <tr>
            <th scope="row">الاصل محل التقييم:</th>
            <td>
                الاصل عبارة عن ارض جبلية زراعية.
            </td>
        </tr>
        <tr>
            <th scope="row">طبيعة مصدر المعلومات:</th>
            <td>
                "مصادر داخلية: تم الاعتماد على المعلومات الموجودة في صكوك الملكية المرفقة للعقار والعقود الايجارية
                والقوائم المالية وجميع المستندات والمعلومات المقدمة لنا من العميل وافترضنا انها صحيحه و اعتمدنا عليها
                للوصول بمخرجات هذا التقرير، وكذلك على حزمة من المعلومات و البيانات الخاصة بنا ومن اعمال التقييم السابقة
                لنا والمسح والزيارة الميدانية لنطاق البحث، والعروض المباشرة لدينا والتي نرى حسب حدود علمنا انها صحيحة.
                مصادر خارجية: كما اعتمدنا على بيانات البلدية والسوقية والاقتصادية والمخططات الهيكلية للمدن المنشورة في
                الموقع الرسمي لأمانة مكة المكرمة، واستفساراتنا للوكلاء ومدراء العقارات ومطوريها واصحاب الاختصاص في
                المقاولات ومواد البناء والمكاتب العقارية في المنطقة، وكذلك الاستقصاءات المنشورة في السوق والبحوث
                الثانوية المتعلقة بحالة السوق وتوقعاته وتقارير تقييم صناديق الريت المنشورة في موقع تداول، والبيانات
                المفتوحة في موقع وزارة العدل، ووزارة المالية، والهيئة العامة للاحصاء، والبنك المركزي السعودي، والغرفة
                التجارية ووزارة السياحة."
            </td>
        </tr>
        <tr>
            <th scope="row">اعداد التقرير:</th>
            <td>
                نؤكد لكم بانه قد تم تقييم العقار وفقا لمعايير التقييم الدولية - IVSC الصادرة عن مجلس معايير التقييم
                الدولية 2022 وأنظمة ولوائح الهيئة السعودية للمقيمين المعتمدين بالمملكة العربية السعودية (تقييم).
            </td>
        </tr>
        </tbody>
    </table>
</div>


<p class="new-page"></p>

<div style="text-align: right;direction: rtl" class="page">
    <div style="text-align: center;border: 1px solid black;margin: 0 8em">
        {{--<img src="{{ public_path('frontend/map2.png') }}">--}}
        <br>
        <b>حدود منطقة العمل:</b>
        حي النوارية بمدينة مكة المكرمة والمنطقة المجاورة لها.
    </div>
    <br>
    <table class="table">
        <thead>
        <tr>
            <th style="text-align: center" colspan="8">
                نطاق العمل ({{ $var13->value ?: '' }})
            </th>
        </tr>
        </thead>
        <tbody>
        <tr>
            <th scope="row">معاينة الاصل:</th>
            <td>
                تم الاتطلاع عل مستندات الملكية المقدمة من العميـــــــل والـــــــذي يوضـــــــح مســاحة وحدود العقــار،
                وتم الوقوف ومعاينة العقار بصريا ومطابقــــــــــة المعلومــــــــــات الواردة لنا على الواقع.
            </td>
        </tr>
        <tr>
            <th scope="row">تحديد خصائص الاصل:</th>
            <td>
                مـن خـلال البيانات تبـين أن الاصل موضــع التقيــيم هــو عبـــــارة عن ارض زراعية.
            </td>
        </tr>
        <tr>
            <th scope="row">تحليل البيانات:</th>
            <td>
                تم تحليل البيانـات المتـوفرة في منطقة العقـار والتـي تـم إستقصــــائها مــــن مصـــــادر رسمية (قاعدة
                بيانـات وزارة العــــــــدل) وموقع "ايجار" والمؤشر العقاري والمؤشر الايجارية لهيئة العقار،
                ومصــــــــادر غيــــــــر رســـــــمية مثـــــــل المكاتـــــــب العقاريــــة التــــي تعمــــل فــــي
                منطقة العقار.
            </td>
        </tr>
        <tr>
            <th scope="row">تطبيق طرق التقييم:</th>
            <td>
                بعـــــــــــد تقـــــــــــدير الخبـــــــــــراء الاستخدام الحالي من ناحية السـوق والبيانـات المتـوفرة
                لدينا، وبناء على طلب العميل، تـــــم الاســـــتنتاج بـــــأن طريقة المقارنة (أسلوب السوق) وطريقة القيمة
                المتبقية (أسلوب الدخل) هو الانســـب مــــع مراعــــاة الغــــرض مــــن التقييم.
            </td>
        </tr>
        <tr>
            <th scope="row">جمع البيانات:</th>
            <td>
                بناءاً على نوع العقار محل التقيــــيم، تــــم تحديــــد نطــــاق جمــــع البيانــــات فــــي مدينــــة
                مكة المكرمة وخصوصـــاً فـــــي المنطقـــــة المحيطـــــة بالعقــــــــار.
            </td>
        </tr>
        <tr>
            <th scope="row">تقدير القيمة:</th>
            <td>
                بعد التوفيق بين نتائج طرق التقيـــيم يــــتم تـــرجيح قيمــــة تتوافـــق مـــع نطـــاق العمـــل الموضح
                مع العميل.
            </td>
        </tr>
        <tr>
            <th scope="row">
                مراجعة القيمة:
            </th>
            <td>
                مراجعـــة القيمـــة والتأكد من المعلومـــــــــــات والتحليلات والافتراضات التي توصل إليها المقييم.
            </td>
        </tr>
        <tr>
            <th scope="row">
                اعداد التقرير:
            </th>
            <td>
                العمـــل علـــى إعـــداد التقريـــر وفقــــاً لمعيــــار 101 لوصــــف التقريــــر ومعيــــار 103
                إعــــداد التقرير.
            </td>
        </tr>
        </tbody>
    </table>
</div>


<p class="new-page"></p>

<div style="text-align: right;direction: rtl" class="page">
    <b style="color: blue">ظروف السوق:</b>
    <p>
        شهد السوق المحلي في مدينة جدة خلال الاشهر الاخيرة ارتفاع في المبيعات العقارية حيث تأثر السوق بالعوامل الاقتصادية
        من تأثير جائحة كورونا، في تاريخ 11 مارس 2020م صنفت منظمة الصحة العالمية فيروس كورونا بأنه "وباء عالمي" مما أحدث
        تأثيرا واضحا على الاقتصاديات و الأسواق المالية العالمية والمحلية وبناء عليها تم اتخاذ العديد من الإجراءات
        الرسمية محليا وعالميا والتي من شأنها أن تؤثر على جميع القطاعات ومن ضمنها القطاع العقاري. خلال هذه الفترة الحرجة
        هناك تأثر واضح في الصفقات العقارية ونشاط السوق، والظاهر حاليا بان السوق في مرحلة تعافي خصوصا بعد الغاء الضريبة
        المضافة واستبدالها بضريبة التصرفات العقارية 5% من قيمة البيع، وكذلك استمرار الدعم من وزارة الاسكان وتحمل جزء من
        الضريبة عن المواطن للمسكن الاول وتحمل جزء من ارباح التمويل العقاري مما يكون له تأثير ايجابي على السوق العقاري،
        ونتوقع باستمرار التعافي خلال السنوات القادمة وازدياد في الانشطة العقارية مما يؤثر ايجابيا على الطلب وارتفاع صحي
        لقيمة العقارات الحالية.
    </p>
    <b style="color: blue">العوامل الاقتصادية المؤثرة فيه:</b>
    <p style="color: blue">العرض والطلب:</p>
    <p>
        كلما ازدادت نسبة الطلب وقلت نسبة العرض على العقارات كلما ارتفعت أسعار العقارات والعكس صحيح بالطبع فكلما قلت نسبة
        الطلب وزادت نسبة العرض كلما قلت أسعار العقارات كما تتأثر نسبة الطلب والعرض بالعديد من العوامل الاقتصادية
        والسياسية.
    </p>
    <p style="color: blue"> توفر الخدمات:</p>
    <p>
        توافر الخدمات كالمدارس ، الجامعات، المولات التجارية، الوسائل الترفيهية وغيرها من الخدمات في منطقة يؤثر على أسعار
        العقارات بشكل كبير فيزداد الطلب عليها ما يؤثر بطبيعة الحال على ازدياد أسعار العقارات في المنطقة.
    </p>
    <p style="color: blue">الوضع الاقتصادي:</p>
    <p>
        الأوضاع الاقتصادية المتدنية بلا شك تؤثر على السوق العقاري وأسعار العقارات فتسبب حالة من الركود وانخفاض الأسعار ،
        اما في حالة انتعاش الحالة الاقتصادية للبلاد وثبات دخل الفرد ففي هذه الحالة تزداد الأسعار حيث يكون هناك استقرار
        في الحالة المادية للأفراد ما يجعلهم قادرين على شراء أو تأجير العقارات.
    </p>
    <p style="color: blue">حالة العقار:</p>
    <p>
        كلما كانت حالة العقار جيدة كلما أثر ذلك على ازدياد سعر العقار على سبيل المثال إن قارنت عقار حالته جيدة بعقار آخر
        مشابه له في الصفات ولربما تميز ذلك الأخير بمساحة أكبر ولكن حالته كانت سيئة فستجد الأفضلية بالطبع للعقار الأول ذو
        الحالة الأفضل.
    </p>
    <p style="color: blue">الحالة السياسية:</p>
    <p>
        الحالة السياسية تؤثر بشكل مباشر على الأوضاع الاقتصادية للبلاد ما يؤثر بطبيعة الحال على أسعار العقارات لذا فإن
        تدهور الأحوال السياسية للبلاد يحدث بها عدم استقرار للسوق العقاري فتجد بعض المناطق يزداد بها أسعار العقارات بشكل
        مبالغ فيه ، في حين تنخفض الأسعار في مناطق أخرى.
    </p>

</div>

<p class="new-page"></p>

<div style="text-align: right;direction: rtl" class="page">
    <b style="color: blue">اساس القيمة المستخدمة:</b>
    <p>
        يعتمد اساس التقييم على ايجاد القيمة السوقية الحالية للعقار، على اساس ان العقار خال من جميع الاعباء والشروط
        التقييدية والالتزامات القانونية، وعليه فان المفهوم المتبع في هذا التقرير عن القيمة السوقية هو عبارة عن المبلغ
        التقديري الذي على اساسه ينبغي بيع الملكية في تاريخ التقييم بين بائع راغب ومشتري راغب، بشروط بيع مناسبه، وفي اطار
        معاملة على اساس محايد بعد تسويق مناسب حيث يتصرف كل من طرف من الاطراف بمعرفة وحكمة دون قسر او اجبار. (المعايير
        الدولية 40.1)
    </p>
</div>

<p class="new-page"></p>

<div style="text-align: right;direction: rtl" class="page">
    <b style="color: blue">طريقة التقييم:</b>
    <p>
        للوصول الى القيمة السوقية بناء على غرض التقييم وطبيعة العقار، وبناء على طلب العميل، سيتم الاعتماد على طريقة
        المقارنة (أسلوب السوق) وطريقة القيمة المتبقية (أسلوب الدخل) للوصول الى القيمة السوقية للعقار ثم الترجيح بينهم :
    </p>
    <b style="color: blue">البحث والاستقصاء:</b>
    <ul>
        <li>
            تم الكشف على العقار ولوقوف عليه والمعاينة البصرية.
        </li>
        <li>
            تم جمع المعلومات عن العقار من الموقع وتم تحليل اسعار العقارات المعروضة للبيع والتي تم بيعها قريبا
            والايجارات المماثلة للعقار في المنطقة.
        </li>
        <li>
            الإطلاع على الحي الذي يقع فيه العقار والمناطق المجاورة له، بما في ذلك المشاريع التجارية القائمة والقادمة
            والخدمات والتسهيلات.
        </li>
        <li>
            تم دراسة مستوى االاسعار والايجارات بالمنطقة المحيطة بالعقار وتمت الاستعانة بأسعار العقارات المعروضة حاليا،
            وتم عمل مسح ميداني استقصائي عن اسعار البيع والايجار في الآونة الاخيرة للعقارات المشابهة للاصل محل التقييم في
            المنطقة، وتم اخذ هذه الاسعار كمؤشرات للوصول الى القيمة السوقية.
        </li>
    </ul>
    <br>
    <b style="color: blue">طريقة المقارنة (اسلوب السوق):</b>
    <p>
        تقوم اساسا على مقارنة العقار محل التقييم بعقارات مماثلة من السوق، لإيجاد القيمة الرأسمالية او الايجارية للعقار
        بصورة مباشرة، وتعتبر هذه الطريقة: أن سعر السوق هو افضل مؤشر للقيمة، ويمكن استنتاج سعر السوق من خلال البحث عن
        الادلة والشواهد المتوفرة عن المعاملات والصفقات التي جرت مؤخرا في السوق لعقارات مماثلة للعقار محل التقييم
        وتطبيقها عليه مع الاخذ بعين الاعتبار التسويات الخاصة بالعوامل المتغيرة. وتعتمد طريقة المقارنة على معاملات البيع
        الفعلية لعقارات مماثلة وقابلة للمقارنة في نفس السوق مع مراعاة مصادر البيانات وتفاصيل المعاملات ومعرفة تواريخها.
        وبعد جمع المقارنات المتوفرة، نقوم بدراسة العروض المشابهة ليتم تسويتها بالعقار محل التقييم بما لا يضر بقيمة
        العقار المقارن وذلك حتى نستطيع مقاربتها للعقار محل التقييم. وتنحصر هذه التعديلات في المساحات والمكان واي مميزات
        اضافية تعتبر من الكماليات ولا تعتمد في اي تغيير جزري في قيمة العقار. يتم الاعتماد على المسح الميداني والتواصل مع
        وكلاء العقاريين في السوق المحيط لجلب العينات المشابهة للعقار محل التقييم والبحث عن العروض المشابهة والتاكد من
        صحتها قبل اعتمادها للمقارنة.
    </p>
    <br>
    <b>خطوات التقييم بطريقة المقارنة:</b>
    <ul>
        <li>
            تحديد العقار او الحق العقاري المراد تقييمه
        </li>
        <li>
            تحديد الغرض من التقييم
        </li>
        <li>
            فحص ومعاينة العقار
        </li>
        <li>
            التحقق من الحقوق والقيود القانوينة
        </li>
        <li>
            الاستفسار عن تنظيم وتخطيط المدينة والاعتبارات البيئية من الجهات المعنية
        </li>
        <li>
            تصنيف المعاملات والصفقات القابلة للمقارنة وتحديد سعر استرشادي للعقار
        </li>
        <li>
            تعديل السعر وعمل التسويات للعقار المقارن لاظهار المزايا والعيوب (المادية والبيئية والقانونية)
        </li>
    </ul>
</div>


{{--<p class="new-page"></p>--}}

{{--<div style="text-align: right;direction: rtl;text-align: center" class="page">--}}
    {{--<img src="{{ public_path('frontend/table.png') }}">--}}
{{--</div>--}}


<p class="new-page"></p>

<div style="text-align: right;direction: rtl" class="page">
    <b style="color: blue">طريقة القيمة المتبقية (اسلوب الدخل):</b>
    <p>
        هي طريقة تعتمد على تقدير القيمة الرأسمالية الحالية للدخل المتوقع واقتطاع التكاليف المحتملة للتطوير ويكون المبلغ
        المتبقي هو القيمة الحالية للعقار. ويتم استخدام طريقة القيمة المتبقية في تقييم العقارات التي يتم تطويرها او التي
        يمكن تطويرها وتعتبر طريقة لتقدير قيمة الارض ويمكن استخدامها لتقدير الربح المحتمل تحقيقه من قبل المطور. وتفترض
        طريقة القيمة المتبقية ان الثمن الذي يمكن ان يدفعه المشتري مقابل شراء ارض التطوير العقاري هو الفائض من البيع او
        قيمة التطوير المنجز، بعد خصم تكلفة البناء، وتكلفة التمويل، وبدل تحقيق الارباح اللازمة لتنفيذ المشروع.
    </p>
    <b>خطوات التقييم بطريقة القيمة المتبقية:</b>
    <ul>
        <li>
            تحديد العقار او الحق العقاري المراد تقييمه
        </li>
        <li>
            تحديد الغرض من التقييم
        </li>
        <li>
            فحص ومعاينة العقار
        </li>
        <li>
            التحقق من الحقوق والقيود القانوينة
        </li>
        <li>
            الاستفسار عن تنظيم وتخطيط المدينة والاعتبارات البيئية من الجهات المعنية.
        </li>
        <li>
            دراسة السوق والبحث عن افضل عائد استثماري للعقارات المشابه لتطويرها
        </li>
        <li>
            حساب اجمالي قيمة التطوير (GDV)
        </li>
        <li>
            حساب تكاليف النية التحتية وحساب تكلفة البناء وتقدير الاجور المهنية والقانونية
        </li>
        <li>
            تقدير التكلفة المالية والتكاليف الطارئة وارباح المطور
        </li>
        <li>
            تقدير صافي قيمة التطوير والقيمة المتبقية للارض في الوقت الحالي
        </li>
    </ul>
    <br>
    <b>• مشروع التطوير العقاري:</b>
    <p>
        بعد دراسة المنطقة المحيطة، فقد توصلنا الى ان مشروع تحويل الارض من زراعي الى سكني ثم تخطيط الارض وتقسميها الى قطع
        صغيرة سكنية ثم بيعها يعد افضل عائد استثماري في هذه المنطقة، وبدراسة اسعار العقارات المعروضة في المنطقة والتي تم
        بيعها مؤخرا ومدى الرغبة في شراء عقارات مماثلة، فقد توصلنا الى هذه الدراسة لتحديد القيمة المتبقية للارض.
    </p>
</div>

{{--<p class="new-page"></p>--}}

{{--<div style="text-align: right;direction: rtl;text-align: center" class="page">--}}
    {{--<img src="{{ public_path('frontend/table1.png') }}">--}}
    {{--<br>--}}
    {{--<img src="{{ public_path('frontend/table2.png') }}">--}}
{{--</div>--}}

<p class="new-page"></p>

<div style="text-align: right;direction: rtl;text-align: center" class="page">
    <img src="{{ public_path('frontend/table3.png') }}">
    <br>
    <img src="{{ public_path('frontend/table4.png') }}">
</div>

<p class="new-page"></p>

<div style="text-align: right;direction: rtl;text-align: center" class="page">
    <img src="{{ public_path('frontend/table5.png') }}">
</div>


<p class="new-page"></p>

<div style="text-align: right;direction: rtl" class="page">
    <b style="color: blue">ترجيح وتسوية القيمة:</b>
    <p>
        استاند الى غرض التقييم وطبيعة العقار وخصائصه والغرض من التقييم، فقد تم الترجيح بين القيمة المستنتجة من طرق
        التقييم السابقة بأوزان نسبية مختلفة كأساس للقيمة السوقية للعقار محل التقييم على النحو التالي:
    </p>
    <br>
    <img src="{{ public_path('frontend/table6.png') }}">
    <br>
    <b style="color: blue">رأي القيمة:</b>
    <p>
        عند استعراض المعلومات السابقة من هذا التقرير وتحليل معطيات السوق العقاري حاليا، فقد توصلنا الى القيمة السوقية
        للعقار بطريقة المقارنة (أسلوب السوق) وبطريقة القيمة المتبقية (أسلوب الدخل) ترجيحا بتاريخ التقييم ‏13‏/08‏/2022 م
        هو:
    </p>
    <br>
    <div style="text-align: center">
        <img src="{{ public_path('frontend/table7.png') }}">
        <br>
        <br>
        والله الموفق ،،،
        <br>
        <br>
        <img src="{{ public_path('frontend/table8.png') }}">
    </div>
    <br>
    <div class="ffo">
        <div style="float: right" class="col-4">
            مقيم مشارك
            <br>
            عبدالله بن محمود باحاذق
            <br>
            ‏13‏/08‏/2022
            <br>
            <img style="height: 70px" src="{{ public_path('frontend/name.png') }}">
        </div>
        <div style="float: right;text-align: center" class="col-4">
            <img style="height: 70px" src="{{ public_path('frontend/po.jpg') }}">
        </div>
        <div style="float: right;text-align: center" class="col-4">
            المدير العام
            <br>
            عبدالعزيز بن بريك العوفي
            <br>
            ‏13‏/08‏/2022 م
            <br>
            <img style="height: 70px" src="{{ public_path('frontend/name1.png') }}">
        </div>
    </div>
</div>

<p class="new-page"></p>

<div style="text-align: right;direction: rtl" class="page">
    <b style="color: blue">الملاحظات والتوصيات:</b>
    <p>
        في ختام تقرير التقييم سوف نقدم بعض الملاحظات والتوصيات فيما يتعلق بقيمة العقار، حيث ان ظروف السوق حاليا في نشاط
        مستمر ونتوقع باذن الله ارتفاع صحي في قيمة العقارات خلال السنوات القادمة، ولغرض التقييم، نوصي بالاحتفاظ بالعقار
        مع الاخذ بعين الاعتبار المخاطر المحتملة.
    </p>
    <b style="color: blue">
        ملحقات:
    </b>
    <p style="color: blue">
        تقرير المعاينة:
    </p>
    <p>
        ملاحظة: لا يوجد.
    </p>
    <br>
    <p style="color: blue">
        البيانات الاساسية للعقار (نوع العقار وحالته):
    </p>
    <br>
    <table class="table">
        <tbody>
        <tr>
            <th scope="row">نوع العقار</th>
            <td>
                {{ $estate->kind->name }}
            </td>
        </tr>
        <tr>
            <th scope="row">استعمال العقار</th>
            <td>
                سكني
            </td>
        </tr>
        <tr>
            <?php
                $old = \App\Models\EstateInput::where('estate_id', $estate->id)->where('key', 'عمر العقار')->first();
                $street = \App\Models\EstateInput::where('estate_id', $estate->id)->where('key', 'الشوارع المحيطة')->first();
                $hh = \App\Models\EstateInput::where('estate_id', $estate->id)->where('key', 'مستوى العقار عن الشارع')->first();
                $statue = \App\Models\EstateInput::where('estate_id', $estate->id)->where('key', 'حالة العقار')->first();
                $finish = \App\Models\EstateInput::where('estate_id', $estate->id)->where('key', 'مستوى التشطيب')->first();
                $builds = \App\Models\EstateInput::where('estate_id', $estate->id)->where('key', 'الخدمات العامه والمرافق الموجوده')->first();
                $oo = \App\Models\EstateInput::where('estate_id', $estate->id)->where('key', 'مميزات اضافية')->first();
            ?>
            <th scope="row">عمر العقار</th>
            <td>
                {{ $old->value ?? '' }}
            </td>
        </tr>
        <tr>
            <th scope="row">الشوارع</th>
            <td>
                {{ $street->value ?? '' }}
            </td>
        </tr>
        <tr>
            <th scope="row">مستوى العقار عن الشارع</th>
            <td>
                {{ $hh->value ?? '' }}
            </td>
        </tr>
        <tr>
            <th scope="row">حالة العقار</th>
            <td>
                {{ $statue->value ?? '' }}
            </td>
        </tr>
        <tr>
            <th scope="row">مستوى التشطيب</th>
            <td>
                {{ $finish->value ?? '' }}
            </td>
        </tr>
        <tr>
            <th scope="row">الخدمات المتوفرة</th>
            <td>
                {{ $builds->value ?? '' }}
            </td>
        </tr>
        <tr>
            <th scope="row">مميزات موقع العقار</th>
            <td>
                {{ $oo->value ?? '' }}
            </td>
        </tr>
        <?php
        $people = \App\Models\EstateInput::where('estate_id', $estate->id)->where('key', 'كثافة سكانية في المنطقة المحيطة')->first();
        $buildsss = \App\Models\EstateInput::where('estate_id', $estate->id)->where('key', 'نسبة العقارات المبنية بالمنطقة')->first();
        $buildsss_people = \App\Models\EstateInput::where('estate_id', $estate->id)->where('key', 'نسبة اشغار العقارات بالمنطقة')->first();
        ?>
        <tr>
            <th scope="row">الكثافة السكانية في منطقة العقار</th>
            <td>
                {{ $people->value ?? '' }}
            </td>
        </tr>
        <tr>
            <th scope="row">نسبة العقارات المبنية في منطقة</th>
            <td>
               {{ $buildsss->value ?? '' }}
            </td>
        </tr>
        <tr>
            <th scope="row">نسبة اشغال العقارات في المنطقة</th>
            <td>
                {{ $buildsss_people->value ?? '' }}
            </td>
        </tr>
        </tbody>
    </table>
</div>

<p class="new-page"></p>

<div style="text-align: right;direction: rtl" class="page">
    <p style="color: blue">معلومات العقار الخارجية:</p>
    <table class="table">
        <tbody>
        <tr>
            <th scope="row">التصميم المعماري</th>
            <td>
                <?php $val4 = \App\Models\EstateInput::where('key','التصميم المعماري')->first(); ?>
                {{ $val4->value ?? '----' }}
            </td>
        </tr>
        <tr>
            <th scope="row">نوع واجهة المبنى الشمالية</th>
            <td>
                <?php $vallull = \App\Models\EstateInput::where('key','نوع واجهة المبنى الشمالية')->first(); ?>
                {{ $vallull->value ?? '----' }}
            </td>
        </tr>
        <tr>
            <th scope="row">نوع واجهة المبنى الجنوبية</th>
            <td>
                <?php $vallll = \App\Models\EstateInput::where('key','نوع واجهة المبنى الجنوبية')->first(); ?>
                {{ $vallll->value ?? '----' }}
            </td>
        </tr>
        <tr>
            <th scope="row">نوع واجهة المبنى الشرقية</th>
            <td>
                <?php $valll = \App\Models\EstateInput::where('key','نوع واجهة المبنى الشرقية')->first(); ?>
                {{ $valll->value ?? '----' }}
            </td>
        </tr>
        <tr>
            <th scope="row">نوع واجهة المبنى الغربية</th>
            <td>

                <?php $valliil = \App\Models\EstateInput::where('key','نوع واجهة المبنى الغربية')->first(); ?>
                {{ $valliil->value ?? '----' }}
            </td>
        </tr>
        <tr>
            <th scope="row">انواع الابواب</th>
            <td>
                <?php $valleiil = \App\Models\EstateInput::where('key','نوع الابواب الخارجية')->first(); ?>
                {{ $valleiil->value ?? '----' }}
            </td>
        </tr>
        <tr>
            <th scope="row">ارضيات الفناء الخارجي</th>
            <td>
                <?php $va4ll = \App\Models\EstateInput::where('key','ارضيات الفناء الخارجي')->first(); ?>
                {{ $va4ll->value ?? '----' }}

            </td>
        </tr>
        <tr>
            <th scope="row">نوع ارضيات المدخل</th>
            <td>
                <?php $va4lll = \App\Models\EstateInput::where('key','نوع ارضيات المدخل')->first(); ?>
                {{ $va4lll->value ?? '----' }}

            </td>
        </tr>
        <tr>
            <th scope="row">ارضيات الملحق الخارجي</th>
            <td>
                <?php $vallll = \App\Models\EstateInput::where('key','نوع ارضيات الملحق الخارجي')->first(); ?>
                {{ $vallll->value ?? '----' }}

            </td>
        </tr>
        <tr>
            <th scope="row">ارضيات غرفة السائق/الحارس</th>
            <td>
                <?php $valllll = \App\Models\EstateInput::where('key','نوع ارضيات غرفة السائق / الحارس')->first(); ?>
                {{ $valllll->value ?? '----' }}

            </td>
        </tr>
        <tr>
            <th scope="row">البيئة الخارجية</th>
            <td>
                <?php $vl = \App\Models\EstateInput::where('key','البيئة الخارجية')->first(); ?>
                {{ $vl->value ?? '----' }}
            </td>
        </tr>
        <tr>
            <th scope="row">الشوارع المحيطة</th>
            <td>
                <?php $vla = \App\Models\EstateInput::where('key','الشوارع المحيطة')->first(); ?>
                {{ $vla->value ?? '----' }}
            </td>
        </tr>
        <tr>
            <th scope="row">مستوى العقار عن الشارع</th>
            <td>
                <?php $vlla = \App\Models\EstateInput::where('key','مستوى العقار عن الشارع')->first(); ?>
                {{ $vlla->value ?? '----' }}
            </td>
        </tr>
        <tr>
            <th scope="row">حالة الجدران الخارجية</th>
            <td>
                <?php $vlala = \App\Models\EstateInput::where('key','حالة الجدران الخارجية')->first(); ?>
                {{ $vlala->value ?? '----' }}
            </td>
        </tr>
        <tr>
            <th scope="row">حالة الارضيات الخارجية</th>
            <td>
                <?php $vlaala = \App\Models\EstateInput::where('key','حالة الارضيات الخارجية')->first(); ?>
                {{ $vlaala->value ?? '----' }}
            </td>
        </tr>
        </tbody>
    </table>
    <br>
    <p style="color: blue">الاعمال الانشائية:</p>
    <table class="table">
        <tbody>
        <tr>
            <th scope="row">الهيكل الانشائي</th>
            <td>
                <?php $vlaalla = \App\Models\EstateInput::where('key','الهيكل الانشائي')->first(); ?>
                {{ $vlaalla->value ?? '----' }}
            </td>
        </tr>
        <tr>
            <th scope="row">نوع التكييف</th>
            <td>
                <?php $vlaalla1 = \App\Models\EstateInput::where('key','نوع التكييف')->first(); ?>
                {{ $vlaalla1->value ?? '----' }}
            </td>
        </tr>
        <tr>
            <th scope="row">نوع الاسقف</th>
            <td>
                <?php $vlaalla2 = \App\Models\EstateInput::where('key','نوع الاسقف')->first(); ?>
                {{ $vlaalla2->value ?? '----' }}
            </td>
        </tr>
        <tr>
            <th colspan="2" scope="row">ملاحظات: لا يوجد</th>
        </tr>
        </tbody>
    </table>
</div>

<p class="new-page"></p>

<div style="text-align: right;direction: rtl" class="page">
    <p style="color: blue">معلومات العقار الداخلية:</p>
    <table class="table">
        <tbody>
        <tr>
            <th scope="row">شاغرية العقار</th>
            <td>

                <?php $vlaalla3 = \App\Models\EstateInput::where('key',' شاغرية العقار')->first(); ?>
                {{ $vlaalla3->value ?? '----' }}
            </td>
        </tr>
        <tr>
            <th scope="row">نوع الابواب الداخلية</th>
            <td>
                <?php $vlaalla4 = \App\Models\EstateInput::where('key','نوع الابواب الداخلية')->first(); ?>
                {{ $vlaalla4->value ?? '----' }}
            </td>
        </tr>
        <tr>
            <th scope="row">نوع ارضيات المباني</th>
            <td>
                <?php $vlaalla5 = \App\Models\EstateInput::where('key','نوع ارضيات المباني')->first(); ?>
                {{ $vlaalla5->value ?? '----' }}
            </td>
        </tr>
        <tr>
            <th scope="row">نوع الدرج الداخلي</th>
            <td>
                <?php $vlaalla6 = \App\Models\EstateInput::where('key','نوع الدرج الداخلي')->first(); ?>
                {{ $vlaalla6->value ?? '----' }}
            </td>
        </tr>
        <tr>
            <th scope="row">محتويات المبنى</th>
            <td>
                <?php $vlaalla7 = \App\Models\EstateInput::where('key','محتويات المبنى')->first(); ?>
                {{ $vlaalla7->value ?? '----' }}

            </td>
        </tr>
        <tr>
            <th scope="row">حالة الجدران الداخلية</th>
            <td>
                <?php $vlaalla8 = \App\Models\EstateInput::where('key','حالة الجدران الداخلية')->first(); ?>
                {{ $vlaalla8->value ?? '----' }}
            </td>
        </tr>
        <tr>
            <th scope="row">حالة الارضيات الداخلية</th>
            <td>
                <?php $vlaalla9 = \App\Models\EstateInput::where('key','حالة الارضيات الداخلية')->first(); ?>
                {{ $vlaalla9->value ?? '----' }}
            </td>
        </tr>
        <tr>
            <th scope="row">حالة الاسقف الداخلية</th>
            <td>
                <?php $vlaalla39 = \App\Models\EstateInput::where('key','حالة الاسقف الداخلية')->first(); ?>
                {{ $vlaalla39->value ?? '----' }}
            </td>
        </tr>
        </tbody>
    </table>
    <br>
    <p style="color: blue">الحالة الانشائية:</p>
    <table class="table">
        <tbody>
        <tr>
            <th scope="row">الاساسات / الانشاءات</th>
            <td>
                <?php $vl1 = \App\Models\EstateInput::where('key','الاساسات \ الانشاءات')->first(); ?>
                {{ $vl1->value ?? '----' }}
            </td>
        </tr>
        <tr>
            <th scope="row">الاعمدة / الجدران الحاملة</th>
            <td>
                <?php $vl2 = \App\Models\EstateInput::where('key','الاعمدة \ الجدران الحاملة')->first(); ?>
                {{ $vl2->value ?? '----' }}
            </td>
        </tr>
        <tr>
            <th scope="row">الاسقف الخرسانية</th>
            <td>
                <?php $vl3 = \App\Models\EstateInput::where('key','الاسقف الخرسانية')->first(); ?>
                {{ $vl3->value ?? '----' }}
            </td>
        </tr>
        <tr>
            <th scope="row">نتيجة فحص الاساسات / الانشاءات</th>
            <td>
                <?php $vl4 = \App\Models\EstateInput::where('key','نتيجة فحص الاساسات \ الانشاءات')->first(); ?>
                {{ $vl4->value ?? '----' }}
            </td>
        </tr>
        <tr>
            <th scope="row">نتيجة فحص الاعمدة / الجدران الحاملة</th>
            <td>
                <?php $vl5 = \App\Models\EstateInput::where('key','الاعمدة \ الجدران الحاملة')->first(); ?>
                {{ $vl5->value ?? '----' }}
            </td>
        </tr>
        <tr>
            <th colspan="2" scope="row"> ملاحظات: .....</th>
        </tr>
        </tbody>
    </table>
    <br>
    <p style="color: blue">مطابقة مستندات العقار:</p>
    <table class="table">
        <tbody>
        <tr>
            <?php
            $vl7 = \App\Models\EstateInput::where('key','رخصة البناء مطابقة للطبيعة')->first();
            $vl8 = \App\Models\EstateInput::where('key','قرار الذرعة مطابق للطبيعة')->first();
            $vl9 = \App\Models\EstateInput::where('key','كروكي تنظيمي مطابق للطبيعة')->first();
            $vl10 = \App\Models\EstateInput::where('key','الصك مطابق للموقع')->first();
            ?>

            <td>
                الصك مطابق للموقع
                -->{{ $vl10->value ?? '------' }}
                -
                رخصة البناء مطابقة للطبيعة
                -->{{ $vl7->value ?? '----' }}
                -
                قرار الذرعة مطابق للطبيعة
                -->{{ $vl8->value ?? '------' }}
                -
                كروكي تنظيمي مطابق للطبيعة
                -->{{ $vl9->value ?? '------' }}
            </td>
        </tr>
        <tr>
            <td>
                ملاحظات:
            </td>
        </tr>
        </tbody>
    </table>
</div>

<p class="new-page"></p>

<div style="text-align: right;direction: rtl" class="page">
    <b style="color: blue">روابط مستندات العقار:</b>
    @foreach($estate->file_urls as $file_url)
        {{ $file_url }}
        <br>
    @endforeach
</div>
@if($estate->image_url)
<p class="new-page"></p>

<div style="text-align: right;direction: rtl" class="page">
    <b style="color: blue">صور العقار:</b>

    <img src="{{ $estate->image_url }}">
    <br>
</div>
@endif
<p class="new-page"></p>

<div style="text-align: right;direction: rtl" class="page">
    <b style="color: blue">الافتراضات الخاصة:</b>
    <p>
        (لا يوجد افتراضات خاصة)
    </p>
    <b style="color: blue">الافتراضات والاشتراطات والقيود العامة:</b>
    <p>
        1- قام بإعداد مهمة التقييم والتقرير مقيمون ممتثلون لمتطلبات معايير التقييم الدولية (2022) الصادرة عن مجلس معايير
        التقييم الدولية ((IVSC ودليل الممارسة المهنية لمقيمي العقار الذي نشرته الهيئة السعودية للمقيمين المعتمدين. قد
        تكون التقييمات خاضعة لرقابة الهيئة السعودية للمقيمين المعتمدين
        <br>
        2- باستثناء ما قد ينص عليه خلاف ذلك في خطاب التكليف، فإن التقييم والتقرير سري ولا يجوز استخدامه من قبل أي شخص
        آخر غير الطرف المرسل إليه وللغرض الذي تم إعداده. لا يجوز نشره كلياً أو جزئياً، ولا يشار إليها في أي وثيقة أو
        بيان أو تعميم أو نقلها بأي طريقة أخرى إلى أي طرف آخر أو العامة دون موافقتنا الخطية المسبقة.
        <br>
        3- لا تقبل أي مسؤولية على الإطلاق لأي طرف آخر إلا على أساس تعلیمات مكتوبة ومتفق عليها وعلى دفع رسوم إضافية. لا
        يجوز تقديم أي مطالبة ناشئة عن أو متعلقة بهذا التقييم والتقرير ضد أي عضو او موظف أو شريك أو استشاري في مؤسسة
        الأفكار العالمية. لا يتحمل أي عضو أو موظف أو شريك أو استشاري أي واجب شخصي للعناية بالعميل أو أي طرف آخر، ويجب
        تقديم أي مطالبة بالتعويض عن الخسائر ضد مؤسسة الأفكار العالمية.
        <br>
        4- إذا تمت الإشارة إلى التقييم والتقرير أو تضمینهما في أي مادة أو نشرة، فإن التقييم والتقرير يعتبران مشار إليهما
        أو مدرجين لأغراض المعلومات فقط و مؤسسة الأفكار العالمية وموظفيها والمقيم لا يتحملون اي مسؤولية تجاه المستفيدين
        من هذه المواد، ولا تتحمل مؤسسة الأفكار العالمية أي مسئولية تجاه أي طرف آخر غير العميل لإعداد التقرير.
        <br>
        5- إذا كانت هناك شكوى، فإننا نؤكد أن لدينا إجراءات التعامل مع الشكاوي، والتي سيتم توفير نسخة منها عند الطلب
        <br>
        6- في حالة وجود مطالبة ضد مؤسسة الأفكار العالمية أو احد فروعها التابعة لها أو موظفيها أو المقيم فيما يتعلق بهذا
        التقييم والتقرير أو هذه المهمة بأي شكل من الأشكال، فإن الحد الأقصى للأضرار القابلة للاسترداد يجب أن يكون المبلغ
        النقدي الذي حققته مؤسسة الأفكار العالمية أو احد فروعها التابعة لها من التقييم والتقرير ولا يجوز في أي حال من
        الأحوال أي مطالبة بالتعويض عن الأضرار اللاحقة
        <br>
        7- نحن لا نقوم بإجراء عمليات بحث عن حقوق الملكية ولا نطلع على وثائق الملكية والتأجير. ما لم نعلم ونعلن خلاف ذلك،
        فإننا نفترض أن كل عقار له صك ملكية وقابل للتسويق، وأن جميع الوثائق موجودة، وأنه لا توجد قيود أو حدود أو ارتفاقات
        أو مصروفات تؤثر على العقار، أو دعوى مادية معلقة. قد يستند التقييم والتقرير إلى ملخصات الإيجار التي يقدمها العميل
        أو أطراف ثالثة. ونحن لا نتحمل أي مسؤولية عن صحة أو اكتمال معلومات الإيجار التي تم تقديمها، ولا ينبغي الاعتماد
        على أي تفسير قدمناه فيما يتعلق بأي وثائق من هذا القبيل تم الحصول عليها دون التحقق من المحامين.
        <br>
        8- تم الحصول على المعلومات الواردة في التقييم والتقرير أو التي يستند إليها التقييم والتقرير من العميل والمصادر
        الأخرى المدرجة فيه والتي اعتبرناها موثوقة. وما لم ينص على خلاف ذلك في التقييم والتقرير، فإننا لم نتحقق من هذه
        المعلومات وافترضنا أنها كاملة و موثوقة وصحيحة، ولا نقبل أي مسؤولية على الإطلاق عن مدى اكتمال هذه المعلومات
        ودقتها. يلتزم أي مستخدم مصرح له بالتقييم والتقرير بإبلاغنا باي أخطاء يعتقد انها مضمنة في التقرير
        <br>
        9- نفترض أن الملكية تتوافق مع جميع المتطلبات القانونية ذات الصلة بما في ذلك، على سبيل المثال لا الحصر، تخطيط
        المدن، وأنظمة الحريق والبناء، شهادات الإشغال والموافقات الحكومية الأخرى. إن أي استفسارات شفوية أو الكترونية من
        سلطات التخطيط المعنية تم اتخاذها بدقة لمساعدتنا في تطوير رأي حول قيمة العقار. ومن أجل التأکد نوصي المحامين
        بالتحقق رسمياً من هذه المعلومات وموقفها فيما يتعلق بأي مسائل قانونية مشار إليها في التقييم والتقرير.
        <br>
        10- إن الاستنتاجات والآراء، بما في ذلك رأي القيمة، وأي تنبؤات بالطلب والعرض، ومعدلات الإيجار، والإيرادات
        والمصروفات التي تستند إليها هذه الاستنتاجات والاراء قد تكون فقط في التاريخ المذكور في التقييم والتقرير، وهي تعكس
        أفضل رأي عن التصور السوق الحالي وتوقعات السوق وأداء العقار في المستقبل المنظور تحت الإدارة المختصة. يتقلب سوق
        العقارات باستمرار ولا يمكن التنبؤ بالمستقبل ولا أن نقدم أي ضمان بتحققها. يمكن للتغيرات في عوامل السوق أو في
        العقارات أن تؤثر بشكل كبير على مثل هذه الاستنتاجات والآراء
        <br>
        11- وباستثناء ما قد ينص عليه خلاف ذلك في خطاب التكليف، لا يجب على مؤسسة الأفكار العالمية أو أي فرد يوقع هذا
        التقييم والتقرير أو له علاقة بالتكليف تقديم شهادة في أي محكمة أو إجراء قانوني يتعلق بالعقار أو التقييم أو
        التقرير.
        <br>
        12- عند فحص العقار كجزء من نطاق العمل، يعتمد التقييم والتقرير على المعاينة البصرية للعقار و يعکس العيوب أو
        العناصر الواضحة والتي لا يتم استبعادها صريحاً بموجب اقتراض خاص. ما لم نصدر تعليمات صريحة، فإننا لا نقوم پاجراء
        دراسات مسح للمواقع أو التقييمات البيئية أو استبيانات، أو خدمات فحص المباني او التحقيق في السجلات التاريخية
        لتحديد التلوث الحالي أو السابق للعقار. نحن نفترض أنه لا توجد ظروف مخفية أو غير ملائمة في باطن الأرض أو الهياكل
        أو الخدمات التي تؤثر على قيمة العقار، بما في ذلك على سبيل المثال، العيوب الهيكلية أو المعدات الميكانيكية المختلة
        أو السباكة أو المكونات الكهربائية ووجود مواد خطرة أو سامة محتملة استخدمت في بناء او تعديل أو صيانة التحسينات أو
        تقع عند العقار او حوله.
        <br>
        13- يعكس تقييمنا وتقديرنا إدراكنا لمفاهيم السوق المحتملة لعقود المستأجرين، وما لم يتم إصدار تعليمات محددة، فإننا
        لا نتحقق من الوضع المالي للمستأجرين، وما لم يتم إبلاغنا بخلاف ذلك، نفترض أنهم يستطيعون الوفاء بالتزامات الإيجار
        الخاصة بهم
        <br>
        14- ولا يعتير تقييمنا وتقريرنا بمثابة نصيحة استثمارية أو توصية لاقتراض أو إقراض العقار، إذا قدم التقييم والتقرير
        إلى مقرض أو مستثمر موافقتنا الخطية المسبقة، فيجب على ذلك الطرف النظر في اعتبارات الاستثمار المستقلة ومعايير
        الاكتتاب في قراره الاستثماري. ينصح لذلك الطرف أن يفهم نطاق العمل بشكل عام، وجميع الافتراضات والافتراضات الخاصة
        والقيود المتضمنة في هذا التقييم والتقرير.
        <br>
        15- ما لم يشار إلى خلاف ذلك في التقييم والتقرير، عادة ما يتم التعبير عن رأي القيمة باستثناء أي تكاليف المعاملات
        أ، الزكاة والضرائب. وعلاوة على ذلك، يتم تقييم العقارات بغض النظر عن أي رهون عقارية أو التزامات أخرى.
        <br>
        16- قبول أو استخدام هذا التقييم و التقرير يشكل قبولا للافتراضات و القيود السابقة.
        <br>
        17- لم يتوفر لفريق التقييم امكانية تقييم الموقع البيئي وعلى هذا نفترض استثنائيا ان العقار موضع التقييم لا يحتوي
        على اي مواد خطرة بيئيا.
    </p>
</div>

<p class="new-page"></p>

<div style="text-align: right;direction: rtl" class="page">
    <b style="color: blue">مكان العقار على الخريطة:</b>
    <iframe
            width="300"
            height="170"
            frameborder="0"
            scrolling="no"
            marginheight="0"
            marginwidth="0"
            src="https://maps.google.com/maps?q='+{{ $estate->lat }}+','+{{ $estate->lat }}+'&hl=es&z=14&amp;output=embed"
    >
    </iframe>
</div>
{{----}}

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.min.js"
        integrity="sha384-cVKIPhGWiC2Al4u+LWgxfKTRIcfu0JTxR+EQDz/bgldoEyl4H0zUF0QKbrJ0EcQF"
        crossorigin="anonymous"></script>
</body>
</html>
