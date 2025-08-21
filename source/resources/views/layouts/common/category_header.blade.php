<?php
$headerInfo=\App\Models\HeaderInfo::select('*')->first();
$mainCategory= \App\Models\Categories::query()->where('status', '1')->where('type', '0')->orderBy('id', 'asc')->get();
if(isset($_GET['gclid'])){
    $gclid=$_GET['gclid'];

}else{
    $gclid='';

}

?>
<?php

if(isset($_GET['MSCLKID'])){
    $MSCLKID=$_GET['MSCLKID'];

}else{
    $MSCLKID='';

}
?>
<header class="navbar-dark shadow">
    <div class="navbar">
        <div class="none_box">
            <div class="bar">
                <i class="fa-solid fa-bars"></i>
            </div>
            <div class="search_box">
                <i class="fa-solid fa-magnifying-glass"></i>
            </div>
            <div class="search_main">
                <span class="closebtn"><i class="fa-solid fa-x"></i></span>
                <form action="">
                    <i class="fa-solid fa-magnifying-glass"></i>
                    <input type="text" placeholder="Search......." />
                </form>
            </div>
        </div>
        <div class="main_logo">
            <img class="light_logo" src="front/images/logo-white.webp" alt="" />
            <img class="dark_logo" src="front/images/logo.webp" alt="" />
        </div>
        <nav>
            <ul>
                <li>
                    <a href="">Home</a>
                </li>
                <li class="list">
                    <a href=""> categories <i class="fa-solid fa-angle-down"></i></a>
                    <div class="mega_list">
                        <div class="row">
                            <div class="col-lg-4">
                                <div class="megamenu-products">
                                    <div class="megamenu-heading"><span>Page</span></div>
                                    <ul class="menu-list">
                                        <li class="menu__item">
                                            <a class="menu__link" href="">About Us</a>
                                        </li>

                                        <li class="menu__item">
                                            <a class="menu__link" href="">Contact Us</a>
                                        </li>

                                        <li class="menu__item">
                                            <a class="menu__link" href="">Faqs</a>
                                        </li>

                                        <li class="menu__item">
                                            <a class="menu__link" href="">Faqs2</a>
                                        </li>

                                        <li class="menu__item">
                                            <a class="menu__link" href="">Wishlist</a>
                                        </li>

                                        <li class="menu__item">
                                            <a class="menu__link" href="">404 Error</a>
                                        </li>
                                    </ul>
                                </div>
                            </div>
                            <div class="col-lg-4">
                                <div class="megamenu-products">
                                    <div class="megamenu-heading"><span>Page</span></div>
                                    <ul class="menu-list">
                                        <li class="menu__item">
                                            <a class="menu__link" href="">About Us</a>
                                        </li>

                                        <li class="menu__item">
                                            <a class="menu__link" href="">Contact Us</a>
                                        </li>

                                        <li class="menu__item">
                                            <a class="menu__link" href="">Faqs</a>
                                        </li>

                                        <li class="menu__item">
                                            <a class="menu__link" href="">Faqs2</a>
                                        </li>

                                        <li class="menu__item">
                                            <a class="menu__link" href="">Wishlist</a>
                                        </li>

                                        <li class="menu__item">
                                            <a class="menu__link" href="">404 Error</a>
                                        </li>
                                    </ul>
                                </div>
                            </div>
                            <div class="col-lg-4">
                                <div class="megamenu-products">
                                    <div class="megamenu-heading"><span>Page</span></div>
                                    <ul class="menu-list">
                                        <li class="menu__item">
                                            <a class="menu__link" href="">About Us</a>
                                        </li>

                                        <li class="menu__item">
                                            <a class="menu__link" href="">Contact Us</a>
                                        </li>

                                        <li class="menu__item">
                                            <a class="menu__link" href="">Faqs</a>
                                        </li>

                                        <li class="menu__item">
                                            <a class="menu__link" href="">Faqs2</a>
                                        </li>

                                        <li class="menu__item">
                                            <a class="menu__link" href="">Wishlist</a>
                                        </li>

                                        <li class="menu__item">
                                            <a class="menu__link" href="">404 Error</a>
                                        </li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                    </div>
                </li>

                <li class="list1">
                    <a href="">Product <i class="fa-solid fa-angle-down"></i></a>
                    <div class="mega_list mega_list1">
                        <div class="row">
                            <div class="col-lg-12">
                                <div class="megamenu-products">
                                    <div class="megamenu-heading border-0 m-0 p-0"></div>
                                    <ul class="menu-list">
                                        <li class="menu__item">
                                            <a class="menu__link" href="">About Us</a>
                                        </li>

                                        <li class="menu__item">
                                            <a class="menu__link" href="">Contact Us</a>
                                        </li>

                                        <li class="menu__item">
                                            <a class="menu__link" href="">Faqs</a>
                                        </li>

                                        <li class="menu__item">
                                            <a class="menu__link" href="">Faqs2</a>
                                        </li>

                                        <li class="menu__item">
                                            <a class="menu__link" href="">Wishlist</a>
                                        </li>

                                        <li class="menu__item">
                                            <a class="menu__link" href="">404 Error</a>
                                        </li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                    </div>
                </li>
                <li><a href=""> Blog </a></li>
                <li>
                    <a href="">FeaTured</a>
                </li>
            </ul>
        </nav>
        <div class="nav_box">
            <div class="search_box none_mob">
                <i class="fa-solid fa-magnifying-glass"></i>
            </div>
            <div class="search_main none_mob">
                <span class="closebtn"><i class="fa-solid fa-x"></i></span>
                <form action="">
                    <i class="fa-solid fa-magnifying-glass"></i>
                    <input type="text" placeholder="Search......." />
                </form>
            </div>
            <div class="user_box">
                <i class="fa-regular fa-user" onclick="openNav('mySidenav')"></i>
                <div id="mySidenav" class="sidenav">
                    <div class="side_notiHeader">
                <span
                    href="javascript:void(0)"
                    onclick="closeNav('mySidenav')"
                    class="sidClose h6"
                >&times;</span
                >
                    </div>
                    <div class="content_user">
                        <h6>Sign In</h6>
                        <form action="">
                            <input
                                type="email"
                                name="email"
                                id=""
                                class="form-control rounded-0"
                                placeholder="Email *"
                            />
                            <input
                                type="password"
                                name="password"
                                class="form-control mt-2 rounded-0"
                                id=""
                                placeholder="password *"
                            />
                            <p class="lostPas"><a href="">Lost Your Password ?</a></p>
                            <div class="btn_group">
                                <button class="btn darbtn">SIGN IN</button>
                                <button class="btn borderbtn">Create your account</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
            <div class="addcard_box">
                <i
                    class="fa-solid fa-bag-shopping"
                    onclick="openNav('mySidenav1')"
                ></i>
                <div id="mySidenav1" class="sidenav">
                    <div class="side_notiHeader">
                <span
                    href="javascript:void(0)"
                    onclick="closeNav('mySidenav1')"
                    class="sidClose h6"
                >&times;</span
                >
                    </div>
                    <div class="add_shipping">
                        <div class="free_ship">
                            <p class="m-0">
                                <i class="fa-solid fa-bolt"></i
                                ><span> Free shipping on orders </span>
                                <span class="money">$100.00</span>
                            </p>
                            <div class="title-spend">
                                Spend <span class="money">$-450.00</span> more and get free
                                shipping!
                            </div>
                            <div class="progress mt-3">
                                <div
                                    class="progress-bar progress-bar-striped bg-dark"
                                    role="progressbar"
                                    style="width: 50%"
                                    aria-valuenow="50"
                                    aria-valuemin="0"
                                    aria-valuemax="100"
                                ></div>
                            </div>
                        </div>
                        <div class="add_cardt"></div>
                        <div class="add_fcont">
                            <div class="medi_icon">
                                <div class="wedget">
                                    <i class="fa-solid fa-gift"></i>
                                    <p>Add gift wrap</p>
                                </div>
                                <div class="wedget">
                                    <i class="fa-solid fa-pen"></i>
                                    <p>Add note</p>
                                </div>
                                <div class="wedget">
                                    <i class="fa-solid fa-receipt"></i>
                                    <p>Coupon</p>
                                </div>
                                <div class="wedget">
                                    <i class="fa-solid fa-truck"></i>
                                    <p>Shipping</p>
                                </div>
                            </div>
                            <div class="sub_total">
                                <span>Subtotal: </span>
                                <span>$50.00</span>
                            </div>
                            <p class="tax">Taxes and shipping calculated at checkout</p>
                            <div class="ajaxcart-currency" data-currency-jsnotify="">
                                <div class="content">
                                    <div class="marquee">
                                        <p>
                                            All charges are billed in <span>USD</span>. While the
                                            content of your cart is currently displayed in
                                            <span class="selected-currency"></span>, the checkout
                                            will use <span>USD</span> at the most current exchange
                                            rate.
                                        </p>
                                    </div>
                                </div>
                            </div>
                            <p class="ajaxcart_terms_conditions">
                                <input type="checkbox" class="agree_terms_conditions" />
                                <label for="agree">
                                    I agree with the <a href="#">terms and conditions</a>
                                </label>
                            </p>
                            <div class="btn_group px-3">
                                <button class="btn darbtn" disabled>CHECK OUT</button>
                                <button class="btn borderbtn">VIEW CART</button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</header>
