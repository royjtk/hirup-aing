# Email Configuration Guide

## Overview
This guide explains how to set up email notifications for the Laravel Todo List application. The application uses the Laravel mail system to send notifications for task invitations and other events.

## Configuration Options

### Option 1: Mailtrap (Recommended for Development)

1. Create a free [Mailtrap](https://mailtrap.io/) account
2. Navigate to your inbox and click on SMTP Settings
3. Copy the credentials provided by Mailtrap
4. Update your `.env` file with the following values:

```
MAIL_MAILER=smtp
MAIL_HOST=smtp.mailtrap.io
MAIL_PORT=2525
MAIL_USERNAME=your_mailtrap_username
MAIL_PASSWORD=your_mailtrap_password
MAIL_ENCRYPTION=tls
MAIL_FROM_ADDRESS=taskmanager@example.com
MAIL_FROM_NAME="${APP_NAME}"
```

### Option 2: SMTP Server (Gmail, etc.)

To use Gmail or another SMTP service:

```
MAIL_MAILER=smtp
MAIL_HOST=smtp.gmail.com
MAIL_PORT=587
MAIL_USERNAME=your_gmail_address@gmail.com
MAIL_PASSWORD=your_app_password
MAIL_ENCRYPTION=tls
MAIL_FROM_ADDRESS=your_gmail_address@gmail.com
MAIL_FROM_NAME="${APP_NAME}"
```

**Note for Gmail**: You need to generate an App Password if you have 2FA enabled.

### Option 3: Log Driver (Testing Without Sending Emails)

For testing without sending actual emails, use the log driver. Emails will be written to the Laravel log file.

```
MAIL_MAILER=log
```

## Testing Email Configuration

You can test your email configuration by running:

```bash
php artisan tinker
```

Then execute:

```php
Mail::raw('Test email from Laravel', function($message) { $message->to('your-email@example.com')->subject('Test Email'); });
```

If using Mailtrap, you should see the email appear in your Mailtrap inbox.

## Debugging Email Issues

If you're experiencing issues with email sending:

1. Check your Laravel logs at `storage/logs/laravel.log`
2. Verify your SMTP credentials are correct
3. Make sure your mail service provider allows SMTP connections
4. Check if there are any firewalls blocking outbound SMTP connections
