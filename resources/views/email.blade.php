<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>التقرير الأسبوعي للمقالات</title>
    <style>
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background-color: #f8fafc;
            color: #334155;
            margin: 0;
            padding: 0;
            direction: rtl;
        }
        .wrapper {
            width: 100%;
            table-layout: fixed;
            background-color: #f8fafc;
            padding: 40px 0;
        }
        .main-card {
            max-width: 600px;
            background-color: #ffffff;
            margin: 0 auto;
            border-radius: 12px;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.05);
            border: 1px solid #e2e8f0;
            overflow: hidden;
        }
        .header {
            background: linear-gradient(135deg, #1e3a8a, #3b82f6);
            color: #ffffff;
            padding: 30px;
            text-align: center;
        }
        .header h1 {
            margin: 0;
            font-size: 24px;
            font-weight: 700;
            letter-spacing: -0.5px;
        }
        .content {
            padding: 30px;
        }
        .welcome-text {
            font-size: 16px;
            line-height: 1.6;
            color: #475569;
            margin-bottom: 24px;
        }
        .stats-table {
            width: 100%;
            border-collapse: separate;
            border-spacing: 0;
            margin-top: 16px;
            border-radius: 8px;
            overflow: hidden;
            border: 1px solid #e2e8f0;
        }
        .stats-table th {
            background-color: #f1f5f9;
            color: #1e293b;
            font-weight: 600;
            padding: 14px;
            text-align: right;
            font-size: 14px;
            border-bottom: 2px solid #e2e8f0;
        }
        .stats-table td {
            padding: 14px;
            border-bottom: 1px solid #edf2f7;
            font-size: 14px;
            color: #334155;
        }
        .stats-table tr:last-child td {
            border-bottom: none;
        }
        .badge {
            background-color: #e0f2fe;
            color: #0369a1;
            padding: 4px 8px;
            border-radius: 6px;
            font-size: 12px;
            font-weight: 500;
        }
        .footer {
            background-color: #f8fafc;
            padding: 20px;
            text-align: center;
            font-size: 12px;
            color: #94a3b8;
            border-top: 1px solid #e2e8f0;
        }
    </style>
</head>
<body>

    <div class="wrapper">
        <div class="main-card">
            
            <div class="header">
                <h1>📊 التقرير الأسبوعي للمقالات المنشورة</h1>
            </div>

            <div class="content">
                <p class="welcome-text">
                    مرحباً بك يا مدير النظام،<br>
                    إليك كشفاً تفصيلياً بكافة المقالات التي تم مراجعتها ونشرها بنجاح داخل المنصة خلال السبعة أيام الماضية:
                </p>

                <table class="stats-table">
                    <thead>
                        <tr>
                            <th>عنوان المقال</th>
                            <th>الكاتب</th>
                            <th>تاريخ النشر</th>
                        </tr>
                    </thead>
                    <tbody>
                        {{-- 🎯 حلقة التكرار تقرأ من متغير $data المعرّف في الـ Mailable الخاص بك --}}
                        @forelse($data as $article)
                            <tr>
                                <td>
                                    <strong>{{ $article->title }}</strong>
                                </td>
                                <td>
                                    <span class="badge">{{ $article->user->name ?? 'غير معروف' }}</span>
                                </td>
                                <td>
                                    {{ $article->updated_at->format('Y-m-d') }}
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="3" style="text-align: center; color: #94a3b8; padding: 30px;">
                                    📭 لم يتم نشر أي مقالات خلال هذا الأسبوع.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <div class="footer">
                <p>هذا البريد الإلكتروني يتم توليده وإرساله تلقائياً عبر نظام الجدولة الذكي في لوحة التحكم الخاصة بك.</p>
                <p>&copy; {{ date('Y') }} نظام إدارة النادي الرياضي والمقالات. جميع الحقوق محفوظة.</p>
            </div>

        </div>
    </div>

</body>
</html>