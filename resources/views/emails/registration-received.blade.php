<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>New Registration</title>
</head>
<body style="margin:0;padding:0;background:#f4f5f7;font-family:Arial,Helvetica,sans-serif;color:#17191d">
    <div style="max-width:560px;margin:0 auto;padding:32px 20px">
        <h2 style="margin:0 0 20px;font-size:20px;color:#17191d">New Registration</h2>

        <table style="width:100%;border-collapse:collapse;background:#fff;border:1px solid #e8e5de;border-radius:8px;overflow:hidden">
            <tr>
                <td style="padding:12px 16px;border-bottom:1px solid #e8e5de;width:140px;color:#6b7078;font-size:13px">Name</td>
                <td style="padding:12px 16px;border-bottom:1px solid #e8e5de;font-size:14px">{{ $registration->full_name }}</td>
            </tr>
            <tr>
                <td style="padding:12px 16px;border-bottom:1px solid #e8e5de;color:#6b7078;font-size:13px">Email</td>
                <td style="padding:12px 16px;border-bottom:1px solid #e8e5de;font-size:14px"><a href="mailto:{{ $registration->email }}">{{ $registration->email }}</a></td>
            </tr>
            <tr>
                <td style="padding:12px 16px;border-bottom:1px solid #e8e5de;color:#6b7078;font-size:13px">Phone</td>
                <td style="padding:12px 16px;border-bottom:1px solid #e8e5de;font-size:14px">{{ $registration->phone }}</td>
            </tr>
            <tr>
                <td style="padding:12px 16px;border-bottom:1px solid #e8e5de;color:#6b7078;font-size:13px">Event</td>
                <td style="padding:12px 16px;border-bottom:1px solid #e8e5de;font-size:14px">{{ $registration->event->title ?? 'General' }}</td>
            </tr>
            @if($registration->organization)
                <tr>
                    <td style="padding:12px 16px;border-bottom:1px solid #e8e5de;color:#6b7078;font-size:13px">Organization</td>
                    <td style="padding:12px 16px;border-bottom:1px solid #e8e5de;font-size:14px">{{ $registration->organization }}</td>
                </tr>
            @endif
            @if($registration->industry)
                <tr>
                    <td style="padding:12px 16px;border-bottom:1px solid #e8e5de;color:#6b7078;font-size:13px">Industry</td>
                    <td style="padding:12px 16px;border-bottom:1px solid #e8e5de;font-size:14px">{{ $registration->industry }}</td>
                </tr>
            @endif
            @if($registration->registration_type)
                <tr>
                    <td style="padding:12px 16px;border-bottom:1px solid #e8e5de;color:#6b7078;font-size:13px">Registration Type</td>
                    <td style="padding:12px 16px;border-bottom:1px solid #e8e5de;font-size:14px">{{ $registration->registration_type }}</td>
                </tr>
            @endif
            @if($registration->photo)
                <tr>
                    <td style="padding:12px 16px;border-bottom:1px solid #e8e5de;color:#6b7078;font-size:13px">Photo</td>
                    <td style="padding:12px 16px;border-bottom:1px solid #e8e5de;font-size:14px"><a href="{{ \Illuminate\Support\Facades\Storage::url($registration->photo) }}">View Photo</a></td>
                </tr>
            @endif
            @if($registration->cv)
                <tr>
                    <td style="padding:12px 16px;border-bottom:1px solid #e8e5de;color:#6b7078;font-size:13px">CV</td>
                    <td style="padding:12px 16px;border-bottom:1px solid #e8e5de;font-size:14px"><a href="{{ \Illuminate\Support\Facades\Storage::url($registration->cv) }}">Download CV</a></td>
                </tr>
            @endif
            @if($registration->message)
                <tr>
                    <td style="padding:12px 16px;color:#6b7078;font-size:13px;vertical-align:top">Message</td>
                    <td style="padding:12px 16px;font-size:14px;white-space:pre-line">{{ $registration->message }}</td>
                </tr>
            @endif
        </table>

        <p style="margin:20px 0 0;font-size:12px;color:#6b7078">
            Submitted {{ $registration->created_at->format('d M Y, h:i A') }} via the Yellow Achiever's Award website.
            Reply directly to this email to respond to {{ $registration->full_name }}.
        </p>
    </div>
</body>
</html>
