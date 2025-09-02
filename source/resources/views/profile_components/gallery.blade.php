<h4 class="repeating-heading">Gallery</h4>

<div class="row g-1">
    @foreach($user->clientImages as $images)
    <div class="col-md-3 col-6 theme-card-points">
        <div class="advanced-info-section d-flex align-items-center">
            <img src="{{asset($images->image)}}" alt="Profile Image" class="img-fluid">
        </div>
    </div>
    @endforeach
</div>

