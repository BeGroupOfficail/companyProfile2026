<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Contact Form Submission</title>
    <style>
        body {
            margin: 0;
            padding: 0;
            font-family: 'Arial', sans-serif;
            background-color: #f4f4f4;
        }
        .email-container {
            max-width: 600px;
            margin: 20px auto;
            background-color: #ffffff;
            border-radius: 8px;
            overflow: hidden;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
        }
        .email-header {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: #ffffff;
            padding: 30px;
            text-align: center;
        }
        .email-header h1 {
            margin: 0;
            font-size: 24px;
            font-weight: 600;
        }
        .email-body {
            padding: 30px;
        }
        .intro-text {
            color: #666666;
            font-size: 14px;
            margin-bottom: 25px;
            line-height: 1.6;
        }
        .info-row {
            margin-bottom: 20px;
            border-bottom: 1px solid #eeeeee;
            padding-bottom: 15px;
        }
        .info-row:last-child {
            border-bottom: none;
        }
        .info-label {
            font-weight: 600;
            color: #333333;
            font-size: 13px;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            margin-bottom: 5px;
        }
        .info-value {
            color: #666666;
            font-size: 15px;
            line-height: 1.6;
            word-wrap: break-word;
        }
        .message-box {
            background-color: #f9f9f9;
            border-left: 4px solid #667eea;
            padding: 15px;
            border-radius: 4px;
            margin-top: 8px;
        }
        .email-footer {
            background-color: #f8f8f8;
            padding: 20px;
            text-align: center;
            font-size: 12px;
            color: #999999;
        }
        .divider {
            height: 1px;
            background-color: #eeeeee;
            margin: 25px 0;
        }
        .logo {
            max-width: 150px;
            margin-bottom: 10px;
        }
    </style>
</head>
<body>
    <div class="email-container">
        <div class="email-header">
            @if(isset($setting->logo) && $setting->logo)
                <img src="{{ asset('storage/' . $setting->logo) }}" alt="{{ $setting->site_name ?? 'Logo' }}" class="logo">
            @endif
            <h1>📬 New Contact Form Submission</h1>
        </div>
        
        <div class="email-body">
            <p class="intro-text">
                You have received a new message from your website's contact form. Here are the details:
            </p>

            <div class="info-row">
                <div class="info-label">Name</div>
                <div class="info-value">{{ $user['name'] ?? 'N/A' }}</div>
            </div>

            <div class="info-row">
                <div class="info-label">Email Address</div>
                <div class="info-value">
                    @if(isset($user['contact_email']))
                        <a href="mailto:{{ $user['emacontact_emailil'] }}" style="color: #667eea; text-decoration: none;">{{ $user['contact_email'] }}</a>
                    @else
                        N/A
                    @endif
                </div>
            </div>

            <div class="info-row">
                <div class="info-label">Phone Number</div>
                <div class="info-value">
                    @if(isset($user['phone']))
                        <a href="tel:{{ $user['phone'] }}" style="color: #667eea; text-decoration: none;">{{ $user['phone'] }}</a>
                    @else
                        N/A
                    @endif
                </div>
            </div>

            <div class="info-row">
                <div class="info-label">Message</div>
                <div class="message-box">
                    <div class="info-value">{{ $user['message'] ?? 'No message provided' }}</div>
                </div>
            </div>

            @if(isset($emailContent) && $emailContent)
                <div class="divider"></div>
                <div class="intro-text">{!! $emailContent !!}</div>
            @endif

            <div class="divider"></div>

            <p class="intro-text" style="margin-bottom: 0; font-size: 13px;">
                <strong>Received:</strong> {{ date('F j, Y \a\t g:i A') }}
            </p>
        </div>

        <div class="email-footer">
            <p style="margin: 0;">This email was sent from {{ $setting->website_name ?? 'your website' }}'s contact form.</p>
            <p style="margin: 5px 0 0 0;">&copy; {{ date('Y') }} {{ $setting->website_name ?? 'Your Company' }}. All rights reserved.</p>
            <p style="margin: 5px 0 0 0;">
                <a href="{{ $setting->website_url }}" style="color: #667eea; text-decoration: none;">https://vrfegypt.com/ar</a>
            </p>
        </div>
    </div>
</body>
</html>