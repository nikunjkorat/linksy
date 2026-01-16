<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Admin Invitation</title>
</head>
<body style="font-family: Arial, sans-serif; background-color: #f9fafb; padding: 30px;">

    <table width="100%" cellpadding="0" cellspacing="0">
        <tr>
            <td align="center">
                <table width="600" style="background: #ffffff; padding: 30px; border-radius: 6px;">
                    <tr>
                        <td>

                            <h2 style="margin-top: 0;">
                                You've been invited
                            </h2>

                            <p>
                                You have been invited to manage
                                <strong>{{ $company->name }}</strong>
                                as an <strong>Admin</strong>.
                            </p>

                            <p>
                                As an admin, you'll be able to manage users,
                                settings, and links for this company.
                            </p>

                            <p style="margin: 30px 0;">
                                <a href="{{ $acceptUrl }}"
                                   style="
                                     background-color: #2563eb;
                                     color: #ffffff;
                                     padding: 12px 20px;
                                     text-decoration: none;
                                     border-radius: 4px;
                                     display: inline-block;
                                   ">
                                    Accept Invitation
                                </a>
                            </p>

                            <p style="color: #6b7280; font-size: 14px;">
                                This invitation will expire in 72 hours.
                            </p>

                            <hr style="margin: 30px 0;">

                            <p style="color: #6b7280; font-size: 12px;">
                                If you were not expecting this invitation,
                                you can safely ignore this email.
                            </p>

                        </td>
                    </tr>
                </table>

                <p style="margin-top: 20px; font-size: 12px; color: #9ca3af;">
                    © {{ date('Y') }} URL Shortener
                </p>
            </td>
        </tr>
    </table>

</body>
</html>
