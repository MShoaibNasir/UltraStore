<?php

namespace App\Http\Controllers\Website;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Entity\Product\Product;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\Mail;
use App\Mail\ContactUs;
use Cart;
use Auth;
use DB;
use App\Utilities\Overrider;
use Validator;
use Newsletter;

class WebsiteController extends Controller
{
    private $theme;  

    public function __construct()
    {  
        $this->theme = env('ACTIVE_THEME','default');
         
        if(env('APP_INSTALLED',true) == true){
            $this->middleware(function ($request, $next) {
               
                if(isset($_GET['language'])){
                    session(['language' => $_GET['language']]);
                    return back();
                }

                if(isset($_GET['currency'])){
                    session(['currency' => $_GET['currency']]); //This is using for frontend
                    //\Cache::put('currency', $_GET['currency']);

                    session(['display_currency_rate' => '']);
                    //\Cache::forget('display_currency_rate');

                    return back();
                }

                return $next($request);

            });
            
            date_default_timezone_set(get_option('timezone','Asia/Dhaka'));  
        }
    }

    /**
     * Show the Home Page
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index($slug = '')
    {
         
        if($slug == ''){
            return view("theme.$this->theme.index");
        }

        $page = \App\Entity\Page\Page::where('slug',$slug)
                                     ->where('status',1)->first();
        
        if(! $page ){
            abort(404);
        }

        $seo_title = $page->meta->translation->meta_title;
        if($seo_title == NULL){
            $seo_title = $page->translation->title;
        }

        $meta_keywords = $page->meta->translation->meta_keywords;
        $meta_description = $page->meta->translation->meta_description;

        if($page->template != NULL){
             return view("theme.$this->theme.templates.template-$page->template", compact('page', 'seo_title', 'meta_keywords', 'meta_description'));
        }
        
        return view("theme.$this->theme.page", compact('page', 'seo_title', 'meta_keywords', 'meta_description'));

    }

    /**
     * Show the Shop Page.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function shop()
    {
        $data = array();

        //Category Wise Search
        $category = isset(request()->category) ? request()->category : '';
        if($category != 'all' && $category != ''){
            $search = isset(request()->search) ? request()->search : '';
            return redirect('categories/' . $category . '?category=' . $category . '&search=' . $search);
        }
        
        $data['products'] = $this->filter(Product::where('is_active',1)); 
        $data['seo_title'] = _lang('Shop').' - '.get_option('site_title');                    

        return view("theme.$this->theme.shop", $data);
    }

     /**
     * Show single product.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function product($slug = '')
    {
        $product = Product::where('slug',$slug)
                          ->where('is_active',1)
                          ->first();
        if(! $product){
            abort(404);
        }

        $product->viewed = $product->viewed + 1;
        $product->save();

        if(request()->ajax()){
            $productView = view("theme.$this->theme.components.quick_shop",compact('product'))->render();
            return response()->json(['result' => true, 'productView' => $productView]);
        }

        $seo_title = $product->meta->translation->meta_title;
        if($seo_title == NULL){
            $seo_title = $product->translation->name;
        }
        $meta_keywords = $product->meta->translation->meta_keywords;
        $meta_description = $product->meta->translation->meta_description;

        return view("theme.$this->theme.single-product",compact('product', 'seo_title', 'meta_keywords', 'meta_description'));
    }

     /**
     * Show Categories Product
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function categories($slug = '')
    {
        $category = \App\Entity\Category\Category::where('slug', $slug)->first();

        $products = $this->filter($category->products());   

        $seo_title = $category->translation->name.' - '.get_option('site_title');    

        return view("theme.$this->theme.shop",compact('products','slug','seo_title'));
    }

    /**
     * Show Brand
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function brands($slug = '')
    {
        if($slug == ''){
            $brands = \App\Entity\Brand\Brand::all();
            $seo_title = _lang('Brands').' - '.get_option('site_title'); 
            return view("theme.$this->theme.brands", compact('brands','seo_title'));
        }else{
            $brand = \App\Entity\Brand\Brand::where('slug',$slug)->first();
            $products = $this->filter($brand->products());   
            $seo_title = $brand->translation->name.' - '.get_option('site_title'); 
        }

        $brand_slug = $slug;
        return view("theme.$this->theme.shop",compact('products','brand_slug','seo_title'));
    }

     /**
     * Show Categories Product
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function tags($slug = '')
    {
        $length = isset(request()->length) ? request()->length : 9;
        $sort_by = isset(request()->sort_by) ? request()->sort_by : '';

        $tag = \App\Entity\Tag\Tag::where('slug', $slug)->first();
        $products = $this->filter($tag->products());

        $tag_slug = $slug; 
        $seo_title = $tag->translation->name.' - '.get_option('site_title');                             

        return view("theme.$this->theme.shop",compact('products','tag_slug','seo_title'));
    }


    /**
     * Show the Wish List Page.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function wish_list(Request $request, $product_id = '')
    {
        if(! Auth::check()){
            if($request->ajax()){ 
                return response()->json(['result' => false, 'message' => _lang('You need to login first !')]);
            }else{
                return redirect('sign_in');
            }  
        }

        if($product_id != ''){
            if (! Auth::user()->wishlistHas($product_id)) {
                Auth::user()->wishlist()->attach($product_id);
            }

            if($request->ajax()){ 
                return response()->json(['result' => true, 'total_items' => auth()->user()->wishlist->count(), 'message' => _lang('Added to Wishlist')]);
            }else{
                 return back();
            }  
            
        }else{
            $seo_title = _lang('Wishlist').' - '.get_option('site_title');
            return view("theme.$this->theme.wish_list", compact('seo_title'));
        }

    }

    /**
     * Destroy resources by the given id.
     *
     * @param string $productId
     * @return void
     */
    public function remove_wishlist($product_id)
    {
        if(! Auth::check()){
            return redirect('sign_in');
        }

        Auth::user()->wishlist()->detach($product_id);
        return back();
    }

    /**
     * Show the Cart Page.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function cart()
    {
        $cartTotal = Cart::getSubTotal();
        $shipping = Cart::getConditionsByType('shipping');

        //Apply Initial Shipping
        if(count($shipping) == 0 && $cartTotal > 0){
            if($cartTotal >= get_option('free_shipping_minimum_amount')){ 
                $shipping = new \Darryldecode\Cart\CartCondition(array(
                    'name'   => get_option('free_shipping_label'),
                    'type'   => 'shipping',
                    'target' => 'total',
                    'value'  => '0',
                    'order' => 1
                ));
                Cart::condition($shipping);
            }else{
                $shipping = new \Darryldecode\Cart\CartCondition(array(
                    'name' => get_option('flat_rate_active') == 'Yes' ? get_option('flat_rate_label') : get_option('local_pickup_label'),
                    'type'   => 'shipping',
                    'target' => 'total',
                    'value'  => get_option('flat_rate_active') == 'Yes' ? '+'.get_option('flat_rate_cost') : '+'.get_option('local_pickup_cost'),
                    'order' => 1
                ));
                Cart::condition($shipping); 
            }
        }

        $seo_title = _lang('Cart').' - '.get_option('site_title');
        return view("theme.$this->theme.cart", compact('seo_title'));
    }

    /**
     * Show the Checkout Page.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function checkout()
    {
        $cartTotal = Cart::getSubTotal();
        $shipping = Cart::getConditionsByType('shipping');
		
		if(get_option('free_shipping_active') != 'Yes' && 
		   get_option('flat_rate_active') != 'Yes' &&
		   get_option('local_pickup_label') != 'Yes'){
			   return redirect('/')->with('checkout_error',_lang('No Shipping Method found !')); 
		   }

        //Apply Initial Shipping
        if(count($shipping) == 0 && $cartTotal > 0){
            if(get_option('free_shipping_active') == 'Yes' && $cartTotal >= get_option('free_shipping_minimum_amount')){ 
                $shipping = new \Darryldecode\Cart\CartCondition(array(
                    'name'   => get_option('free_shipping_label'),
                    'type'   => 'shipping',
                    'target' => 'total',
                    'value'  => '0',
                    'order' => 1
                ));
                Cart::condition($shipping);
            }else{
                $shipping = new \Darryldecode\Cart\CartCondition(array(
                    'name' => get_option('flat_rate_active') == 'Yes' ? get_option('flat_rate_label') : get_option('local_pickup_label'),
                    'type'   => 'shipping',
                    'target' => 'total',
                    'value'  => get_option('flat_rate_active') == 'Yes' ? '+'.get_option('flat_rate_cost') : '+'.get_option('local_pickup_cost'),
                    'order' => 1
                ));
                Cart::condition($shipping); 
            }
        }

        if($cartTotal > 0){
            $seo_title = _lang('Checkout').' - '.get_option('site_title');
            return view("theme.$this->theme.checkout", compact('seo_title'));
        }

        return redirect('/shop');
        
    }

    public function send_message(Request $request)
    {
       @ini_set('max_execution_time', 0);
       @set_time_limit(0);
       Overrider::load("Settings");
        
       $this->validate($request, [
            'name' => 'required',
            'email' => 'required|email',
            'phone' => 'required',
            'subject' => 'required',
            'message' => 'required',
       ]);
       
        //Send Email
        $name = $request->input("name");
        $email = $request->input("email");
        $phone = $request->input("phone");
        $subject = $request->input("subject");
        $message = $request->input("message");

        $mail  = new \stdClass();
        $mail->name = $name;
        $mail->email = $email;
        $mail->phone = $phone;
        $mail->subject = $subject;
        $mail->message = $message;

        
        if(get_option('email') != ''){
            try{
                Mail::to( get_option('email') )->send(new ContactUs($mail));      
                return back()->with('success',_lang('Your Message send sucessfully.'));
            }catch (\Exception $e) {
                return back()->with('error',_lang('Error Occured, Please try again !'));
            }        
        }

    }

    public function subscribe_newsletter(Request $request){
        @ini_set('max_execution_time', 0);
        @set_time_limit(0);

        $validator = Validator::make($request->all(), [
            'email' => 'required|email',
        ]);

        if ($validator->fails()) {
            if($request->ajax()){ 
                return response()->json(['result'=>'error','message'=>$validator->errors()->all()]);
            }else{
                return back()->withErrors($validator)->withInput();
            }           
        }

        Overrider::load("MailChimpSettings");
        $news_letter = Newsletter::subscribe($request->email);

        if($news_letter != FALSE){
            return back()->with('success',_lang('Thank you for subscription'));
        }

        return back()->with('error',_lang('Sorry, You may already subscribed !'));

    }

    /** End Page **/

    public function get_states($country_id){
        if($country_id != ""){
            $states = get_states($country_id);
            echo json_encode($states);
        }  
    }

    private function filter($products){

        $search = isset(request()->search) ? request()->search : '';
        $category = isset(request()->category) ? request()->category : '';
        $length = isset(request()->length) ? request()->length : 9;
        $sort_by = isset(request()->sort_by) ? request()->sort_by : '';
        $start_price = isset(request()->start_price) ? request()->start_price : 0;
        $end_price = isset(request()->end_price) ? request()->end_price : get_max_price();
		
		if(! $products->first()){
			return $products->paginate($length)->withQueryString();
		}

        $filter_products = $products->when($sort_by, function ($query, $sort_by) {
                                        if($sort_by == 'oldest'){
                                            return $query->orderBy('id', 'asc');
                                        }else if($sort_by == 'newest'){
                                            return $query->orderBy('id', 'desc');
                                        }else if($sort_by == 'low_to_high'){
                                            return $query->orderBy(DB::raw("IF(special_price != null, special_price, price)"), "asc");
                                        }else if($sort_by == 'high_to_low'){
                                            return $query->orderBy(DB::raw("IF(special_price != null, special_price, price)"), "desc");
                                        }else if($sort_by == 'a_to_z'){
                                            return $query->join('product_translations','products.id','product_translations.product_id')
                                                        ->orderBy('name', 'asc');
                                        }else if($sort_by == 'a_to_z'){
                                           return $query->join('product_translations','products.id','product_translations.product_id')
                                                        ->orderBy('name', 'desc');
                                        }    
                                    })
                                    ->when($search, function ($query, $search) {
                                        if($search != ''){
                                            return $query->join('product_translations','products.id','product_translations.product_id')
                                                        ->where('name', 'like',"$search%");
                                        }
                                        
                                    })
                                    ->whereRaw("IF(special_price != null, special_price, price) between $start_price AND $end_price")
                                    ->paginate($length)
                                    ->withQueryString(); 

        return $filter_products;           
    }

    public function search_products(Request $request){   
        $search = $request->get('term');
        $category = $request->get('category');

        if($search != ''){
            if($category == '' || $category == 'all' ){
                $result = Product::join('product_translations','products.id','product_translations.product_id')
                                 ->where("name", "like", "$search%")
                                 ->get();
            }else{
                $result = Product::join('product_translations','products.id','product_translations.product_id')
                                 ->whereHas('categories', function (Builder $query) use($category) {
                                    $query->where('slug', $category);
                                 })
                                 ->where("name", "like", "$search%")
                                 ->get();
            }

            return response()->json($result);  
        }     
    }


}
