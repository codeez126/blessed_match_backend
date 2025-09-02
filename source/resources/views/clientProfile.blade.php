<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>Asan Match</title>
    <meta name="keywords" content="Asan Match">
    <meta name="description" content="Asan Match">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="robots" content="noindex,nofollow">
    <meta name="author" content="Asan Match">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
<style>
    .profile-card{
        background:#fff;
        border:1px solid rgba(0,0,0,0.06);
        box-shadow:0 6px 18px rgba(0,0,0,0.08);
        border-radius:12px;
        margin:18px 0;
        padding:0;
        transition:transform .18s ease,box-shadow .18s ease;
        width: 100%;
    }
    .first-container{
        text-align:center;
        color:#fff;
        font-weight:bold;
        background:linear-gradient(135deg,#8C37F8,#D51BF9);
        padding:15px;
        border-top-left-radius: 12px;
        border-top-right-radius: 12px;
        margin-bottom: 0;
    }
    .profile-image {
        border-radius: 50%;
        padding: 4px;
        background: linear-gradient(135deg, #8C37F8, #D51BF9);
        width: 120px;
        height: 120px;
        overflow: hidden;
        margin: 0 auto;
    }

    .profile-image img {
        width: 100%;
        height: 100%;
        object-fit: cover;
        border-radius: 50%;
        background: #fff;
        display: block;
    }

    .basic-info-container{
        padding: 20px;
    }

    .basic-info-section{
        margin-bottom: 12px;
    }

    .basic-info-section img{
        margin-right: 10px;
        vertical-align: middle;
    }

    .basic-info-section span{
        font-size: 16px;
        font-weight: 500;
        vertical-align: middle;
    }
    .custom-progress {
        background: linear-gradient(135deg, #8C37F8, #D51BF9);
    }
    .progress {
        height: 25px;
        margin: 10px 60px;
    }
    .profile-completed-div {
        margin: 0px 73px;
        background: linear-gradient(135deg, #8C37F8, #D51BF9);
        -webkit-background-clip: text;
        -webkit-text-fill-color: transparent;
    }
    .adv-p{
        color: #8b8888;
    }
    .adv-heading{
        color: black;
        font-weight: bold;
    }
    .advanced-info-section{
        border: 1px solid #e1d2d2;
        padding: 10px;
        border-radius: 5px
    }
    .theme-card-points{
        padding: 0 20px;
        margin-bottom: 20px;
    }
    .repeating-heading {
        display: inline-block;
        position: relative;
        background: linear-gradient(135deg, #8C37F8, #D51BF9);
        -webkit-background-clip: text;
        -webkit-text-fill-color: transparent;
        background-clip: text;
        color: transparent;
        padding-bottom: 8px;
        margin-left: 15px;
    }

    @media (max-width: 768px) {
        .profile-image {
            width: 100px;
            height: 100px;
            margin-bottom: 15px;
        }

        .basic-info-container {
            text-align: center;
        }

    }
</style>

<div class="container">
    <div class="profile-card">
        <!-- Header Section -->
        <div class="row">
            <div class="col-12">
                <div class="first-container">
                    Profile
                </div>
            </div>
        </div>

        <!-- Profile Content Section -->
        <div class="basic-info-container">
            <div class="row align-items-center">
                <!-- Profile Image Column -->
                <div class="col-md-3 col-12 text-center mb-3 mb-md-0">
                    <div class="profile-image">
                        <img src="
                        {{asset($user->clientAbout->profile_image ?? 'https://t4.ftcdn.net/jpg/03/64/21/11/360_F_364211147_1qgLVxv1Tcq0Ohz3FawUfrtONzz8nq3e.jpg')}}
                        " alt="Profile Image" class="img-fluid">
                    </div>
                </div>
                <!-- Profile Information Column -->
                <div class="col-md-9 col-12">
                    <div class="row">
                        <div class="col-md-12 mb-3">
                            <h2>{{$user->clientAbout->full_name ?? 'Name Not Available'}}
                                <img src="{{asset('assets/front/icons/tick.webp')}}" alt="" width="30" height="30">
                            </h2>
                        </div>
                        <div class="col-md-3 col-6 mb-2 mb-md-0">
                            <div class="basic-info-section d-flex align-items-center">
                                <img src="{{asset('assets/front/icons/cast.webp')}}" alt="" width="30" height="30">
                                <span>{{ $user->clientIslamicValue?->cast?->name ?? 'N/A' }}</span>
                            </div>
                        </div>

                        <div class="col-md-4 col-6 mb-2 mb-md-0">
                            <div class="basic-info-section d-flex align-items-center">
                                <img src="{{asset('assets/front/icons/profession.webp')}}" alt="" width="30" height="30">
                                <span>{{ $user->clientProfession?->occupationRelation?->name ?? 'N/A' }}</span>
                            </div>
                        </div>

                        <div class="col-md-5 col-6 mb-2 mb-md-0">
                            <div class="basic-info-section d-flex align-items-center">
                                <img src="{{asset('assets/front/icons/location.webp')}}" alt="" width="30" height="30">
                                <span>{{ $user->clientBackground?->cityRelation->name ?? 'N/A' }}</span>
                            </div>
                        </div>

                    </div>
                </div>

                <div class="col-md-12">
                    <div class="text-end profile-completed-div">Profile Completed {{$user->profileAvg->total_avg}}%</div>
                    <div class="progress" style="height: 20px;">
                        <div class="progress-bar custom-progress" role="progressbar" style="width: 90%;" aria-valuenow="{{$user->profileAvg->total_avg}}" aria-valuemin="0" aria-valuemax="100">
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>









<style>
    .tabs-scroll-wrapper {
        position: relative;
        display: flex;
        align-items: center;
        gap: 8px;
    }

    .nav-scroll {
        display: flex;
        overflow-x: auto;
        overflow-y: hidden;
        scroll-behavior: smooth;
        -webkit-overflow-scrolling: touch;
        gap: 6px;
        padding: 4px 0;
        flex: 1 1 auto;
        flex-wrap: nowrap !important; /* Prevent wrapping */
        white-space: nowrap;
    }

    .nav-scroll::-webkit-scrollbar {
        display: none;
    }

    .nav-scroll {
        -ms-overflow-style: none;
        scrollbar-width: none;
    }

    .nav-scroll .nav-link {
        white-space: nowrap;
        flex: 0 0 auto;
        min-width: fit-content;
        border: none;
        border-radius: 0;
        padding: 0.5rem 1rem;
        text-decoration: none;
        color: #495057;
        background: none;
        transition: all 0.15s ease-in-out;
        position: relative;
    }

    .nav-scroll .nav-link:hover {
        color: #495057;
    }

    .nav-scroll .nav-link.active {
        background: linear-gradient(135deg, #8C37F8, #D51BF9);
        background-clip: text;
        -webkit-background-clip: text;
        -webkit-text-fill-color: transparent;
        color: transparent;
    }

    .nav-scroll .nav-link.active::after {
        content: '';
        position: absolute;
        bottom: 0;
        left: 0;
        right: 0;
        height: 3px;
        background: linear-gradient(135deg, #8C37F8, #D51BF9);
    }

    .tabs-card {
        background: #fff;
        border: 1px solid rgba(0,0,0,0.06);
        box-shadow: 0 6px 18px rgba(0,0,0,0.06);
        border-radius: 10px;
        padding: 8px;
    }

    .scroll-btn {
        background: rgba(0,0,0,0.06);
        border: none;
        width: 36px;
        height: 36px;
        border-radius: 6px;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        cursor: pointer;
        transition: background-color 0.15s ease-in-out;
    }

    .scroll-btn:hover:not(:disabled) {
        background: rgba(0,0,0,0.1);
    }

    .scroll-btn:disabled {
        opacity: 0.35;
        cursor: default;
    }

    .tab-content {
        margin-top: 1rem !important;
        padding-top: 1rem;
    }
.skin-color-span{
    width: 30px;
    height: 30px;
    margin-right: 14px;
    border-radius: 5px;
}
    @media (max-width: 575px) {
        .scroll-btn {
            width: 42px;
            height: 42px;
        }
    }
</style>
<div class="container py-3">
    <div class="tabs-card">
        <div class="tabs-scroll-wrapper">
            <button class="scroll-btn" id="tabsScrollLeft" aria-label="Scroll left">
                <svg width="16" height="16" viewBox="0 0 16 16" fill="none">
                    <path d="M10 3L5 8l5 5" stroke="currentColor" stroke-width="1.6" stroke-linecap="round" stroke-linejoin="round"/>
                </svg>
            </button>

            <div class="nav-scroll" id="tabsScrollable" role="tablist">
                <!-- Example: 20 tabs -->
                <a class="nav-link active" id="tab-1" data-bs-toggle="tab" href="#pane-1" role="tab">About</a>
                <a class="nav-link" id="tab-2" data-bs-toggle="tab" href="#pane-2" role="tab">Background</a>
                <a class="nav-link" id="tab-3" data-bs-toggle="tab" href="#pane-3" role="tab">Profession</a>
                <a class="nav-link" id="tab-4" data-bs-toggle="tab" href="#pane-4" role="tab">Islamic Values</a>
                <a class="nav-link" id="tab-5" data-bs-toggle="tab" href="#pane-5" role="tab">Life Style</a>
                <a class="nav-link" id="tab-6" data-bs-toggle="tab" href="#pane-6" role="tab">Hobbies</a>
                <a class="nav-link" id="tab-7" data-bs-toggle="tab" href="#pane-7" role="tab">Gallery</a>
            </div>

            <button class="scroll-btn" id="tabsScrollRight" aria-label="Scroll right">
                <svg width="16" height="16" viewBox="0 0 16 16" fill="none">
                    <path d="M6 3l5 5-5 5" stroke="currentColor" stroke-width="1.6" stroke-linecap="round" stroke-linejoin="round"/>
                </svg>
            </button>
        </div>

        <div class="tab-content mt-3">
            <div class="tab-pane fade show active" id="pane-1">
                <div class="p-3">
                   @include('profile_components.about')
                </div>
            </div>
            <div class="tab-pane fade" id="pane-2">
                <div class="p-3">
                    @include('profile_components.background')
                </div>
            </div>
            <div class="tab-pane fade" id="pane-3">
                <div class="p-3">
                    @include('profile_components.profession')
                </div>
            </div>
            <div class="tab-pane fade" id="pane-4">
                <div class="p-3">
                    @include('profile_components.islamic_values')
                </div>
            </div>
            <div class="tab-pane fade" id="pane-5">
                <div class="p-3">
                    @include('profile_components.life_style')
                </div>
            </div>
            <div class="tab-pane fade" id="pane-6">
                <div class="p-3">
                    @include('profile_components.hobbies')
                </div>
            </div>
            <div class="tab-pane fade" id="pane-7">
                <div class="p-3">
                    @include('profile_components.gallery')
                </div>
            </div>

        </div>
    </div>
</div>

<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.2/js/bootstrap.bundle.min.js"></script>
<script>
    (function () {
        const scroller = document.getElementById('tabsScrollable');
        const btnLeft = document.getElementById('tabsScrollLeft');
        const btnRight = document.getElementById('tabsScrollRight');

        if (!scroller) return;

        const scrollAmount = () => Math.round(scroller.clientWidth * 0.6);

        btnLeft.addEventListener('click', () => {
            scroller.scrollBy({ left: -scrollAmount(), behavior: 'smooth' });
        });

        btnRight.addEventListener('click', () => {
            scroller.scrollBy({ left: scrollAmount(), behavior: 'smooth' });
        });

        function updateButtons() {
            btnLeft.disabled = scroller.scrollLeft <= 0;
            btnRight.disabled = scroller.scrollLeft + scroller.clientWidth >= scroller.scrollWidth - 1;
        }

        scroller.addEventListener('scroll', () => requestAnimationFrame(updateButtons));
        window.addEventListener('resize', () => requestAnimationFrame(updateButtons));

        // Auto-scroll to center the clicked tab
        scroller.addEventListener('click', (e) => {
            const link = e.target.closest('.nav-link');
            if (!link) return;

            setTimeout(() => {
                const linkRect = link.getBoundingClientRect();
                const scrollerRect = scroller.getBoundingClientRect();
                const linkCenter = linkRect.left + linkRect.width / 2;
                const scrollerCenter = scrollerRect.left + scrollerRect.width / 2;
                const scrollOffset = linkCenter - scrollerCenter;

                scroller.scrollBy({
                    left: scrollOffset,
                    behavior: 'smooth'
                });
            }, 50);
        });

        // Initial button state
        updateButtons();
    })();
</script>
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.8/dist/umd/popper.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.min.js"></script>
<script>
    let userData = @json($user);
    console.log(userData);
</script>

</body>
</html>
