@component('mail::message')
    <div id="resetPassword">
        <h3 class="title type01">Post Created!</h3>

        <p class="body type01">Hi, {{$receiver ? $receiver->email : ""}}.</p>

        <p class="body type01">
            [{{config("app.name")}}] {{$blog->title}} blog has new post {{$post->title}}. If you want to check this post, click "See Post" button.
        </p>

        <div class="btns" style="text-align:center;">
            <a href="{{$post ? $post->url() : ''}}" class="btn type01 width-100 bg-primary">See Post</a>
        </div>
    </div>
@endcomponent
