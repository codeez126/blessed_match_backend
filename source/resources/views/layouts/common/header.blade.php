<?php
$headerInfo=\App\Models\HeaderInfo::select('*')->first();
?>
    <!-- scrollToTop start here -->
<a href="#" class="scrollToTop"><i class="fa-solid fa-angle-up"></i></a>
<!-- scrollToTop ending here -->


<!-- ================> header section start here <================== -->
<header class="header" id="navbar">
    <div class="header__bottom">
        <div class="container">
            <nav class="navbar navbar-expand-lg">
                <a class="navbar-brand" href="index.html"><img src="assets/images/logo/logo.png" alt="logo"></a>
                <button class="navbar-toggler collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNavAltMarkup" aria-controls="navbarNavAltMarkup" aria-expanded="false" aria-label="Toggle navigation">
                    <span class="navbar-toggler--icon"></span>
                </button>
                <div class="collapse navbar-collapse justify-content-end" id="navbarNavAltMarkup">
                    <div class="navbar-nav mainmenu">
                        <ul>
                            <li class="active">
                                <a href="#0">Home</a>
                                <ul>
                                    <li><a href="index.html" class="active">Home Page One</a></li>
                                    <li><a href="index-2.html">Home Page Two</a></li>
                                    <li><a href="index-3.html">Home Page Three</a></li>
                                </ul>
                            </li>
                            <li>
                                <a href="#0">Pages</a>
                                <ul>
                                    <li><a href="about.html">About Us</a></li>
                                    <li><a href="membership.html">Membership</a></li>
                                    <li><a href="comingsoon.html">comingsoon</a></li>
                                    <li><a href="404.html">404</a></li>
                                </ul>
                            </li>
                            <li>
                                <a href="#0">Community</a>
                                <ul>
                                    <li><a href="community.html">Community</a></li>
                                    <li><a href="group.html">All Group</a></li>
                                    <li><a href="members.html">All Members</a></li>
                                    <li><a href="activity.html">Activity</a></li>

                                </ul>
                            </li>
                            <li>
                                <a href="#0">Shops</a>
                                <ul>
                                    <li><a href="shop.html">Product</a></li>
                                    <li><a href="shop-single.html">Product Details</a></li>
                                    <li><a href="shop-cart.html">Product Cart</a></li>
                                </ul>
                            </li>
                            <li>
                                <a href="#0">Blogs</a>
                                <ul>
                                    <li><a href="blog.html">Blog</a></li>
                                    <li><a href="blog-2.html">Blog Style Two</a></li>
                                    <li><a href="blog-single.html">Blog Details</a></li>
                                </ul>
                            </li>
                            <li><a href="contact.html">contact</a></li>
                        </ul>
                    </div>
                    <div class="header__more">
                        <button class="default-btn dropdown-toggle" type="button" id="moreoption" data-bs-toggle="dropdown" aria-expanded="false">My Account</button>
                        <ul class="dropdown-menu" aria-labelledby="moreoption">
                            <li><a class="dropdown-item" href="login.html">Log In</a></li>
                            <li><a class="dropdown-item" href="register.html">Sign Up</a></li>
                        </ul>
                    </div>
                </div>
            </nav>
        </div>
    </div>
</header>
<!-- ================> header section end here <================== -->
