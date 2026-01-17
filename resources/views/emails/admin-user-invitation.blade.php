<!DOCTYPE html>
<html>

<head>
    <meta charset="UTF-8">
    <title>User Invitation</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
</head>

<body style="margin:0; padding:0; background-color:#f9fafb; font-family: Arial, sans-serif;">

    <table width="100%" cellpadding="0" cellspacing="0" role="presentation">

        <tr>

            <td align="center" style="padding: 20px;">

                <!-- Container -->

                <table width="100%" cellpadding="0" cellspacing="0" role="presentation"
                    style="max-width:600px; background:#ffffff; border-radius:6px;">

                    <tr>
                        <td style="padding:30px;">

                            <h2 style="margin-top:0;">
                                You've been invited
                            </h2>

                            <p>
                                You have been invited to manage <strong>{{ $company->name }}</strong> as an
                                <strong>{{ $role }}</strong>.
                            </p>

                            @if ($role === 'admin')
                                <p>
                                    As an admin, you'll be able to manage users, settings, and links for this company.
                                </p>
                            @elseif ($role === 'member')
                                <p>
                                    As a member, you'll be able to create and manage links for this company.
                                </p>
                            @endif

                            <p style="margin:30px 0;">

                                <a href="{{ $acceptUrl }}"
                                    style="background-color:#2563eb;color:#ffffff;padding:12px 20px; text-decoration:none; border-radius:4px; display:inline-block;">
                                    Accept Invitation
                                </a>

                            </p>

                            <p style="color:#6b7280; font-size:14px;">
                                This invitation will expire in 72 hours.
                            </p>

                            <hr style="margin:30px 0; border:none; border-top:1px solid #e5e7eb;">

                            <p style="color:#6b7280; font-size:12px;">
                                If you were not expecting this invitation, you can safely ignore this email.
                            </p>

                        </td>
                    </tr>
                </table>

                <p style="margin-top:20px; font-size:12px; color:#9ca3af;">
                    © {{ date('Y') }} Linksy. All rights reserved.
                </p>

            </td>
        </tr>
    </table>

</body>

</html>
