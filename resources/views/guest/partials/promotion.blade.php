<link rel="stylesheet" href="//maxcdn.bootstrapcdn.com/font-awesome/4.3.0/css/font-awesome.min.css">
<link href='https://fonts.googleapis.com/css?family=Raleway:100,400' rel='stylesheet' type='text/css'>
<style>
ul.socialIcons {
  padding: 0;
  text-align: center;
}

.socialIcons li {
  background-color: yellow;
  list-style: none;
  display: inline-block;
  margin: 4px;
  border-radius: 2em;
  overflow: hidden;
}

.socialIcons li a {
  display: block;
  padding: 5px;
  min-width: 2em;
  max-width: 2em;
  height: 2em;
  white-space: nowrap;
  line-height: 1.5em;
  transition: 0.5s;
  text-decoration: none;
  font-family: arial;
  color: #fff;
}

.socialIcons li i {
  margin-right: 0.5em;
}

.socialIcons li a.hover-effect {
  max-width: 200px;
  padding-right: 1em;
}

.socialIcons .facebook {
  background-color: #3b5998;
  box-shadow: 0 0 16px #002679;
}

.socialIcons .twitter {
  background-color: red;
  box-shadow: 0 0 16px rgb(126, 0, 0);
}

.socialIcons .instagram {
  /* background-color: #e4405f; */
  background: linear-gradient(45deg, #f58529, #dd2a7b, #8134af, #515bd4);
  box-shadow: 0 0 16px #800928;
}

.socialIcons .pinterest {
  background-color: #c92228;
  box-shadow: 0 0 16px #c92228;
}

.socialIcons .steam {
  background-color: #0A66C2;
  box-shadow: 0 0 16px #666666;
}

/* Keyframe animations for open and close */
@keyframes hoverEffect {
  0% { max-width: 2em; }
  50% { max-width: 200px; padding-right: 1em; }
  100% { max-width: 2em; }
}

/* Sequential animations with delays */
.socialIcons .facebook a {
  animation: hoverEffect 3s ease-in-out infinite;
  animation-delay: 0s;
}

.socialIcons .twitter a {
  animation: hoverEffect 3s ease-in-out infinite;
  animation-delay: 3s;
}

.socialIcons .instagram a {
  animation: hoverEffect 3s ease-in-out infinite;
  animation-delay: 6s;
}

.socialIcons .pinterest a {
  animation: hoverEffect 3s ease-in-out infinite;
  animation-delay: 9s;
}

.socialIcons .steam a {
  animation: hoverEffect 3s ease-in-out infinite;
  animation-delay: 12s;
}
</style>
<div class="bg-hot py-4">
    <div class="container">
        <div class="banner m-auto">
            <div class="row">
                <div class="col-lg-6 mb-4">
                    <div class="paragraph-group">
                        <p>Interested in Selling Your Property?</p>
                        <h4 class="text-white">Create your Signature Portfolio to sell <br> Your DHA Properties with confidence!<!--  for <span class="badge bg-accent">Free</span> --></h4>
                        <p>Avail this opportunity before our promotional period ends!</p>
                    </div>
                    {{-- @if (!auth()->check() || !auth()->user()->hasRole('superadmin')) --}}
                    <a href="{{ route('property.form') }}" class="highlight">Sell Your Property For <span class="badge text-bg-danger">FREE</span></a>
                    {{-- @endif --}}
                </div>
                    <div class="col-lg-6 pt-4">
                        <h4 class="text-white text-center">Follow us on social media.</h4>
                        <p class="text-white text-center">Get regular updates on latest properties with us.</p>
                        <ul class="socialIcons">
                            <li class="facebook"><a href="https://www.facebook.com/people/Properties-DHA-360/61566460558772/" target="_blank"><i class="fa fa-fw fa-facebook"></i>Facebook</a></li>
                            <li class="twitter"><a href="https://www.youtube.com/@DHA360-o2d" target="_blank"><i class="fa fa-fw fa-youtube-play"></i>Youtube</a></li>
                        </ul>
                        <ul class="socialIcons">
                            <li class="instagram"><a href="https://www.instagram.com/properties_dha360/" target="_blank"><i class="fa fa-fw fa-instagram"></i>Instagram</a></li>
                            <li class="steam"><a href="https://www.linkedin.com/company/properties-dha-360/posts/?feedView=all" target="_blank"><i class="fa fa-fw fa-linkedin"></i>Linkedin</a></li>
                        </ul>
                    </div>
               </div>
            </div>
        </div>
    </div>
