@extends('layouts.app')

@section('content')

<div class="row">
	<div class="col-lg-12">
		<span class="panel-title d-none">{{ _lang('Add Product') }}</span>

	    <form method="post" class="validate" autocomplete="off" action="{{ route('products.store') }}" enctype="multipart/form-data">
			{{ csrf_field() }}
			<div class="row">
				<div class="col-lg-8">
					<div class="card">

						<div class="card-header">
							<span class="panel-title">{{ _lang('General Information') }}</span>
						</div>

						<div class="card-body">
							<div class="row">
								<div class="col-md-12">
							        <div class="form-group">
								        <label class="control-label">{{ _lang('Name') }}</label>						
								        <input type="text" class="form-control" name="name" value="{{ old('name') }}" required>
							        </div>
							    </div>

							    <div class="col-md-12">
							        <div class="form-group">
								        <label class="control-label">{{ _lang('Description') }} <span class="required"> *</span></label>
								        <textarea class="form-control summernote" name="description">{{ old('description') }}</textarea>
							        </div>
							    </div>

							    <div class="col-md-12">
							        <div class="form-group">
								        <label class="control-label">{{ _lang('Short Description') }}</label>
								        <textarea class="form-control" name="short_description">{{ old('short_description') }}</textarea>
							        </div>
							    </div>

								<div class="col-md-6">
							        <div class="form-group">
								        <label class="control-label">{{ _lang('Brand') }}</label>						
								        <select class="form-control auto-select select2" data-selected="{{ old('brand_id') }}" name="brand_id">
							                <option value="">{{ _lang('Select One') }}</option>
											@foreach(\App\Entity\Brand\Brand::all() as $brand)
												<option value="{{ $brand->id }}">{{ $brand->translation->name }}</option>
											@endforeach
										</select>
									</div>
							    </div>

								<div class="col-md-6">
							        <div class="form-group">
								        <label class="control-label">{{ _lang('Tax Class') }}</label>						
								        <select class="form-control auto-select select2" data-selected="{{ old('tax_class_id') }}" name="tax_class_id">
							                <option value="">{{ _lang('Select One') }}</option>
											@foreach(\App\Entity\Tax\Tax::all() as $tax)
												<option value="{{ $tax->id }}">{{ $tax->translation->name }}</option>
											@endforeach
										</select>
									</div>
							    </div>

							    <div class="col-md-12">
							        <div class="form-group">
								        <label class="control-label">{{ _lang('Categories') }}</label>						
								        <select class="form-control auto-multiple-select select2" data-selected="[{{ old('categories') ? implode (', ', old('categories')) : '' }}]" name="categories[]" multiple>
								        	{{ buildOptionTree(\App\Entity\Category\Category::all(), 0, null, 0, -1) }}
										</select>
									</div>
							    </div>

  								<div class="col-md-12">
							        <div class="form-group">
								        <label class="control-label">{{ _lang('Tags') }}</label>						
								        <select class="form-control auto-multiple-select select2" data-selected="[{{ old('tags') ? implode (', ', old('tags')) : '' }}]" name="tags[]" multiple>
											@foreach(\App\Entity\Tag\Tag::all() as $tag)
												<option value="{{ $tag->id }}">{{ $tag->translation->name }}</option>
											@endforeach
										</select>
									</div>
							    </div>

								<div class="col-md-6">
							        <div class="form-group">
								        <label class="control-label">{{ _lang('Price').' ('.currency().')' }}</label>						
								        <input type="text" class="form-control float-field" name="price" value="{{ old('price') }}" required>
							        </div>
							    </div>

								<div class="col-md-6">
							        <div class="form-group">
								        <label class="control-label">{{ _lang('Special Price').' ('.currency().')' }}</label>						
								        <input type="text" class="form-control float-field" name="special_price" value="{{ old('special_price') }}">
							        </div>
							    </div>

							    <div class="col-md-6">
							        <div class="form-group">
								        <label class="control-label">{{ _lang('Status') }}</label>						
								        <select class="form-control auto-select" data-selected="{{ old('is_active',1) }}" name="is_active" required>
											<option value="1">{{ _lang('Active') }}</option>
											<option value="0">{{ _lang('Inactive') }}</option>
										</select>
									</div>
							    </div>

							    <div class="col-md-6">
							        <div class="form-group">
								        <label class="control-label">{{ _lang('Featured Tag') }}</label>						
								        <select class="form-control auto-select" data-selected="{{ old('featured_tag') }}" name="featured_tag">
											<option value="">{{ _lang('Nothing') }}</option>
											<option value="featured">{{ _lang('Featured') }}</option>
											<option value="on_sale">{{ _lang('On Sale') }}</option>
											<option value="exclusive">{{ _lang('Exclusive') }}</option>
											<option value="new">{{ _lang('New') }}</option>
										</select>
									</div>
							    </div>


								<div class="col-md-12">
							        <div class="form-group">
								        <label class="control-label">{{ _lang('Product Type') }}</label>						
								        <select class="form-control auto-select" id="product_type" data-selected="{{ old('product_type','simple_product') }}" name="product_type" required>
											<option value="simple_product">{{ _lang('Simple Product') }}</option>
											<option value="variable_product">{{ _lang('Variable Product') }}</option>
											<option value="digital_product">{{ _lang('Digital Product') }}</option>
										</select>
									</div>
							    </div>
	

								<div class="col-md-12 d-none" id="digital_file">
								    <div class="form-group">
									    <label class="control-label">
									    	{{ _lang('Upload File') }} ({{ _lang('Zip Only') }}) 
									    	<span class="required"> *</span>
									    </label>						
									    <input type="file" class="form-control dropify" name="digital_file" data-allowed-file-extensions="zip" data-max-file-size="{{ get_option('digital_file_max_upload_size',2) }}M">
								    </div>
								</div>

                                
								<div class="col-md-12 variable-product {{ old('product_type') == 'variable_product' ? '' : 'd-none' }}">

                                    @if(old('product_option'))
									    @foreach(old('product_option') as $product_option)	
										<div class="row product-option" {{ $loop->first ? 'id="option"' : '' }}>
											<div class="col-md-6">
										        <div class="form-group">
											        <label class="control-label">{{ _lang('Option Name') }}</label>
											        <input type="text" class="form-control product_option" name="product_option[]" value="{{ $product_option }}" placeholder="Ex - Color">
										        </div>
										    </div>

										    <div class="col-md-6">
										        <div class="form-group">
											        <label class="control-label">{{ _lang('Option Value') }}</label>			
											        <input type="text" class="form-control product_option_value" name="product_option_value[]" value="{{ old('product_option_value.'.$loop->index) }}" placeholder="Ex - Red, Green, Blue">
										        </div>
										    </div>
									    </div>
									    @endforeach
									@else
									    <div class="row product-option" id="option">
											<div class="col-md-6">
										        <div class="form-group">
											        <label class="control-label">{{ _lang('Option Name') }}</label>
											        <input type="text" class="form-control product_option" name="product_option[]" value="" placeholder="Ex - Color">
										        </div>
										    </div>

										    <div class="col-md-6">
										        <div class="form-group">
											        <label class="control-label">{{ _lang('Option Value') }}</label>	
											        <input type="text" class="form-control product_option_value" name="product_option_value[]" placeholder="Ex - Red, Green, Blue">
										        </div>
										    </div>
									    </div>
								    @endif

								    <button type="button" class="btn btn-dark btn-xs float-right" id="add_more_option">
								    	<i class="ti-plus"></i> {{ _lang('Add More Option') }}
								    </button>
								</div>

								<!--Product Variations-->
				                <div class="col-md-12 variable-product {{ old('product_type') == 'variable_product' ? '' : 'd-none' }}">
				                	<div class="card">

										<div class="card-header">
											<span class="panel-title">{{ _lang('Variations Prices') }}</span>
										</div>

										<div class="card-body">
											<div class="table-responsive">
												<table class="table table-bordered" id="variations-prices-table">
													<thead>
														@if(old('variation_price'))
															@foreach(old('product_option') as $product_option)	
																<th>{{ $product_option }}</th>
															@endforeach
															<th>{{ _lang('Price') }}</th>
															<th>{{ _lang('Special Price') }}</th>
															<th class="text-center">{{ _lang('Is Available') }}</th>
														@endif
													</thead>
													<tbody>
														@if(old('variation_price'))
															@foreach(old('variation_price') as $variation_price)	
																<tr>
																	@foreach(old('product_option') as $product_option)		
																		<td>{{ $product_option }}</td>
																	@endforeach
																	<td>
																		<input type="text" name="variation_price[]" class="form-control" value="{{ old('variation_price.'.$loop->index) }}" placeholder="{{ _lang('Regular Price') }}">
																	</td>
																	<td>
																		<input type="text" name="variation_special_price[]" class="form-control" value="{{ old('variation_special_price.'.$loop->index) }}" placeholder="{{ _lang('Special Price') }}">
																	</td>
																	<td class="text-center">
																		<input type="checkbox" name="is_available[]" value="{{ old('is_available.'.$loop->index) }}">
																	</td>
																</tr>
															@endforeach
														@endif
													</tbody>
												</table>
											</div>

											<button type="button" class="btn btn-light btn-xs btn-block" id="generate_variations">
										    	<i class="ti-reload"></i> {{ _lang('Generate Variations') }}
										    </button>

										    <div class="text-center">
										    	<small>{{ _lang('Click Generate Variations after adding/updating all Option Value') }}</small>
											</div>
										</div>

									</div>
				                </div>

									
								<div class="col-md-12">
									<div class="form-group">
										<button type="submit" class="btn btn-primary">{{ _lang('Save Product') }}</button>
									</div>
								</div>
							</div>
						</div>
					</div>
				</div>

                 
                <div class="col-lg-4">
                	<div class="row">

		                <div class="col-md-12">
		                	<div class="card">

								<div class="card-header">
									<span class="panel-title">{{ _lang('Inventory') }}</span>
								</div>

								<div class="card-body">
									<div class="row">
										<div class="col-md-12">
									        <div class="form-group">
										        <label class="control-label">{{ _lang('SKU') }}</label>						
										        <input type="text" class="form-control" name="sku" value="{{ old('sku') }}">
									        </div>
									    </div>

										<div class="col-md-12">
									        <div class="form-group">
										        <label class="control-label">{{ _lang('Manage Inventory') }}</label>						
										        <select class="form-control auto-select" data-selected="{{ old('manage_stock',0) }}" name="manage_stock" id="manage_inventory" required>
													<option value="0">{{ _lang('No') }}</option>
													<option value="1">{{ _lang('Yes') }}</option>
												</select>
											</div>
									    </div>

										<div class="col-md-12 inventory-quantity d-none">
									        <div class="form-group">
										        <label class="control-label">{{ _lang('Qty') }} <span class="required"> *</span></label>
										        <input type="number" class="form-control" name="qty" value="{{ old('qty') }}">
									        </div>
									    </div>

										<div class="col-md-12">
									        <div class="form-group">
										        <label class="control-label">{{ _lang('In Stock') }}</label>						
										        <select class="form-control auto-select" data-selected="{{ old('in_stock',1) }}" name="in_stock">
													<option value="1">{{ _lang('In Stock') }}</option>
													<option value="0">{{ _lang('Out of Stock') }}</option>
												</select>
											</div>
									    </div>
								    </div>
								</div>

							</div>
		                </div>


		                <!--Meta data-->
		                <div class="col-md-12">
		                	<div class="card">

								<div class="card-header">
									<span class="panel-title">{{ _lang('SEO') }}</span>
								</div>

								<div class="card-body">
									<div class="row">

										<div class="col-md-12">
									        <div class="form-group">
										        <label class="control-label">{{ _lang('Meta Title') }}</label>
										        <input type="text" class="form-control" name="meta[meta_title]" value="{{ old('meta[meta_title]') }}">
									        </div>
									    </div>

									    <div class="col-md-12">
									        <div class="form-group">
										        <label class="control-label">{{ _lang('Meta Leywords') }}</label>
										        <input type="text" class="form-control" name="meta[meta_keywords]" value="{{ old('meta[meta_keywords]') }}">
									        </div>
									    </div>

									    <div class="col-md-12">
									        <div class="form-group">
										        <label class="control-label">{{ _lang('Meta Description') }}</label>
										        <textarea name="meta[meta_description]" class="form-control">{{ old('meta[meta_description]') }}</textarea>
									        </div>
									    </div>

								    </div>
								</div>

							</div>
		                </div>



		                <div class="col-md-12">
		                	<div class="card">

								<div class="card-header">
									<span class="panel-title">{{ _lang('Images') }}</span>
								</div>

								<div class="card-body">
									<div class="form-group">				
								        <button type="button" class="choose-media btn btn-light" data-media-type="image" data-input-name="files[product_image]">
								            <i class="fa fa-folder-open m-r-5"></i> {{ _lang('Product Image') }}
								        </button>
								        <div class="image-container">
								        </div>
							        </div>


							        <div class="form-group">				
								        <button type="button" class="choose-media btn btn-light" data-multiple="true" data-media-type="image" data-input-name="files[gallery_images][]">
								            <i class="fa fa-folder-open m-r-5"></i> {{ _lang('Gallery Images') }}
								        </button>
								        <div class="multiple-image-container">
								        </div>
							        </div>
								</div>

							</div>
		                </div>


	                </div>	
                </div>	

			</div><!--End Row-->			
	    </form>
    </div>
</div>
@endsection

@section('js-script')
<script src="{{ asset('public/backend/assets/js/product.js') }}"></script>
@endsection


