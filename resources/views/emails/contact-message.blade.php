<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>New Contact Enquiry</title>
</head>
<body style="margin:0;padding:0;background:#f4f5f7;font-family:Arial,Helvetica,sans-serif;color:#17191d">
    <div style="max-width:560px;margin:0 auto;padding:32px 20px">
        <h2 style="margin:0 0 20px;font-size:20px;color:#17191d">New Contact Enquiry</h2>

        <table style="width:100%;border-collapse:collapse;background:#fff;border:1px solid #e8e5de;border-radius:8px;overflow:hidden">
            <tr>
                <td style="padding:12px 16px;border-bottom:1px solid #e8e5de;width:120px;color:#6b7078;font-size:13px">Name</td>
                <td style="padding:12px 16px;border-bottom:1px solid #e8e5de;font-size:14px">{{ $contactMessage->name }}</td>
            </tr>
            <tr>
                <td style="padding:12px 16px;border-bottom:1px solid #e8e5de;color:#6b7078;font-size:13px">Email</td>
                <td style="padding:12px 16px;border-bottom:1px solid #e8e5de;font-size:14px"><a href="mailto:{{ $contactMessage->email }}">{{ $contactMessage->email }}</a></td>
            </tr>
            @if($contactMessage->phone)
                <tr>
                    <td style="padding:12px 16px;border-bottom:1px solid #e8e5de;color:#6b7078;font-size:13px">Phone</td>
                    <td style="padding:12px 16px;border-bottom:1px solid #e8e5de;font-size:14px">{{ $contactMessage->phone }}</td>
                </tr>
            @endif
            @if($contactMessage->subject)
                <tr>
                    <td style="padding:12px 16px;border-bottom:1px solid #e8e5de;color:#6b7078;font-size:13px">Subject</td>
                    <td style="padding:12px 16px;border-bottom:1px solid #e8e5de;font-size:14px">{{ $contactMessage->subject }}</td>
                </tr>
            @endif
            <tr>
                <td style="padding:12px 16px;color:#6b7078;font-size:13px;vertical-align:top">Message</td>
                <td style="padding:12px 16px;font-size:14px;white-space:pre-line">{{ $contactMessage->message }}</td>
            </tr>
        </table>

        <p style="margin:20px 0 0;font-size:12px;color:#6b7078">
            Submitted {{ $contactMessage->created_at->format('d M Y, h:i A') }} via the Yellow Achiever's Award website contact form.
            Reply directly to this email to respond to {{ $contactMessage->name }}.
        </p>
    </div>
</body>
</html>
