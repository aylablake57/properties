@extends('guest.layouts.guest')
@section('title') Privacy Policy @endsection
@section('local-style')
    <link href="{{getAdminAsset('css/inner.css')}}?v={{ config('app.version') }}" rel="stylesheet">
@endsection

@section('page')

<div class="explore my-5 py-5">
    <div class="container">
        <div class="section-title my-5">
            <h2>Privacy Policy</h2>
            <p>Effective Date: 5th August 2024</p>
        </div>
        <div class="bg-white mt-5 p-4">
            <h5>Introduction</h5>
            <p>Welcome to DHA360. At DHA360, your privacy is our priority. This Privacy Policy describes how we collect, use, disclose, and safeguard your information when you visit our website and use our services. By accessing or using our Site, you agree to the terms outlined in this Privacy Policy.</p>
            <h5>Information We Collect</h5>
            <ol>
                <li><h6>Personal Information</h6>
                    <p>We collect personal information that you voluntarily provide to us, including:</p>
                    <ul>
                        <li><b>Registration Information:</b> Name, email address, phone number, and other contact details when you create an account.</li>
                        <li><b>Listing Information: </b> Property details, photos, and descriptions when you post a property listing.</li>
                        <li><b>Communication Information:</b> Any messages or inquiries you send to us through our Site or other channels.</li>
                        <li><b>Payment Information:</b> Payment details when you purchase services or listings, processed through secure third-party payment processors.</li>
                    </ul>
                </li><br>
                <li><h6>Non-Personal Information</h6>
                    <p>We collect non-personal information automatically when you interact with our Site, such as:</p>
                    <ul>
                        <li><b>Usage Data:</b> IP address, browser type, operating system, pages visited, time spent on pages, and other usage statistics.</li>
                        <li><b>Cookies and Tracking Technologies:</b> We use cookies, web beacons, and similar technologies to track your interactions with our Site and remember your preferences.</li>
                    </ul>
                </li><br>
                <li><h6>Third-Party Information</h6>
                    <p>If you link your account with third-party services (e.g., social media accounts), we may receive information from those services, including your public profile information and other details you have chosen to share.</p>
                </li>
            </ol>
            <h5>How We Use Your Information</h5>
            <p>We use your information for various purposes, including:</p>
            <ul>
                <li><b>Account Management:</b> To create and maintain your account, process your property listings, and provide customer support.</li>
                <li><b>Service Provision:</b> To fulfill requests, manage transactions, and provide the services you have requested.</li>
                <li><b>Communication:</b> To send you notifications, updates, and promotional materials related to DH360. You can opt-out of promotional communications at any time.</li>
                <li><b>Improvement:</b> To analyze usage patterns, improve our Site, and enhance user experience.</li>
                <li><b>Legal Compliance:</b> To comply with legal obligations, enforce our terms of service, and protect the rights and safety of DH360 and our users.</li>
            </ul>
            <h5>How We Share Your Information</h5>
            <p>We may share your information in the following circumstances:</p>
            <ul>
                <li><b>With Service Providers:</b> We share your information with trusted third-party service providers who assist us in operating our Site and delivering services, such as payment processors, hosting providers, and email service providers. These providers are contractually obligated to protect your information and use it only for the purposes we specify.</li>
                <li><b>For Legal Reasons:</b> We may disclose your information if required to do so by law, in response to lawful requests by public authorities, or to protect our rights, privacy, safety, or property, or that of our users or others.</li>
                <li><b>Business Transfers:</b> In the event of a merger, acquisition, or any form of asset sale, your information may be transferred as part of that transaction. We will notify you of any changes to the handling of your information.</li>
            </ul>
            <h5>Cookies and Tracking Technologies</h5>
            <p>We use cookies and similar tracking technologies to collect and store information about your interactions with our Site. Cookies help us:</p>
            <ul>
                <li><b>Authenticate Users:</b>Ensure that only authorized users can access their accounts.</li>
                <li><b>Enhance User Experience:</b> Remember your preferences and improve the functionality of our Site.</li>
                <li><b>Analyze Site Usage:</b> Gather data on how our Site is used to identify trends and make improvements.</li>
            </ul>
            <p>You can manage cookie preferences through your browser settings. However, disabling cookies may impact the functionality of certain features on our Site.</p>

            <h5>Data Security</h5>
            <p>We implement reasonable security measures to protect your personal information from unauthorized access, alteration, disclosure, or destruction.
                 These measures include encryption, access controls, and secure servers. Despite these efforts, no method of transmission over the internet or electronic storage is completely secure, and we cannot guarantee absolute security.</p>

            <h5>Your Rights and Choices</h5>
            <p>Depending on your jurisdiction, you may have the following rights regarding your personal information:</p>
            <ul>
                <li><b>Access and Correction:</b> You can request access to or correction of your personal information.</li>
                <li><b>Deletion:</b> You may request the deletion of your personal information, subject to certain legal exceptions.</li>
                <li><b>Opt-Out:</b> You can opt-out of receiving marketing communications by following the unsubscribe instructions in the messages we send or contacting us directly.</li>
                <li><b>Data Portability:</b> You may request a copy of your personal information in a structured, commonly used format. To exercise these rights, please contact us at our privacy email address <b>properties@dha360.pk.</b></li>
            </ul>
            <h5>Third-Party Links</h5>
            <p>Our Site may contain links to third-party websites. We are not responsible for the privacy practices or content of these external sites.
                 We encourage you to review the privacy policies of any third-party websites you visit.</p>

            <h5>Children's Privacy</h5>
            <p>Our Site is not intended for use by individuals under the age of 18. We do not knowingly collect or solicit personal
                information from children under 18. If we become aware that we have collected personal information from a child under 18,
                 we will take steps to delete such information.</p>
            <h5>Changes to This Privacy Policy</h5>
            <p>We may update this Privacy Policy periodically. Any changes will be posted on this page with an updated effective date.
                 We encourage you to review this Privacy Policy regularly to stay informed about how we are protecting your information.</p>

            <h5>Contact Us</h5>
            <p>Thank you for trusting DHA360 with your personal information. We are committed to protecting your privacy and ensuring a secure online experience.</p>

            <p>If you have any questions or concerns about this Privacy Policy or our data practices, please contact us at:</p>
            <div>
                DHA360 Website: <a href="https://dha360.pk/"> https://dha360.pk/</a><br>
                DHA360 Email: <a href="mail:properties@dha360.pk"> properties@dha360.pk</a><br>
                Address: <b> DHA360 Head Office, Avenue Mall, DHA Phase-1, Islamabad</b>
            </div>
        </div>
    </div>
</div>
@endsection

@section('page_script')
@endsection