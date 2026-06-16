<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Password Reset OTP</title>
</head>

<body style="margin:0; padding:0; background-color:#f4f4f4; font-family:Arial, sans-serif;">

    <table width="100%" cellpadding="0" cellspacing="0" style="background:#f4f4f4; padding:20px;">
        <tr>
            <td align="center">

                <!-- MAIN BOX -->
                <table width="500" cellpadding="0" cellspacing="0" style="background:#ffffff; border-radius:10px; overflow:hidden; box-shadow:0 4px 10px rgba(0,0,0,0.1);">

                    <!-- HEADER -->
                    <tr>
                        <td style="background:#000; text-align:center; padding:20px;">
                            <img src="{{ asset('assets/images/new-images/logo.png') }}"
                                 alt="Mahaguru"
                                 style="max-width:150px;">
                        </td>
                    </tr>

                    <!-- CONTENT -->
                    <tr>
                        <td style="padding:30px; text-align:center;">

                            <h2 style="margin:0; color:#333;">Password Reset Request</h2>

                            <p style="color:#555; margin-top:10px;">
                                Use the OTP below to reset your password.
                            </p>

                            <!-- OTP BOX -->
                            <div style="margin:25px 0;">
                                <span style="
                                    display:inline-block;
                                    font-size:32px;
                                    font-weight:bold;
                                    letter-spacing:8px;
                                    color:#000;
                                    background:#f2f2f2;
                                    padding:15px 25px;
                                    border-radius:8px;">
                                    {{ $otp }}
                                </span>
                            </div>

                            <p style="color:#777; font-size:14px;">
                                This OTP is valid for <strong>10 minutes</strong>.
                            </p>

                            <p style="color:#999; font-size:13px; margin-top:20px;">
                                If you didn’t request this, please ignore this email.
                            </p>

                        </td>
                    </tr>

                    <!-- FOOTER -->
                    <tr>
                        <td style="background:#f9f9f9; padding:20px; text-align:center; font-size:13px; color:#555;">

                            <strong>Mahaguru Boutique</strong><br><br>

                            Address:<br>
                            3/2- Raju Nagar, Vasiyapuram,<br>
                            Zamin Uthukuli (PO), Pollachi - 642004<br><br>

                            Email: ananya.priya9597@gmail.com<br>
                            Phone: +91 9597990975

                        </td>
                    </tr>

                </table>

            </td>
        </tr>
    </table>

</body>
</html>