<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title')</title>
    <style>
        body {
            background-color: #FAF9F6;
            font-family: 'Poppins', 'Helvetica Neue', Helvetica, Arial, sans-serif;
            margin: 0;
            padding: 0;
            -webkit-font-smoothing: antialiased;
        }
        .wrapper {
            background-color: #FAF9F6;
            width: 100%;
            padding: 40px 0;
        }
        .container {
            max-width: 600px;
            margin: 0 auto;
            background-color: #FFFFFF;
            border-radius: 16px;
            overflow: hidden;
            box-shadow: 0 8px 30px rgba(255, 122, 0, 0.05);
            border: 1px solid rgba(255, 122, 0, 0.1);
        }
        .header {
            background-color: #0E101A;
            padding: 30px;
            text-align: center;
            border-bottom: 5px solid #FF7A00;
        }
        .logo {
            font-family: 'Outfit', sans-serif;
            font-weight: 800;
            font-size: 28px;
            color: #FFFFFF;
            text-decoration: none;
        }
        .logo span {
            color: #FF7A00;
        }
        .content {
            padding: 40px 30px;
            color: #0E101A;
            line-height: 1.6;
            font-size: 15px;
        }
        .btn-action {
            display: inline-block;
            background: linear-gradient(135deg, #FF7A00 0%, #E26C00 100%);
            color: #FFFFFF !important;
            padding: 12px 30px;
            border-radius: 8px;
            text-decoration: none;
            font-weight: 600;
            margin: 20px 0;
            text-align: center;
            box-shadow: 0 4px 15px rgba(255, 122, 0, 0.2);
        }
        .footer {
            background-color: #0E101A;
            color: #A5B4FC;
            padding: 30px;
            text-align: center;
            font-size: 12px;
            border-top: 1px solid rgba(255,255,255,0.08);
        }
        .footer a {
            color: #FF7A00;
            text-decoration: none;
        }
        .highlight {
            font-size: 24px;
            font-weight: 700;
            color: #FF7A00;
            letter-spacing: 4px;
            text-align: center;
            padding: 15px;
            background-color: #FAF9F6;
            border-radius: 8px;
            margin: 20px 0;
            border: 1px dashed #FF7A00;
        }
        .table-data {
            width: 100%;
            border-collapse: collapse;
            margin: 20px 0;
        }
        .table-data th {
            text-align: left;
            padding: 10px;
            border-bottom: 2px solid #e9ecef;
            color: #6c757d;
        }
        .table-data td {
            padding: 10px;
            border-bottom: 1px solid #e9ecef;
        }
    </style>
</head>
<body>
    <div class="wrapper">
        <div class="container">
            <div class="header">
                <a href="{{ url('/') }}" class="logo">GOS <span>MOMO</span></a>
            </div>
            <div class="content">
                @yield('content')
            </div>
            <div class="footer">
                <div style="margin-bottom: 15px;">
                    <span style="color:#ffffff; font-weight:bold; font-size:14px;">GOS MOMO — The Taste India Will Queue For</span>
                </div>
                <p>&copy; {{ date('Y') }} GOS MOMO. All Rights Reserved.</p>
                <p>{{ setting('head_office_address', 'Noida, Uttar Pradesh, India') }} | Phone: {{ setting('contact_phone', '+91 88888 77777') }}</p>
                <p>If you have any questions, feel free to contact us at <a href="mailto:{{ setting('contact_email', 'info@gosmomo.com') }}">{{ setting('contact_email', 'info@gosmomo.com') }}</a></p>
            </div>
        </div>
    </div>
</body>
</html>
