@extends('layouts.app')

@section('content')
<div class="row">
	<div class="col-lg-12">
		<form method="post" id="update_product" class="validate" autocomplete="off" action="{{ action('ProductController@update', $id) }}" enctype="multipart/form-data">
			{{ csrf_field()}}
			<input name="_method" type="hidden" value="PATCH">				
			
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
								        <input type="text" class="form-control" name="name" value="{{ $product->translation->name }}" required>
							        </div>
							    </div>

							    <div class="col-md-12">
							        <div class="form-group">
								        <label class="control-label">{{ _lang('Description') }} <span class="required"> *</span></label>
								        <textarea class="form-control summernote" name="description">{{ $product->translation->description }}</textarea>
							        </div>
							    </div>

							    <div class="col-md-12">
							        <div class="form-group">
								        <label class="control-label">{{ _lang('Short Description') }}</label>						
								        <textarea class="form-control" name="short_description">{{ $product->translation->short_description }}</textarea>
							        </div>
							    </div>

								<div class="col-md-6">
							        <div class="form-group">
								        <label class="control-label">{{ _lang('Brand') }}</label>						
								        <select class="form-control auto-select select2" data-selected="{{ $product->brand_id }}" name="brand_id">
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
								        <select class="form-control auto-select select2" data-selected="{{ $product->tax_class_id }}" name="tax_class_id">
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
								        <select class="form-control auto-multiple-select select2" data-selected="{{ $product->categories->pluck('id') }}" name="categories[]" multiple>
								        	{{ buildOptionTree(\App\Entity\Category\Category::all(), 0, null, 0, -1) }}
										</select>
									</div>
							    </div>

  								<div class="col-md-12">
							        <div class="form-group">
								        <label class="control-label">{{ _lang('Tags') }}</label>						
								        <select class="form-control auto-multiple-select select2" data-selected="{{ $product->tags->pluck('id') }}" name="tags[]" multiple>
											@foreach(\App\Entity\Tag\Tag::all() as $tag)
												<option value="{{ $tag->id }}">{{ $tag->translation->name }}</option>
											@endforeach
										</select>
									</div>
							    </div>

								<div class="col-md-6">
							        <div class="form-group">
								        <label class="control-label">{{ _lang('Price').' ('.currency().')' }}</label>						
								        <input type="text" class="form-control float-field" name="price" value="{{ $product->price }}" required>
							        </div>
							    </div>

								<div class="col-md-6">
							        <div class="form-group">
								        <label class="control-label">{{ _lang('Special Price').' ('.currency().')' }}</label>						
								        <input type="text" class="form-control float-field" name="special_price" value="{{ $product->special_price }}">
							        </div>
							    </div>

								<div class="col-md-6">
							        <div class="form-group">
								        <label class="control-label">{{ _lang('Status') }}</label>						
								        <select class="form-control auto-select" data-selected="{{ $product->is_active }}" name="is_active" required>
											<option value="1">{{ _lang('Active') }}</option>
											<option value="0">{{ _lang('Inactive') }}</option>
										</select>
									</div>
							    </div>

							     <div class="col-md-6">
							        <div class="form-group">
								        <label class="control-label">{{ _lang('Featured Tag') }}</label>						
								        <select class="form-control auto-select" data-selected="{{ $product->featured_tag }}" name="featured_tag">
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
								        <select class="form-control auto-select" id="product_type" data-selected="{{ $product->product_type }}" name="product_type" required>
											<option value="simple_product">{{ _lang('Simple Product') }}</option>
											<option value="variable_product">{{ _lang('Variable Product') }}</option>
											<option value="digital_product">{{ _lang('Digital Product') }}</option>
										</select>
									</div>
							    </div>

								@if($product->product_type == 'variable_product')
									<div class="col-md-12">
										<div class="form-group">
											<label>
												<input type="checkbox" value="1" name="update_variation" id="update_variation"> {{ _lang('Update Variations') }}
											</label>
										</div>
									</div>
								@endif

								<div class="col-md-12 {{ $product->product_type == 'digital_product' ? '' : 'd-none' }}" id="digital_file">
								    <div class="form-group">
									    <label class="control-label">
									    	{{ _lang('Upload File') }} ({{ _lang('Zip Only') }}) 
									    	<span class="required"> *</span>
									    </label>
									    <input type="file" class="form-control dropify" name="digital_file" data-allowed-file-extensions="zip" data-max-file-size="{{ get_option('digital_file_max_upload_size',2) }}M"  data-default-file="{{ asset('storage/app/'.$product->digital_file) }}" >
								    </div>
								</div>

								<div class="col-md-12 variable-product {{ $product->product_type == 'variable_product' ? '' : 'd-none' }}">

                                    @if(! $product->product_options->isEmpty())
									    @foreach($product->product_options as $product_option)	
										<div class="row product-option" {{ $loop->first ? 'id=option' : '' }}>
											<div class="col-md-6">
										        <div class="form-group">
											        <label class="control-label">{{ _lang('Option Name') }}</label>
											        <input type="text" class="form-control product_option" name="product_option[]" value="{{ $product_option->name }}" placeholder="Ex - Color">
										        </div>
										    </div>

										    <div class="col-md-6">
										        <div class="form-group">
											        <label class="control-label">{{ _lang('Option Value') }}</label>
											        <input type="text" class="form-control product_option_value" name="product_option_value[]" value="{{ str_replace(array('[', '"',']'),'',$product_option->items->pluck('name')) }}" placeholder="Ex - Red, Green, Blue">
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
				                <div class="col-md-12 variable-product {{ $product->product_type == 'variable_product' ? '' : 'd-none' }}">
				                	<div class="card">

										<div class="card-header">
											<span class="panel-title">{{ _lang('Variations Prices') }}</span>
										</div>

										<div class="card-body">
											<div class="table-responsive">
												<table class="table table-bordered" id="variations-prices-table">
													<thead>	
														@foreach($product->product_options as $product_option)
															<th>{{ $product_option->name }}</th>
														@endforeach
														<th>{{ _lang('Price') }}</th>
														<th>{{ _lang('Special Price') }}</th>
														<th class="text-center">{{ _lang('Is Available') }}</th>
													</thead>
													<tbody>
														@foreach($product->variation_prices as $variation_price)	
															<tr>
																@foreach(json_decode($variation_price->option) as $option)
																	<td>{{ $option->name }}</td>
																@endforeach
																<td>
																	<input type="text" name="variation_price[]" class="form-control" value="{{ $variation_price->price }}" placeholder="{{ _lang('Regular Price') }}">
																</td>
																<td>
																	<input type="text" name="variation_special_price[]" class="form-control" value="{{ $variation_price->special_price }}" placeholder="{{ _lang('Special Price') }}">
																</td>
																<td class="text-center">
																	<input type="checkbox" name="is_available[]" value="1" {{ $variation_price->is_available == 1 ? 'checked' : '' }}>
																</td>
															</tr>
														@endforeach
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
				                </div><!--End Product Variations-->
									
								<div class="col-md-12">
									<div class="form-group">
										<button type="submit" class="btn btn-primary">{{ _lang('Update Product') }}</button>
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
										        <input type="text" class="form-control" name="sku" value="{{ $product->sku }}">
									        </div>
									    </div>

										<div class="col-md-12">
									        <div class="form-group">
										        <label class="control-label">{{ _lang('Manage Inventory') }}</label>						
										        <select class="form-control auto-select" data-selected="{{ $product->manage_stock }}" name="manage_stock" id="manage_inventory" required>
													<option value="0">{{ _lang('No') }}</option>
													<option value="1">{{ _lang('Yes') }}</option>
												</select>
											</div>
									    </div>

										<div class="col-md-12 inventory-quantity {{ $product->manage_stock == '0' ? 'd-none' : '' }}">
									        <div class="form-group">
										        <label class="control-label">{{ _lang('Qty') }} <span class="required"> *</span></label>
										        <input type="number" class="form-control" name="qty" value="{{ $product->qty }}">
									        </div>
									    </div>

										<div class="col-md-12">
									        <div class="form-group">
										        <label class="control-label">{{ _lang('In Stock') }}</label>						
										        <select class="form-control auto-select" data-selected="{{ $product->in_stock }}" name="in_stock">
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
										        <input type="text" class="form-control" name="meta[meta_title]" value="{{ $product->meta->translation->meta_title }}">
									        </div>
									    </div>

									    <div class="col-md-12">
									        <div class="form-group">
										        <label class="control-label">{{ _lang('Meta Leywords') }}</label>
										        <input type="text" class="form-control" name="meta[meta_keywords]" value="{{ $product->meta->translation->meta_keywords }}">
									        </div>
									    </div>

									    <div class="col-md-12">
									        <div class="form-group">
										        <label class="control-label">{{ _lang('Meta Description') }}</label>
										        <textarea name="meta[meta_description]" class="form-control">{{ $product->meta->translation->meta_description }}</textarea>
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
								        	@if(isset($product->image->pivot))
								        		<div class="image">
								        			<img src="{{ asset('storage/app/'. $product->image->file_path) }}">
								        			<input type="hidden" name="files[product_image]" value="{{ $product->image->pivot->media_id }}">
								        		    <i class="remove-media fas fa-times"></i>
								        		</div>
								        	@endif
								        </div>
							        </div>


							        <div class="form-group">				
								        <button type="button" class="choose-media btn btn-light" data-multiple="true" data-media-type="image" data-input-name="files[gallery_images][]">
								            <i class="fa fa-folder-open m-r-5"></i> {{ _lang('Gallery Images') }}
								        </button>
								        <div class="multiple-image-container">
								        	@if(isset($product->gallery_images))
								        	    @foreach($product->gallery_images as $gallery_image)
									        	    <div class="image">
										        		<img src="{{ asset('storage/app/'. $gallery_image->file_path) }}">
										        		<input type="hidden" name="files[gallery_images][]" value="{{ $gallery_image->pivot->media_id }}">
										        		<i class="remove-media fas fa-times"></i>
										        	</div>
									        	@endforeach
								        	@endif
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


