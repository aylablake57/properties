@extends('guest.layouts.guest')
@section('title') About Us @endsection
@section('local-style')
    <link href="{{getAdminAsset('css/inner.css')}}?v={{ config('app.version') }}" rel="stylesheet">
    <link href="{{getAdminAsset('css/faq.css')}}?v={{ config('app.version') }}" rel="stylesheet">
@endsection

@section('page')
{{-- header added by Hamza Amjad --}}
<div class="container-fluid mt-5 pt-5 position-relative container-part-about">
    <!-- Particle Animation Container -->
    <div id="particles-js"></div>

    <!-- Content Layer on top of Particles -->
    <div class="row">
        <div class="col-sm-12 d-flex flex-column justify-content-center align-items-center position-relative">
            <h2 class="section-title text-dark mt-4">About Us</h2>
            <div class="container text-center">
                <img src="{{ getAdminAsset('images/about-image.png') }}" alt="About Us Image" class="img-fluid about-us-image">
            </div>
        </div>
    </div>
</div>

<div class="main bg-white mb-5 pb-5">
    <div class="container ad-margin-top">
        <div class="section-title text-center mb-5 pt-5">
            <h2 class="main-heading-text">Authentic Properties<br><span class="styled-subheading">Bridging the Gap with <span class="standout-text">Trust</span><span></h2>
        </div>
        <div class="row">
            <div class="col-sm-6 mb-3 text-justify">
            <div class="sub-title">
                    <h4 class="text-center">Who we are</h4>
                </div>
                <p>DHA 360 Properties was founded to seamlessly connect property seekers and owners interested in trading within the DHA network nationwide. It offers reliable, verified real estate options with up-to-date data, establishing the DHA 360 website as a trusted destination for property solutions in Pakistan.</p>
            </div>
            <div class="col-sm-6 mb-3 border-left text-justify" id='border-spawn-col'>
                <div class="sub-title">
                    <h4 class="text-center">What do we do?</h4>
                </div>
                <p>At DHA360 Properties, we connect aspirants and sellers interested in transacting real estate assets within the DHA network across Pakistan. Our website provides up-to-date information and facilitates seamless deals of authentic properties, ensuring a smooth and reliable experience.</p>
            </div>
        </div>
        <div class="row">
            <div class="col-sm-12 text-center mb-3">
                <div class="sub-title mt-5">
                    <h3 class="standout-text">Why Choose DHA360 Properties?</h4>
                </div>
            </div>
        </div>
        <!-- card height made consistent > Asim -->
        <div class="row commitment-row-container mb-5">
        <div class="col-md-6 col-lg-4 col-sm-6 mb-3 d-flex">
            <div class="border-all commitment-row-card-content  shadow h-100 w-100 d-flex flex-column">
                <div class="sub-title my-4 d-flex flex-column align-items-center">
                    <img src="{{ asset('assets/images/icons/nation-wide.png') }}" alt="Properties" class="img-fluid pb-3">
                    <h4 class='text-center'>Nationwide DHA Network</h4>
                </div>
                <div class="wrapper d-flex justify-content-center w-100">
                    <ul class='icon-list mt-auto'>
                        <li>Trusted platform exclusive for DHA properties.</li>
                        <li>116,693 acres across 10 regions.</li>
                    </ul>
                </div>
            </div>
        </div>
        <div class="col-md-6 col-lg-4 col-sm-6 mb-3 d-flex">
            <div class="border-all commitment-row-card-content  shadow h-100 w-100 d-flex flex-column">
                <div class="sub-title my-4 d-flex flex-column align-items-center">
                    <img src="{{ asset('assets/images/icons/commitment.png') }}" alt="Properties" class="img-fluid pb-3">
                    <h4 class='text-center'>Commitment to Legitimacy</h4>
                </div>
                <div class="wrapper d-flex justify-content-center w-100">
                    <ul class='icon-list mt-auto'>
                        <li>More than just an online marketplace.</li>
                        <li>Dedicated to reliable, and seamless transactions.</li>
                    </ul>
                </div>
            </div>
        </div>
        <div class="col-md-6 col-lg-4 col-sm-6 mb-3 d-flex">
            <div class="border-all commitment-row-card-content  shadow h-100 w-100 d-flex flex-column">
                <div class="sub-title my-4 d-flex flex-column align-items-center">
                    <img src="{{ asset('assets/images/icons/up-to-date.png') }}" alt="Properties" class="img-fluid pb-3">
                    <h4 class='text-center'>Up-to-date Information</h4>
                </div>
                <div class="wrapper d-flex justify-content-center w-100">
                    <ul class='icon-list mt-auto'>
                        <li>Our platform is constantly updated.</li>
                        <li>Providing current and accurate real estate data.</li>
                    </ul>
                </div>
            </div>
        </div>
        <div class="col-md-6 col-lg-4 col-sm-6 mb-3 d-flex">
            <div class="border-all commitment-row-card-content  shadow h-100 w-100 d-flex flex-column">
                <div class="sub-title my-4 d-flex flex-column align-items-center">
                    <img src="{{ asset('assets/images/icons/filter.png') }}" alt="Properties" class="img-fluid pb-3">
                    <h4 class='text-center'>Advanced Search Filters</h4>
                </div>
                <div class="wrapper d-flex justify-content-center w-100">
                    <ul class='icon-list mt-auto'>
                        <li>Advanced search capabilities for tailored criteria.</li>
                        <li>Quickly find the perfect property efficiently.</li>
                    </ul>
                </div>
            </div>
        </div>
        <div class="col-md-6 col-lg-4 col-sm-6 mb-3 d-flex">
            <div class="border-all commitment-row-card-content  shadow h-100 w-100 d-flex flex-column">
                <div class="sub-title my-4 d-flex flex-column align-items-center">
                    <img src="{{ asset('assets/images/icons/guide.png') }}" alt="Properties" class="img-fluid pb-3">
                    <h4 class='text-center'>Expert Guidance</h4>
                </div>
                <div class="wrapper d-flex justify-content-center w-100">
                    <ul class='icon-list mt-auto'>
                        <li>Our experts offer custom advice and support.</li>
                        <li>Guiding you through every step of the process.</li>
                    </ul>
                </div>
            </div>
        </div>
            <div class="col-md-6 col-lg-4 col-sm-6 mb-3 d-flex">
                <div class="border-all commitment-row-card-content  shadow h-100 w-100 d-flex flex-column">
                    <div class="sub-title my-4 d-flex flex-column align-items-center">
                        <img src="{{ asset('assets/images/icons/add-user.png') }}" alt="Properties" class="img-fluid pb-3">
                        <h4 class='text-center'>User-Friendly Interface</h4>
                    </div>
                    <div class="wrapper d-flex justify-content-center w-100">
                        <ul class='icon-list mt-auto'>
                            <li>User-friendly design for intuitive experience.</li>
                            <li>Simplifies property search & transaction processes.</li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- make some changes, create custom functional nav using div block, by Hamza Amjad -->

    <div class="faqs mb-5 py-5 bg-light">
        <div class="container">
            <div class="section-title text-center mb-5">
                <h3 class="standout-text">Frequently Asked Questions</h2>
                <p class="lead animate__animated animate__fadeInUp">Find key information about your property, including rules, laws, and more.</p>
            </div>
            <div class="row">
                <div class="col-md-4 faq-left-side">
                    <div class="list-group" id="faqTabs" role="tablist">
                        <a class="faq-tab list-group-item list-group-item-action active animate__animated animate__fadeInLeft" id="tabOne" data-bs-toggle="list" href="#collapseOne" role="tab" aria-controls="collapseOne">How to transfer DHA plots?</a>
                        <a class="faq-tab list-group-item list-group-item-action animate__animated animate__fadeInLeft" id="tabTwo" data-bs-toggle="list" href="#collapseTwo" role="tab" aria-controls="collapseTwo">Required Documents for Plot Transfer</a>
                        <a class="faq-tab list-group-item list-group-item-action animate__animated animate__fadeInLeft" id="tabThree" data-bs-toggle="list" href="#collapseThree" role="tab" aria-controls="collapseThree">Duration for Issuance of Allotment Letter</a>
                        <a class="faq-tab list-group-item list-group-item-action animate__animated animate__fadeInLeft" id="tabFour" data-bs-toggle="list" href="#collapseFour" role="tab" aria-controls="collapseFour">Issuing Duplicate/Triplicate Allotment Letter</a>
                        <a class="faq-tab list-group-item list-group-item-action animate__animated animate__fadeInLeft" id="tabFive" data-bs-toggle="list" href="#collapseFive" role="tab" aria-controls="collapseFive">Reissuance of Membership Card</a>
                        <a class="faq-tab list-group-item list-group-item-action animate__animated animate__fadeInLeft" id="tabSix" data-bs-toggle="list" href="#collapseSix" role="tab" aria-controls="collapseSix">Documents for Issuance of Allotment Letter</a>
                    </div>
                </div>
                <div class="col-md-8 faq-right-side">
                    <div class="tab-content animate__animated animate__fadeInRight" id="faqTabsContent">
                        <div class="tab-pane fade show active" id="collapseOne" role="tabpanel" aria-labelledby="tabOne">
                            <div class="row">
                                <div class="col-lg-6">
                                    <ol>
                                        <li><strong>Verify Ownership:</strong> Confirm you hold legal documents.</li>
                                        <li><strong>Obtain NOC:</strong> Get a No Objection Certificate if applicable.</li>
                                        <li><strong>Visit DHA:</strong> Collect and fill transfer forms.</li>
                                        <li><strong>Submit & Pay:</strong> Submit forms and pay fees.</li>
                                        <li><strong>Approval & Issuance:</strong> DHA processes and issues a transfer letter.</li>
                                    </ol>
                                </div>
                                <div class="col-lg-6 faq-img-box">
                                    <ol class="ol-faq-urdu">
                                        <b class="urdu-faq-border">ڈی ایچ اے پلاٹس کی منتقلی کیسے کریں؟</b>
                                        <li class="li-faq-urdu"><strong> ملکیت کی تصدیق کریں: </strong>اس بات کی تصدیق کریں کہ آپ کے پاس قانونی دستاویزات موجود ہیں۔ </li>
                                        <li class="li-faq-urdu"><strong> این او سی حاصل کریں: </strong>اگر قابل اطلاق ہو تو این او سی (عدم اعتراض سرٹیفکیٹ) حاصل کریں۔ </li>
                                        <li class="li-faq-urdu"><strong> ڈی ایچ اے کا دورہ کریں: </strong> منتقلی کے فارم جمع کریں اور بھر کر مکمل کریں۔ </li>
                                        <li class="li-faq-urdu"><strong> جمع کریں اور ادائیگی کریں: </strong> فارم جمع کروائیں اور فیس ادا کریں۔ </li>
                                        <li class="li-faq-urdu"><strong> منظوری اور اجراء: </strong> ڈی ایچ اے کارروائی مکمل کرکے منتقلی کا خط جاری کرے گا۔ </li>
                                    </ol>                                
                                </div>
                            </div>
                        </div>
                        <div class="tab-pane fade" id="collapseTwo" role="tabpanel" aria-labelledby="tabTwo">
                            <div class="row">
                                <div class="col-lg-7">
                                    <ol>
                                        <li>Statement of Dues</li>
                                        <li>NDC</li>
                                        <li>Seller's Application Form</li>
                                        <li>Purchaser's Membership Form</li>
                                        <li>Original Allotment Letter</li>
                                        <li>Transfer Affidavit</li>
                                        <li>Purchaser's Undertaking</li>
                                        <li>Sale Agreement</li>
                                    </ol>
                                </div>
                                <div class="col-lg-5 faq-img-box">
                                    <ol class="ol-faq-urdu">
                                        <b class="urdu-faq-border">الٹمنٹ لیٹر کے اجراء کا دورانیہ</b>
                                        <li class="li-faq-urdu">واجبات کا بیان </li>
                                        <li class="li-faq-urdu">این ڈی سی</li>
                                        <li class="li-faq-urdu"> فروخت کنندہ کا درخواست فارم</li>
                                        <li class="li-faq-urdu"> خریدار کا ممبرشپ فارم </li>
                                        <li class="li-faq-urdu"> اصل الاٹمنٹ لیٹر </li>
                                        <li class="li-faq-urdu"> ٹرانسفر حلف نامہ </li>
                                        <li class="li-faq-urdu"> خریدار کا عہد نامہ </li>
                                        <li class="li-faq-urdu"> فروخت کا معاہدہ </li>
                                    </ol> 
                                </div>
                            </div>
                        </div>
                        <div class="tab-pane fade" id="collapseThree" role="tabpanel" aria-labelledby="tabThree">
                            <div class="row">
                                <div class="col-lg-7">
                                    The Allotment Letter is issued within 20 working days after approval.                            
                                </div>
                                <div class="col-lg-5 faq-img-box">
                                    <ol class="ol-faq-urdu">
                                        <b class="urdu-faq-border">الٹمنٹ لیٹر کے اجراء کا دورانیہ</b>
                                        <li class="li-faq-urdu">Allotment Letter کی منظوری کے بعد 20 کام کے دنوں میں جاری کیا جاتا ہے۔</li>
                                    </ol>
                                </div>
                            </div>
                        </div>
                        <div class="tab-pane fade" id="collapseFour" role="tabpanel" aria-labelledby="tabFour">
                            <div class="row">
                                <div class="col-lg-7">
                                    <ol>
                                        <li>Application with affidavit for loss.</li>
                                        <li>Advertisements in newspapers (clippings required).</li>
                                        <li>Deposit Rs.10,000/- in DHA account.</li>
                                        <li>2 passport-size photos and CNIC copy.</li>
                                    </ol>
                                </div>
                                <div class="col-lg-5 faq-img-box">
                                    <ol class="ol-faq-urdu">
                                        <b class="urdu-faq-border">الٹمنٹ لیٹر کا ڈپلیکیٹ/ٹرپلیکیٹ جاری کرنا</b>
                                        <li class="li-faq-urdu">کھو جانے کی صورت میں حلف نامے کے ساتھ درخواست۔</li>
                                        <li class="li-faq-urdu">اخبارات میں اشتہارات (کلپنگز درکار ہیں)۔</li>
                                        <li class="li-faq-urdu">DHA اکاؤنٹ میں 10,000 روپے جمع کریں۔</li>
                                        <li class="li-faq-urdu">2 پاسپورٹ سائز کی تصاویر اور CNIC کی کاپی۔</li>
                                    </ol> 
                                </div>
                            </div>
                        </div>
                        <div class="tab-pane fade" id="collapseFive" role="tabpanel" aria-labelledby="tabFive">
                            <div class="row">
                                <div class="col-lg-7">
                                    <ol>
                                        <li>Deposit Rs.300 in ACKBL.</li>
                                        <li>Receipt and FIR copy.</li>
                                        <li>2 passport-size photos.</li>
                                        <li>Attested CNIC copy.</li>
                                    </ol>
                                </div>
                                <div class="col-lg-5 faq-img-box">
                                    <ol class="ol-faq-urdu">
                                        <b class="urdu-faq-border">رکنیت کارڈ کا دوبارہ اجرا</b>
                                        <li class="li-faq-urdu">ACKBL میں 300 روپے جمع کریں۔</li>
                                        <li class="li-faq-urdu">نسخہ اور ایف آئی آر کی کاپی۔</li>
                                        <li class="li-faq-urdu">2 پاسپورٹ سائز کی تصاویر۔</li>
                                        <li class="li-faq-urdu">تصدیق شدہ CNIC کی کاپی۔</li>
                                    </ol> 
                                </div>
                            </div>
                        </div>
                        <div class="tab-pane fade" id="collapseSix" role="tabpanel" aria-labelledby="tabSix">
                            <div class="row">
                                <div class="col-lg-7">
                                    The allotment letter will be issued within a week.
                                    <ol>
                                        <li>Original provisional allotment letter.</li>
                                        <li>2 passport-size photos.</li>
                                        <li>Photocopy of CNIC.</li>
                                    </ol>
                                </div>
                                <div class="col-lg-5 faq-img-box">
                                    <ol class="ol-faq-urdu">
                                        <b class="urdu-faq-border">الٹمنٹ لیٹر کے اجرا کے لیے درکار دستاویزات</b>
                                        <p>اللوٹمنٹ لیٹر ایک ہفتے کے اندر جاری کیا جائے گا۔</p>
                                        <li class="li-faq-urdu">اصل پروویژنل آلٹمنٹ لیٹر۔</li>
                                        <li class="li-faq-urdu">2 پاسپورٹ سائز کی تصاویر۔</li>
                                        <li class="li-faq-urdu">CNIC کی فوٹو کاپی۔</li>
                                    </ol>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
 
    {{-- <div class="stats bg-white mb-5 py-5">
        <div class="container">
            <div class="section-title text-center my-5">
                <h2>Our Property stats</h2>
                <p>At DHA 360, our property stats speak volumes about our commitment to<br> excellence and our dedication to providing unparalleled service to our clients</p>
            </div>
            <div class="row mx-5 mb-5 pb-5">
                <div class="col-sm-4 mb-3 text-center">
                    <div class="stats">
                        <span>RS. 1,000 Core</span>
                        <p>Current Listing Volume</p>
                    </div>
                </div>
                <div class="col-sm-4 mb-3 text-center">
                    <div class="stats">
                        <span>RS. 400 Core</span>
                        <p>Total Sold 2022 - 2023</p>
                    </div>
                </div>
                <div class="col-sm-4 mb-3 text-center">
                    <div class="stats">
                        <span>RS. 100 B</span>
                        <p>Lifetime Sales Volume</p>
                    </div>
                </div>
            </div>
        </div>
    </div> --}}

    <div class="contact bg-white mb-5 py-5" id="sectionContact">
        <div class="container">
            <div class="contact-wrapper mx-xl-5">
                <div class="row">
                    <div class="col-lg-6">
                        <!-- Done By Hamza Amjad -->
                        <!-- Replace image with map -->
                        <iframe class="map" src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d53216.32766648113!2d73.0956464888663!3d33.526853176364455!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x38dfed388abb2415%3A0x2d12fbe80f7163be!2sDefence%20Housing%20Authority%20Islamabad-Rawalpindi!5e0!3m2!1sen!2s!4v1723529018507!5m2!1sen!2s" width="100%" height="100%" style="border:0;" allowfullscreen="" loading="lazy" referrerpolicy="no-referrer-when-downgrade"></iframe>
                        <!-- end map -->
                        <div class="background-overlay"></div>
                    </div>
                    <div class="col-lg-6">
                        <div class="container px-4">
                            <div class="section-title my-5">
                                <h2>Get in touch</h2>
                                <p>Our experts would love to contribute their expertise and insights and help you today.</p>
                            </div>
                            <div class="tab-content pt-0 px-0">
                                @include ('guest.partials.contact-form')
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('page_script')
<script src="{{getAdminAsset('js/message.js')}}?v={{ config('app.version') }}"></script>
<script src="{{getAdminAsset('js/particle.js')}}?v={{ config('app.version') }}"></script>
<!-- GSAP JS for animation, added by Hamza Amjad -->
<script>
    const containers = document.querySelectorAll('.column-container');

    containers.forEach(container => {
        const image = container.querySelector('.hover-image');

        container.addEventListener('mouseenter', () => {
            gsap.to(image, { autoAlpha: 1, visibility: 'visible', duration: 0.5 });
        });

        container.addEventListener('mouseleave', () => {
            gsap.to(image, { autoAlpha: 0, visibility: 'hidden', duration: 0.5 });
        });

        container.addEventListener('mousemove', (e) => {
            const bounds = container.getBoundingClientRect();
            const offsetX = e.clientX - bounds.left;
            const offsetY = e.clientY - bounds.top;
            gsap.set(image, { x: offsetX - 100, y: offsetY - 150 });
        });
    });
</script>
@endsection