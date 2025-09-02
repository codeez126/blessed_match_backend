<h4 class="repeating-heading">Life Style</h4>

<div class="row">
    <div class="col-md-12">
        @foreach($user->clientHobbies as $hobbies)
        <span class="badge rounded-pill" style="background-color: {{$hobbies->color}}; color: white">{{$hobbies->emoji . ' '. $hobbies->name}}</span>
        @endforeach
    </div>
</div>

