@php
    $primary = '#642571';
    $secondary = '#e6227b';
    $text = '#666666';
    $company_name = $company->name;
    $company_email = $company->email;
    $company_phone = '+977 '.$company->phone;
@endphp

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Shop Status Notification</title>
    <script src="https://cdn.jsdelivr.net/npm/@tailwindcss/browser@4"></script>
    <style>
        /* Additional custom styles for better email client compatibility */
        * {
            box-sizing: border-box;
        }
        a {
            text-decoration: none;
        }
        .btn {
            transition: background-color 0.3s ease;
        }
        .btn:hover {
            background-color: #c01c6a !important;
        }
        @media only screen and (max-width: 600px) {
            .container {
                width: 100% !important;
                margin: 20px auto !important;
            }
            .header h1 {
                font-size: 20px !important;
            }
            .body {
                padding: 16px !important;
            }
        }
    </style>
</head>
<body class="bg-gray-100 font-sans" style="margin: 0; padding: 0; background: #f9fafb; font-family: 'Arial', sans-serif; line-height: 1.6;">
    <div class="max-w-xl mx-auto my-10 bg-white shadow-md rounded-lg overflow-hidden container"
        style="max-width: 600px; margin: 40px auto; background: #ffffff; border-radius: 12px; box-shadow: 0 6px 12px rgba(0,0,0,0.1);">

        <!-- Header -->
        <div class="bg-purple-800 text-white text-center py-6 header"
            style="background: {{ $primary }}; color: white; padding: 24px; border-top-left-radius: 12px; border-top-right-radius: 12px;">
            <h1 class="text-3xl font-bold" style="margin: 0; font-size: 24px;">Your Shop is Inactive</h1>
            <p class="text-sm mt-2" style="margin: 8px 0 0; opacity: 0.9;">Let's get your shop back online!</p>
        </div>

        <!-- Body -->
        <div class="p-6 text-gray-700 body" style="padding: 32px; color: {{ $text }};">
            <p class="mb-4" style="margin: 0 0 16px;">Hello, <strong>{{ $shop->name }}</strong>,</p>
            <p class="mb-4" style="margin: 0 0 16px;">We're sorry to inform you that your shop has been marked as <strong>Inactive</strong>.</p>
            <p class="mb-4" style="margin: 0 0 16px;">To reactivate your shop, please contact our support team. We're here to assist you!</p>
            <p class="mb-4" style="margin: 0 0 16px;">
                Reach out to us at:
                <br>
                <a href="mailto:{{ $company_email }}" style="color: {{ $secondary }}; font-weight: bold;">{{ $company_email }}</a>
                <br>
                <a href="tel:{{ $company_phone }}" style="color: {{ $secondary }}; font-weight: bold;">{{ $company_phone }}</a>
            </p>
            <div class="text-center mt-6" style="margin-top: 24px;">
                <a href="mailto:$company_email" class="btn inline-block bg-pink-500 text-white font-semibold py-2 px-6 rounded-lg"
                   style="background: {{ $secondary }}; color: white; padding: 10px 24px; border-radius: 8px; display: inline-block;">
                    Contact Support
                </a>
            </div>
        </div>

        <!-- Footer -->
        <div class="bg-gray-100 text-center text-xs text-gray-500 py-4"
            style="background: #f3f4f6; padding: 16px; font-size: 12px; color: #6b7280; border-bottom-left-radius: 12px; border-bottom-right-radius: 12px;">
            <p style="margin: 0;">&copy; {{ date('Y') }} Thank you for using our marketplace.</p>
            <p style="margin: 8px 0 0;">Need help? Call us at <a href="tel:{{ $company_phone }}" style="color: {{ $secondary }}">{{ $company_phone }}</a></p>
        </div>
    </div>
</body>
</html>
