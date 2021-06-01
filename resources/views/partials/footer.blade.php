<footer class="@if(request()->route()->named('home')) footer-home @endif">
    <div class="container">
        <ul class="footer-inner">
            <li class="footer-list first-large">
           <!--     <h5>Company</h5>-->
                <ul class="footer-list-item">
                <li><a href="{{route('register.index')}}">Register</a></li>
                <li><a href="{{route('login')}}">Login</a></li>
                    
                    <!-- <li><a href="https://www.youtube.com/channel/UCh6hxU7Biqel13qbC04y3iA/playlists">Success Stories</a></li>
                    <li><a href="{{route('home.faqs.index')}}">FAQs</a></li>
                    <li><a href="{{route('home.student.success')}}">Post a Scholarship</a> </li>
                    <li><a href="#">All Scholarships</a></li>
                    <li><a href="#">Marketplace</a></li>
                    <li><a href="#">Internshsips</a></li>
                    <li><a href="#">Daily Deals</a></li>
                    <li><a href="{{route('home.privacy.policy')}}">Privacy Policy</a></li>
                    <li><a href="{{route('home.terms.conditions')}}">Terms</a></li>
                    <li><a href="https://www.youtube.com/channel/UCh6hxU7Biqel13qbC04y3iA/playlists">Vlogs</a></li>
                   
                    <li><a href="#">News</a></li>
                    <li><a href="{{route('home.contact')}}">Contact Us</a></li> -->
                    

                </ul>
            </li>
     <!--       <li class="footer-list">
                <h5>Other Links </h5>
                <ul class="footer-list-item">
                    <li><a href="{{route('membership.plans')}}">Upgrade Membership</a></li>
                    <li><a href="{{route('home.student.success')}}">Post a Scholarship</a> </li>
                     <li><a href="#">Sponsor Resources</a></li>
                      <li><a href="#">User Resources</a></li> 
                </ul>
            </li>-->
    <!--        <li class="footer-list">
                <h5>Important Links</h5>
                <ul class="footer-list-item">
                    <li><a href="{{route('home.privacy.policy')}}">Privacy Policy</a></li>
                    <li><a href="{{route('home.terms.conditions')}}">Terms</a></li>
                    <li><a href="{{route('home.contact')}}">Contact Us</a></li>
                    <li><a href="{{route('home.fraud.alert')}}">Fraud Alert</a></li>
                </ul>
            </li>-->
            <li class="footer-list">
                <h5>Like and Follow Us</h5>
                <ul class="footer-list-item">
                    <li class="social-links"><a href="#"><i class="fab fa-facebook-f"></i></a>
                        <a href="#"><i class="fab fa-twitter"></i></a>
                        <a href="#"><i class="fab fa-linkedin-in"></i></a>
                        <a href="#"><i class="fab fa-instagram"></i></a>
                        <a href="#"><i class="fab fa-youtube"></i></a>
                       
                    </li>
                    
                </ul>
            </li>
            
                  <li class="footer-list apps-donwload">
                <h5>Get the Mobile App</h5>
                <ul class="footer-list-item">
                    <li class="apps-links">
                    <a href="#"><img src="{{ asset('images/app-store.png') }}"></a>
                        <a href="#"><img src="{{ asset('images/play-store.png') }}"></a>
                       
                       
                    </li>
                    
                </ul>
            </li>

       
        </ul>
    </div>
</footer>
<section class="copyright">
    <div class="container">
        <p>&#169;2020 Scholarships Africa.<br> Scholarships Africa is powered by<a href="http://athtgroup.com/" target="_blank"> Across The Horizon.</a> </p>
    </div>
</section>
