@foreach($comments as $comment)
	<div class="single-comment {{ $comment->parent_id != null ? 'left' : '' }}">
		<img src="{{ profile_picture($comment->user->profile_picture)  }}" alt="#">
		<div class="content">
			<h4>{{ $comment->user->name }} <span>{{ _lang('At').' '.$comment->created_at }} </span></h4>
			<p>{{ $comment->body }}</p>
			
			@if(auth()->check())
				<div class="button">
					<a href="#" class="btn reply-btn-toggle"><i class="fa fa-reply" aria-hidden="true"></i>{{ _lang('Reply') }}</a>
				</div>
			
				<form method="post" class="reply-form comment-form d-none" action="{{ route('comments.store') }}">
					@csrf
					<div class="form-group">
						<input type="text" name="body" class="form-control" required/>
						<input type="hidden" name="product_id" value="{{ $comment->product_id }}" />
						<input type="hidden" name="parent_id" value="{{ $comment->id }}" />
					</div>
					<div class="form-group">
						<button type="submit" class="btn-reply">{{ _lang('Reply') }}</button>
					</div>
				</form>
			@else
				<div class="button">
					<a href="{{ url('sign_in') }}" class="btn"><i class="fa fa-reply" aria-hidden="true"></i>{{ _lang('Reply') }}</a>
				</div>
			@endif	
		</div>
	</div>

	@include('theme.default.components.comments', ['comments' => $comment->replies])


@endforeach
	
