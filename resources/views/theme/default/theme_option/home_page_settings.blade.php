@extends('layouts.app')

@section('content')
    <div class="row">
        <div class="col-sm-3">
			<ul class="nav flex-column nav-tabs settings-tab" role="tablist">
				<li class="nav-item"><a class="nav-link active" data-toggle="tab" href="#hero"><i class="ti-layout-slider-alt"></i> {{ _lang('Hero Area') }}</a></li>
				<li class="nav-item"><a class="nav-link" data-toggle="tab" href="#three_column_banner"><i class="ti-layout-cta-left"></i> {{ _lang('Three Column Banner') }}</a></li>
				<li class="nav-item"><a class="nav-link" data-toggle="tab" href="#trending_items"><i class="ti-layout-grid3"></i> {{ _lang('Trending Items') }}</a></li>
				<li class="nav-item"><a class="nav-link" data-toggle="tab" href="#hot_items"><i class="ti-crown"></i> {{ _lang('Hot Items') }}</a></li>
			</ul>
		</div>
		  
		  
		<div class="col-sm-9">
			<div class="tab-content">
				 
				<div id="hero" class="tab-pane active">
					<div class="card">
						<div class="card-header">
							<span class="panel-title">{{ _lang('Hero Area') }}</span>
						</div>

					  	<div class="card-body">

							<form method="post" class="settings-submit params-panel" autocomplete="off" action="{{ route('theme_option.update',['home_page_settings','store']) }}" enctype="multipart/form-data">
								{{ csrf_field() }}
								<div class="row">

									<div class="col-md-12">
									  	<div class="form-group">
											<label class="control-label">{{ _lang('Hero Title') }}</label>
											<input type="text" class="form-control" name="hero_title" value="{{ get_trans_option('hero_title') }}">
									  	</div>
									</div>


									<div class="col-md-12">
									  	<div class="form-group">
											<label class="control-label">{{ _lang('Hero Content') }}</label>
											<textarea class="form-control" name="hero_content">{{ get_trans_option('hero_content') }}</textarea>
									  	</div>
									</div>

									<div class="col-md-12">
									  	<div class="form-group">
											<label class="control-label">{{ _lang('Hero Button Text') }}</label>
											<input type="text" class="form-control" name="hero_button_text" value="{{ get_trans_option('hero_button_text') }}">
									  	</div>
									</div>

									<div class="col-md-12">
									  	<div class="form-group">
											<label class="control-label">{{ _lang('Hero Button Link') }}</label>
											<input type="text" class="form-control" name="hero_button_link" value="{{ get_trans_option('hero_button_link') }}">
									  	</div>
									</div>

									<div class="col-md-12">
									  	<div class="form-group">
											<label class="control-label">{{ _lang('Hero Banner') }}</label>
											<input type="file" class="dropify" name="hero_banner" data-allowed-file-extensions="png jpg jpeg" data-default-file="{{ get_option('hero_banner') != '' ? asset('public/uploads/media/'.get_option('hero_banner')) : '' }}">
									  	</div>
									</div>
												
									<div class="col-md-12">
									  	<div class="form-group">
											<button type="submit" class="btn btn-primary">{{ _lang('Save Changes') }}</button>
									  	</div>
									</div>
								</div>
						    </form>
					  	</div>
					</div>
				</div>


				<div id="three_column_banner" class="tab-pane fade">
					<div class="card">
						<div class="card-header">
							<span class="panel-title">{{ _lang('Three Column Banner') }}</span>
						</div>

						<div class="card-body"> 
						   <form method="post" class="settings-submit params-panel" autocomplete="off" action="{{ route('theme_option.update',['home_page_settings','store']) }}" enctype="multipart/form-data">
								{{ csrf_field() }}
								<div class="row">

									<div class="col-md-12">
										<div class="form-group">
											<label>
												<input type="hidden" name="enable_three_column_banner" value="0">
												<input type="checkbox" value="1" name="enable_three_column_banner" {{ get_option('enable_three_column_banner') == 1 ? 'checked' : '' }}> {{ _lang('Enable three column banner section') }}
											</label>
										</div>	
									</div>

									<div class="col-md-12">
										<h4>{{ _lang('Column 1') }}</h4>	
										<hr>	
									</div>	

									<div class="col-md-6">
									  	<div class="form-group">
											<label class="control-label">{{ _lang('Title') }}</label>	
											<input type="text" class="form-control" name="three_column_1_title" value="{{ get_trans_option('three_column_1_title') }}">
									  	</div>
									</div>
									
									<div class="col-md-6">
									  	<div class="form-group">
											<label class="control-label">{{ _lang('Sub Title') }}</label>
											<input type="text" class="form-control" name="three_column_1_sub_title" value="{{ get_trans_option('three_column_1_sub_title') }}">
									  	</div>
									</div>

									<div class="col-md-12">
									  	<div class="form-group">
											<label class="control-label">{{ _lang('Background Image') }} (600 X 370)</label>
											<input type="file" class="form-control dropify" name="three_column_1_background_image" data-allowed-file-extensions="png jpg jpeg" data-default-file="{{ get_option('three_column_1_background_image') != '' ? asset('public/uploads/media/'.get_option('three_column_1_background_image')) : '' }}">
									  	</div>
									</div>

									<div class="col-md-6">
									  	<div class="form-group">
											<label class="control-label">{{ _lang('Button Text') }}</label>
											<input type="text" class="form-control" name="three_column_1_button_text" value="{{ get_trans_option('three_column_1_button_text') }}">
									  	</div>
									</div>

									<div class="col-md-6">
									  	<div class="form-group">
											<label class="control-label">{{ _lang('Button Link') }}</label>
											<input type="text" class="form-control" name="three_column_1_button_link" value="{{ get_trans_option('three_column_1_button_link') }}">
									  	</div>
									</div>

									<div class="col-md-12 mt-4">
										<h4>{{ _lang('Column 2') }}</h4>	
										<hr>	
									</div>	

									<div class="col-md-6">
									  	<div class="form-group">
											<label class="control-label">{{ _lang('Title') }}</label>	
											<input type="text" class="form-control" name="three_column_2_title" value="{{ get_trans_option('three_column_2_title') }}">
									  	</div>
									</div>
									
									<div class="col-md-6">
									  	<div class="form-group">
											<label class="control-label">{{ _lang('Sub Title') }}</label>
											<input type="text" class="form-control" name="three_column_2_sub_title" value="{{ get_trans_option('three_column_2_sub_title') }}">
									  	</div>
									</div>

									<div class="col-md-12">
									  	<div class="form-group">
											<label class="control-label">{{ _lang('Background Image') }} (600 X 370)</label>
											<input type="file" class="form-control dropify" name="three_column_2_background_image" data-allowed-file-extensions="png jpg jpeg" data-default-file="{{ get_option('three_column_2_background_image') != '' ? asset('public/uploads/media/'.get_option('three_column_2_background_image')) : '' }}">
									  	</div>
									</div>

									<div class="col-md-6">
									  	<div class="form-group">
											<label class="control-label">{{ _lang('Button Text') }}</label>
											<input type="text" class="form-control" name="three_column_2_button_text" value="{{ get_trans_option('three_column_2_button_text') }}">
									  	</div>
									</div>

									<div class="col-md-6">
									  	<div class="form-group">
											<label class="control-label">{{ _lang('Button Link') }}</label>
											<input type="text" class="form-control" name="three_column_2_button_link" value="{{ get_trans_option('three_column_2_button_link') }}">
									  	</div>
									</div>

									<div class="col-md-12 mt-4">
										<h4>{{ _lang('Column 3') }}</h4>	
										<hr>	
									</div>	

									<div class="col-md-6">
									  	<div class="form-group">
											<label class="control-label">{{ _lang('Title') }}</label>	
											<input type="text" class="form-control" name="three_column_3_title" value="{{ get_trans_option('three_column_3_title') }}">
									  	</div>
									</div>
									
									<div class="col-md-6">
									  	<div class="form-group">
											<label class="control-label">{{ _lang('Sub Title') }}</label>
											<input type="text" class="form-control" name="three_column_3_sub_title" value="{{ get_trans_option('three_column_3_sub_title') }}">
									  	</div>
									</div>

									<div class="col-md-12">
									  	<div class="form-group">
											<label class="control-label">{{ _lang('Background Image') }} (600 X 370)</label>
											<input type="file" class="form-control dropify" name="three_column_3_background_image" data-allowed-file-extensions="png jpg jpeg" data-default-file="{{ get_option('three_column_3_background_image') != '' ? asset('public/uploads/media/'.get_option('three_column_3_background_image')) : '' }}">
									  	</div>
									</div>

									<div class="col-md-6">
									  	<div class="form-group">
											<label class="control-label">{{ _lang('Button Text') }}</label>
											<input type="text" class="form-control" name="three_column_3_button_text" value="{{ get_trans_option('three_column_3_button_text') }}">
									  	</div>
									</div>

									<div class="col-md-6">
									  	<div class="form-group">
											<label class="control-label">{{ _lang('Button Link') }}</label>
											<input type="text" class="form-control" name="three_column_3_button_link" value="{{ get_trans_option('three_column_3_button_link') }}">
									  	</div>
									</div>							

									<div class="col-md-12">
									  	<div class="form-group">
											<button type="submit" class="btn btn-primary">{{ _lang('Save Changes') }}</button>
									  	</div>
									</div>	
								</div>							
							</form>
						</div>
					</div>
				</div>
				
				<div id="trending_items" class="tab-pane fade">
					<div class="card">
						<div class="card-header">
							<span class="panel-title">{{ _lang('Trending Items') }}</span>
						</div>

					    <div class="card-body">
							<form method="post" class="settings-submit params-panel" autocomplete="off" action="{{ route('theme_option.update',['home_page_settings','store']) }}" enctype="multipart/form-data">
								{{ csrf_field() }}

								@php $categories = \App\Entity\Category\Category::all(); @endphp

								@php $trending_categories = get_option('trending_categories'); @endphp

								<div class="row">
									<div class="col-md-12">
										<div class="form-group">
											<label>
												<input type="hidden" name="enable_trending_items" value="0">
												<input type="checkbox" value="1" name="enable_trending_items" {{ get_option('enable_trending_items') == 1 ? 'checked' : '' }}> {{ _lang('Enable Trending items section') }}
											</label>
										</div>	
									</div>

									<div class="col-md-12">
									  	<div class="form-group">
											<label class="control-label">{{ _lang('Title') }}</label>	
											<input type="text" class="form-control" name="trending_items_title" value="{{ get_trans_option('trending_items_title') }}">
									  	</div>
									</div>

									<div class="col-md-6">
									  	<div class="form-group">
											<label class="control-label">{{ _lang('Category 1') }}</label>	
											<select class="form-control select2 auto-select" data-selected="{{ isset($trending_categories[0]) ? $trending_categories[0] : ''  }}" name="trending_categories[0]">
												<option value="">-- {{ _lang('Select Category') }} --</option>
												{{ buildOptionTree($categories, 0, null, 0, -1) }}
											</select>
									  	</div>
									</div>

									<div class="col-md-6">
									  	<div class="form-group">
											<label class="control-label">{{ _lang('Category 2') }}</label>	
											<select class="form-control select2 auto-select" data-selected="{{ isset($trending_categories[1]) ? $trending_categories[1] : '' }}" name="trending_categories[1]">
												<option value="">-- {{ _lang('Select Category') }} --</option>
												{{ buildOptionTree($categories, 0, null, 0, -1) }}
											</select>
									  	</div>
									</div>

									<div class="col-md-6">
									  	<div class="form-group">
											<label class="control-label">{{ _lang('Category 3') }}</label>	
											<select class="form-control select2 auto-select" data-selected="{{ isset($trending_categories[2]) ? $trending_categories[2] : '' }}" name="trending_categories[2]">
												<option value="">-- {{ _lang('Select Category') }} --</option>
												{{ buildOptionTree($categories, 0, null, 0, -1) }}
											</select>
									  	</div>
									</div>

									<div class="col-md-6">
									  	<div class="form-group">
											<label class="control-label">{{ _lang('Category 4') }}</label>	
											<select class="form-control select2 auto-select" data-selected="{{ isset($trending_categories[3]) ? $trending_categories[3] : '' }}" name="trending_categories[3]">
												<option value="">-- {{ _lang('Select Category') }} --</option>
												{{ buildOptionTree($categories, 0, null, 0, -1) }}
											</select>
									  	</div>
									</div>

									<div class="col-md-6">
									  	<div class="form-group">
											<label class="control-label">{{ _lang('Category 5') }}</label>	
											<select class="form-control select2 auto-select" data-selected="{{ isset($trending_categories[4]) ? $trending_categories[4] : '' }}" name="trending_categories[4]">
												<option value="">-- {{ _lang('Select Category') }} --</option>
												{{ buildOptionTree($categories, 0, null, 0, -1) }}
											</select>
									  	</div>
									</div>

									<div class="col-md-6">
									  	<div class="form-group">
											<label class="control-label">{{ _lang('Category 6') }}</label>	
											<select class="form-control select2 auto-select" data-selected="{{ isset($trending_categories[5]) ? $trending_categories[5] : '' }}" name="trending_categories[5]">
												<option value="">-- {{ _lang('Select Category') }} --</option>
												{{ buildOptionTree($categories, 0, null, 0, -1) }}
											</select>
									  	</div>
									</div>

									<div class="col-md-12">
									  	<div class="form-group">
											<button type="submit" class="btn btn-primary">{{ _lang('Save Changes') }}</button>
									  	</div>
									</div>
								</div>						
							</form>
					    </div>
					</div>
				</div>

				<div id="hot_items" class="tab-pane">
					<div class="card">

						<div class="card-header">
							<span class="panel-title">{{ _lang('Hot Items') }}</span>
						</div>

						<div class="card-body">
							 <form method="post" class="settings-submit params-panel" autocomplete="off" action="{{ route('theme_option.update',['home_page_settings','store']) }}" enctype="multipart/form-data">
								{{ csrf_field() }}
								<div class="row">
									<div class="col-md-12">
										<div class="form-group">
											<label>
												<input type="hidden" name="enable_hot_items" value="0">
												<input type="checkbox" value="1" name="enable_hot_items" {{ get_option('enable_hot_items') == 1 ? 'checked' : '' }}> {{ _lang('Enable Hot items section') }}
											</label>
										</div>	
									</div>

									<div class="col-md-12">
									  	<div class="form-group">
											<label class="control-label">{{ _lang('Hot Items Title') }}</label>	
											<input type="text" class="form-control" name="hot_items_title" value="{{ get_trans_option('hot_items_title') }}">
									  	</div>
									</div>

									<div class="col-md-12">
									  	<div class="form-group">
											<label class="control-label">{{ _lang('Hot Items') }}</label>	
											<select class="form-control select-products" name="hot_items[]" multiple>
												@if(get_option('hot_items') != '')
													@foreach(\App\Entity\Product\Product::whereIn('id', get_option('hot_items'))->get() as $product)
														<option value="{{ $product->id }}" selected>{{ $product->translation->name }}</option>
													@endforeach
												@endif
											</select>
									  	</div>
									</div>

									<div class="col-md-12">
									  	<div class="form-group">
											<label class="control-label">{{ _lang('On Sale Title') }}</label>	
											<input type="text" class="form-control" name="on_sale_items_title" value="{{ get_trans_option('on_sale_items_title') }}">
									  	</div>
									</div>

									<div class="col-md-12">
									  	<div class="form-group">
											<label class="control-label">{{ _lang('On Sale Items') }}</label>	
											<select class="form-control select-products" name="on_sale_items[]" multiple="">	
												@if(get_option('on_sale_items') != '')
													@foreach(\App\Entity\Product\Product::whereIn('id', get_option('on_sale_items'))->get() as $product)
														<option value="{{ $product->id }}" selected>{{ $product->translation->name }}</option>
													@endforeach
												@endif
											</select>
									  	</div>
									</div>

									<div class="col-md-12">
									  	<div class="form-group">
											<label class="control-label">{{ _lang('Best Seller Title') }}</label>	
											<input type="text" class="form-control" name="best_seller_title" value="{{ get_trans_option('best_seller_title') }}">
									  	</div>
									</div>

									<div class="col-md-12">
									  	<div class="form-group">
											<label class="control-label">{{ _lang('Best Seller Items') }}</label>	
											<select class="form-control select-products" name="best_seller_items[]" multiple>
												@if(get_option('best_seller_items') != '')
													@foreach(\App\Entity\Product\Product::whereIn('id', get_option('best_seller_items'))->get() as $product)
														<option value="{{ $product->id }}" selected>{{ $product->translation->name }}</option>
													@endforeach
												@endif
											</select>
									  	</div>
									</div>

									<div class="col-md-12">
									  	<div class="form-group">
											<label class="control-label">{{ _lang('Top Viewed Title') }}</label>	
											<input type="text" class="form-control" name="top_views_title" value="{{ get_trans_option('top_views_title') }}">
									  	</div>
									</div>

									<div class="col-md-12">
									  	<div class="form-group">
											<label class="control-label">{{ _lang('Top Viewed Items') }}</label>	
											<select class="form-control select-products" name="top_views_items[]" multiple="">
												@if(get_option('top_views_items') != '')
													@foreach(\App\Entity\Product\Product::whereIn('id', get_option('top_views_items'))->get() as $product)
														<option value="{{ $product->id }}" selected>{{ $product->translation->name }}</option>
													@endforeach
												@endif
											</select>
									  	</div>
									</div>
																			
									<div class="col-md-12">
									  	<div class="form-group">
											<button type="submit" class="btn btn-primary">{{ _lang('Save Changes') }}</button>
									  	</div>
									</div>
								</div>
							</form>
						</div>
					</div>
				</div>
				
			</div>	<!--End tab Content-->  
		</div>
	</div>
</div>
@endsection
