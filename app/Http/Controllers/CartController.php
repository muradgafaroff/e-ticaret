<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\Coupon;
use App\Models\Invoice;
use App\Models\Product;
use Illuminate\Http\Request;

class CartController extends Controller
{
    public function index() {

        $cartItem = $this->cartlist();



        $seolists = metaolustur('cart');

        $seo = [
            'title' =>  $seolists['title'] ?? '',
            'description' => $seolists['description'] ?? '',
            'keywords' => $seolists['keywords'] ?? '',
            'image' => asset('img/page-bg.jpg'),
            'url'=>  $seolists['currenturl'],
            'canonical'=> $seolists['trpage'],
            'robots' => 'noindex, follow',
        ];


        $breadcrumb = [
            'pages' => [

            ],
            'active'=> 'cart'
        ];

        return view('frontend.pages.cart',compact('breadcrumb','seo','cartItem'));
    }

    public function cartList() {
        $cartItem = session()->get('cart') ?? [];
        $totalPrice = 0;
        foreach ($cartItem as $cart) {
            $kdvOrani = $cart['kdv'] ?? 0;
            $kdvtutar = ($cart['price'] * $cart['qty']) * ($kdvOrani / 100);
            $toplamTutar = $cart['price'] * $cart['qty'] + $kdvtutar;
            $totalPrice +=  $toplamTutar;
        }
        if (session()->get('coupon_code') && $totalPrice != 0) {
            $kupon = Coupon::where('name',session()->get('coupon_code'))->where('status','1')->first();
            $kuponprice = $kupon->price ?? 0;
            $newtotalPrice = $totalPrice - $kuponprice;
        }else {
            $newtotalPrice = $totalPrice;
        }

        session()->put('total_price',$newtotalPrice);

        if(count(session()->get('cart')) == 0) {
            session()->forget('coupon_code');
        }

        return  $cartItem;
    }


    public function cartform() {

        $cartItem = $this->cartList();




        $seolists = metaolustur('cart');

        $seo = [
            'title' =>  $seolists['title'] ?? '',
            'description' => $seolists['description'] ?? '',
            'keywords' => $seolists['keywords'] ?? '',
            'image' => asset('img/page-bg.jpg'),
            'url'=>  $seolists['currenturl'],
            'canonical'=> $seolists['trpage'],
            'robots' => 'noindex, follow',
        ];


        $breadcrumb = [
            'sayfalar' => [

            ],
            'active'=> 'Cart'
        ];

        return view('frontend.pages.cartform',compact('breadcrumb','seo','cartItem'));
    }


    public function add(Request $request) {
            $productID= sifrelecoz($request->product_id);
            $qty= $request->qty ?? 1;
            $size= $request->size;
             $product = Product::find($productID);
            if(!$product) {
                return back()->withError('Product Not Found!');
            }
            $cartItem = session('cart',[]);

            if(!empty($request->coupon_code) && $request->coupon_code == 'products') {
                 $kupon = Coupon::where('name',$request->coupon_code)->where('status','1')->first();

                $kuponprice = $kupon->discount_rate ? 2 : 1;

                session()->put('coupon_code',$request->coupon_code);

            }else {
                $kuponprice = 1;
            }

            if(array_key_exists($productID,$cartItem)){
                $cartItem[$productID]['qty'] += $qty;
            }else{
                $cartItem[$productID]=[
                    'image'=>$product->image,
                    'name'=>$product->name,
                    'price'=> $product->price /  $kuponprice,
                    'qty'=>$qty,
                    'kdv'=>$product->kdv,
                    'size'=>$size,
                ];
            }
            session(['cart'=>$cartItem]);

            if($request->ajax()) {
                return response()->json(['cartCount'=>count(session()->get('cart')), 'message'=>'Product Carte Added!']);
            }

           return back()->withSuccess('Product Carte Added!');
    }

    public function newqty(Request $request) {
        $productID= $request->product_id;
        $qty= $request->qty ?? 1;
        $itemtotal = 0;
         $product = Product::find($productID);
        if(!$product) {
            return response()->json('Product Not Found!');
        }
        $cartItem = session('cart',[]);


        if(array_key_exists($productID,$cartItem)){
            $cartItem[$productID]['qty'] = $qty;
            if($qty == 0 || $qty < 0){
                unset($cartItem[$productID]);
            }


            if(session()->get('coupon_code') && session()->get('coupon_code') == 'tumproduct') {
                $price = $product->price / 2;
            }else {
                $price = $product->price;
            }

             $kdvOraniitem = $product->kdv ?? 0;
             $kdvtutaritem = ( $price * $qty) * ($kdvOraniitem / 100);
            $itemtotal =  $price * $qty + $kdvtutaritem;

        }

        session(['cart'=>$cartItem]);


         $this->cartList();

        if($request->ajax()) {
            return response()->json(['itemTotal'=>$itemtotal, 'totalPrice'=>session()->get('total_price'), 'message'=>'Cart Güncellendi']);
        }
    }


    public function remove(Request $request) {

        $productID= sifrelecoz($request->product_id);
        $cartItem = session('cart',[]);
        if(array_key_exists($productID,$cartItem)) {
            unset($cartItem[$productID]);
        }
        session(['cart'=>$cartItem]);

        if(count(session()->get('cart')) == 0) {
            session()->forget('coupon_code');
        }

        if($request->ajax()) {
            return response()->json(['cartCount'=>count(session()->get('cart')), 'message'=>'Product Removed from Cart!']);
        }

        return back()->withSuccess('Successfully Removed from Cart!');
    }


    public function couponcheck(Request $request) {

             $kupon = Coupon::where('name',$request->coupon_name)->where('status','1')->first();

             if(empty($kupon)) {
                return back()->withError('No Coupon Found!');
             }

             $kuponcode = $kupon->name ?? '';
            session()->put('coupon_code',$kuponcode);

             $kuponprice = $kupon->price ?? 0;
             session()->put('coupon_price',$kuponprice);

             $this->cartList();

             return back()->withSuccess('Coupon Applied!');
    }



    function generateKod() {
        $siparisno = generateOTP(7);
            if ($this->barcodeKodExists($siparisno)) {
                return $this->generateKod();
            }

            return $siparisno;
        }

        function barcodeKodExists($siparisno) {
            return Invoice::where('order_no',$siparisno)->exists();
        }


    public function cartSave(Request $request) {
            $request->validate([
                'name' => 'required|string|min:3',
                'email' => 'required|email',
                'phone' => 'required|string',
                'company_name' => 'nullable|string',
                'address' => 'required|string',
                'country' => 'required|string',
                'city' => 'required|string',
                'district' => 'required|string',
                'zip_code' => 'required|string',
                'note' => 'nullable|string',
            ],[
                'name.required' => __('The name field is required.'),
                'name.string' => __('The name must be a string.'),
                'name.min' => __('The name must be at least 3 characters.'),
                'email.required' => __('The email field is required.'),
                'email.email' => __('Please enter a valid email address.'),
                'phone.required' => __('The phone field is required.'),
                'phone.string' => __('The phone must be a string.'),
                'company_name.string' => __('The company name must be a string.'),
                'address.required' => __('The address field is required.'),
                'address.string' => __('The address must be a string.'),
                'country.required' => __('The country field is required.'),
                'country.string' => __('The country must be a string.'),
                'city.required' => __('The city field is required.'),
                'city.string' => __('The city must be a string.'),
                'district.required' => __('The district field is required.'),
                'district.string' => __('The district must be a string.'),
                'zip_code.required' => __('The zip code field is required.'),
                'zip_code.string' => __('The zip code must be a string.'),
                'note.string' => __('The note must be a string.'),

            ]);

           $invoce = Invoice::create([
                "user_id"=> auth()->user()->id ?? null,
                "order_no"=> $this->generateKod(),
                "country"=> $request->country,
                "name"=> $request->name,
                "company_name"=> $request->company_name ?? null,
                "address"=> $request->address ?? null,
                "city"=> $request->city ?? null,
                "district"=> $request->district ?? null,
                "zip_code"=> $request->zip_code ?? null,
                "email"=> $request->email ?? null,
                "phone"=> $request->phone ?? null,
                "note"=> $request->note ?? null,
            ]);


            $cart = session()->get('cart') ?? [];
            foreach ( $cart as $key => $item) {
                Order::create([
                    'order_no'=> $invoce->order_no,
                    'product_id'=>$key,
                    'name'=>$item['name'],
                    'price'=>$item['price'],
                    'qty'=>$item['qty'],
                    'kdv'=>$item['kdv']
                ]);
            }

            session()->forget('cart');
            return redirect()->route('home')->withSuccess('Shopping Completed Successfully.');

    }

}
