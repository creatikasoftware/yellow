<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>New Partner Application</title>
</head>
<body style="margin:0;padding:0;background:#f4f5f7;font-family:Arial,Helvetica,sans-serif;color:#17191d">
    <div style="max-width:560px;margin:0 auto;padding:32px 20px">
        <h2 style="margin:0 0 20px;font-size:20px;color:#17191d">New Partner Application</h2>

        <table style="width:100%;border-collapse:collapse;background:#fff;border:1px solid #e8e5de;border-radius:8px;overflow:hidden">
            <tr>
                <td style="padding:12px 16px;border-bottom:1px solid #e8e5de;width:160px;color:#6b7078;font-size:13px">Full Name</td>
                <td style="padding:12px 16px;border-bottom:1px solid #e8e5de;font-size:14px">{{ $partnerApplication->full_name }}</td>
            </tr>
            <tr>
                <td style="padding:12px 16px;border-bottom:1px solid #e8e5de;color:#6b7078;font-size:13px">Email</td>
                <td style="padding:12px 16px;border-bottom:1px solid #e8e5de;font-size:14px"><a href="mailto:{{ $partnerApplication->email }}">{{ $partnerApplication->email }}</a></td>
            </tr>
            <tr>
                <td style="padding:12px 16px;border-bottom:1px solid #e8e5de;color:#6b7078;font-size:13px">Phone</td>
                <td style="padding:12px 16px;border-bottom:1px solid #e8e5de;font-size:14px">{{ $partnerApplication->phone }}</td>
            </tr>
            @if($partnerApplication->organization)
                <tr>
                    <td style="padding:12px 16px;border-bottom:1px solid #e8e5de;color:#6b7078;font-size:13px">Organisation</td>
                    <td style="padding:12px 16px;border-bottom:1px solid #e8e5de;font-size:14px">{{ $partnerApplication->organization }}</td>
                </tr>
            @endif
            @if($partnerApplication->city_country)
                <tr>
                    <td style="padding:12px 16px;border-bottom:1px solid #e8e5de;color:#6b7078;font-size:13px">City / Country</td>
                    <td style="padding:12px 16px;border-bottom:1px solid #e8e5de;font-size:14px">{{ $partnerApplication->city_country }}</td>
                </tr>
            @endif
            @if($partnerApplication->tier)
                <tr>
                    <td style="padding:12px 16px;border-bottom:1px solid #e8e5de;color:#6b7078;font-size:13px">Tier of Interest</td>
                    <td style="padding:12px 16px;border-bottom:1px solid #e8e5de;font-size:14px">{{ $partnerApplication->tier }}</td>
                </tr>
            @endif
            @if($partnerApplication->business_description)
                <tr>
                    <td style="padding:12px 16px;color:#6b7078;font-size:13px;vertical-align:top">Business / Network</td>
                    <td style="padding:12px 16px;font-size:14px;white-space:pre-line">{{ $partnerApplication->business_description }}</td>
                </tr>
            @endif
        </table>

        <p style="margin:20px 0 0;font-size:12px;color:#6b7078">
            Submitted {{ $partnerApplication->created_at->format('d M Y, h:i A') }} via the Yellow Achiever's Award Partner With Us page.
            Reply directly to this email to respond to {{ $partnerApplication->full_name }}.
        </p>
    </div>
</body>
</html>
