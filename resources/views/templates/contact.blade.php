<!DOCTYPE html>
<html lang='en'>
<head>
    <meta charset='UTF-8'>
    <meta name='viewport' content='width=device-width, initial-scale=1.0'>
    <meta http-equiv='X-UA-Compatible' content='ie=edge'>
</head>
<body style="background-color: #ffffff; margin: 0; padding: 0;">
    <div style="width:100%;padding:20px;background-color:#ffffff;">
        
        <!-- Company Logo -->
        <div style="text-align:center;margin-bottom:30px;">
            <img src="https://dha360.pk/assets/images/logo-transparent.png" alt="Properties" style="max-width: 200px;">
        </div>

        <!-- Main Content with Lightest Gray Background -->
        <div style="width:95%;margin:auto;background-color:#f9f9f9;padding:20px;border-radius:5px;">
            <p>You have a new query from customer. The details are given below:</p>
            <table style="border-collapse:collapse;width:100%;margin-top:20px; margin-bottom:50px;">
                <tr>
                    <th style="border:1px solid #ddd;padding:8px;width:25%;text-align:center;" colspan="2">Details</th>
                </tr>
                <tr>
                    <td style="border:1px solid #ddd;padding:8px;width:25%;">Name</td>
                    <td style="border:1px solid #ddd;padding:8px;width:25%;">{{ $mailData['name'] }}</td>
                </tr>
                <tr>
                    <td style="border:1px solid #ddd;padding:8px;width:25%;">Email</td>
                    <td style="border:1px solid #ddd;padding:8px;width:25%;">{{ $mailData['email'] }}</td>
                </tr>
                <tr>
                    <td style="border:1px solid #ddd;padding:8px;width:25%;">Mobile Number</td>
                    <td style="border:1px solid #ddd;padding:8px;width:25%;">{{ $mailData['mobile'] }}</td>
                </tr>
                <tr>
                    <td style="border:1px solid #ddd;padding:8px;width:25%;">Message</td>
                    <td style="border:1px solid #ddd;padding:8px;width:25%;">{{ $mailData['message'] }}</td>
                </tr>
            </table>
            <hr>
            <!-- Footer with White Background -->
        <footer style="width:95%;margin:auto;margin-top: 30px;padding-top: 20px;border-top: 1px solid #ddd;text-align: center;background-color:#ffffff;">
            <p style="font-size: 12px; color: #666;">
                System generated email and does not require a signature.
            </p>
            <p style="font-size: 12px; color: #666;">
                Please consider the environment before printing this email.
            </p>
            <p style="font-size: 12px; color: #666; margin-top: 20px;">
                Disclaimer: The information transmitted is intended only for the person or the entity to which it is addressed and may contain confidential and/or privileged material. Any review, retransmission, dissemination or other use of, or taking of any action in reliance upon, this information by person or entities other than the intended recipient is prohibited. If you have received this in error, please contact the sender and delete the material from any computer. Please note that any views or opinions presented in this email are solely those of the author and do not necessarily represent those of the company. Finally, the recipient shall check this email and any attachments for the presence of viruses. The company accepts no liability for any damage caused by a virus transmitted by this email.
            </p>
            <p style="font-size: 12px; color: #666; margin-top: 20px; text-align: center;">
                <a href="#" style="color: #007bff; text-decoration: none;">About Us</a> | 
                <a href="#" style="color: #007bff; text-decoration: none;">FAQ</a> | 
                <a href="#" style="color: #007bff; text-decoration: none;">Privacy Policy</a> | 
                <a href="#" style="color: #007bff; text-decoration: none;">Terms & Conditions</a>
            </p>
            <p style="font-size: 12px; color: #666; margin-top: 20px; text-align: center;">
                Islamabad, Pakistan
            </p>
            <p style="font-size: 12px; color: #666; text-align: center;">
                © {{ date('Y') }} Properties DHA 360. All rights reserved.
            </p>

        </footer>
        </div>
    </div>
</body>
</html>
