<link rel="stylesheet" href="{{ asset('public/backend/plugins/dropzone/dropzone.min.css') }}">

<form id="media-upload" method="post" action="{{ route('media.store') }}" class="dropzone" enctype="multipart/form-data">
  {{ csrf_field() }}
  <div class="fallback">
    <input type="file" multiple />
  </div>
</form>

<script src="{{ asset('public/backend/plugins/dropzone/dropzone.min.js') }}"></script>
