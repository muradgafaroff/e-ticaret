<?php

namespace App\Http\Controllers\Frontend;

use App\Models\About;
use App\Models\Product;
use App\Models\Category;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class PageController extends Controller
{
    public function products(Request $request,$slug=null) {


             $category = request()->segment(1) ?? null;

            $sizes = !empty($request->size) ? explode(',',$request->size) : null;

            $colors = !empty($request->color) ? explode(',',$request->color) : null;

            $startprice = $request->min ?? null;

            $endprice = $request->max ?? null;

            $order = $request->order ?? 'id';
            $sort = $request->sort ?? 'desc';

            $parentcategory = null;
            $childcategory = null;
            if(!empty($category) && empty($slug)) {
                  $parentcategory = Category::where('slug',$category)->first();
            }else if (!empty($category) && !empty($slug)){
                 $parentcategory = Category::where('slug',$category)->first();
                 $childcategory = Category::where('slug',$slug)->first();
            }
            
          
            $breadcrumb = [
                'pages' => [

                ],
                'active'=> 'products'
            ];

            if(!empty($parentcategory) && empty($childcategory)) {
                $breadcrumb['active'] = $parentcategory->name;
            }

            if(!empty($childcategory)) {
                $breadcrumb['pages'][] = [
                    'link'=> route($parentcategory->slug.'products'),
                    'name' => $parentcategory->name
                ];

                $breadcrumb['active'] = $childcategory->name;
            }


          $products  = Product::where('status','1')->select(['id','name','slug','size','color','price','category_id','image'])
            ->where(function($q) use($sizes,$colors,$startprice,$endprice) {
               if(!empty($sizes)) {
                    $q->whereIn('size', $sizes);
                }
                if(!empty($colors)) {
                    $q->whereIn('color', $colors);
                }

                if( !empty($endprice)) {
                    $q->whereBetween('price', [$startprice,$endprice]);

                }
                return $q;
            })
            ->with('category:id,name,slug')
            ->whereHas('category', function($q) use ($category,$slug) {
                if(!empty($slug)) {
                    $q->where('slug', $slug);
                }
                return $q;
            })
            ->with('images')
            ->orderBy($order,$sort)->paginate(21);

            if($request->ajax()) {

                $view = view('frontend.ajax.productList',compact('products'))->render();
                return response(['data'=>$view,  'paginate'=>(string) $products->withQueryString()->links('vendor.pagination.custom')]);
            }

            $sizelists =  Product::where('status','1')->groupBy('size')->pluck('size')->toArray();

            $colors =  Product::where('status','1')->groupBy('color')->pluck('color')->toArray();

            $maxprice = Product::max('price');



             $seolists = metaolustur($category);

            $seo = [
                'title' =>  $seolists['title'] ?? '',
                'description' => $seolists['description'] ?? '',
                'keywords' => $seolists['keywords'] ?? '',
                'image' => asset('img/page-bg.jpg')  ?? '',
                'url'=>  $seolists['currenturl']  ?? '',
                'canonical'=> $seolists['trpage']  ?? '',
                'robots' => 'index, follow',
            ];


        return view('frontend.pages.products',compact('seo','breadcrumb','products','maxprice','sizelists','colors'));
    }

    public function discountproduct() {
        $breadcrumb = [
            'pages' => [

            ],
            'active'=> 'Discounted products'
        ];

        return view('frontend.pages.products',compact('breadcrumb'));
    }

    public function productdetail($slug) {
            $product = Product::whereSlug($slug)->where('status','1')->with('images')->firstOrFail();

           $products = Product::where('id','!=',$product->id)
           ->where('category_id',$product->category_id)
           ->where('status','1')
           ->limit(6)
           ->orderBy('id','desc')
           ->with('images')
           ->get();


           $category = Category::where('id',$product->category_id)->first();

            $breadcrumb = [
                'pages' => [

                ],
                'active'=>  $product->name
            ];

            if(!empty($category)) {
                $breadcrumb['pages'][] = [
                    'link'=> route('products'),
                    'name' => $category->name
                ];
            }



             $title =  $product->title ?? $product->name. '-'. $product->category->name. '-'. config('app.name');


            $description = 'Beautiful'.$product->name.' product'.$product->category->name.' category  '.config('app.name'). ' get it now before it runs out.';
            $seodesciption = $product->description ?? $description;


            $seo = [
                'title' =>   $title ?? '',
                'description' =>   $description ?? '',
                'keywords' => $product->keywords ?? '',
                'image' => asset($product->image),
                'url'=>  route('product.detail',$product->slug),
                'canonical'=> route('product.detail',$product->slug),
                'robots' => 'index, follow',
            ];


        return view('frontend.pages.product',compact('seo','breadcrumb','product','products'));
    }

    public function about() {
        $about = About::where('id',1)->first();

        $breadcrumb = [
            'pages' => [

            ],
            'active'=> 'About'
        ];


        $seolists = metaolustur('about');

        $seo = [
            'title' =>  $seolists['title'] ?? '',
            'description' => $seolists['description'] ?? '',
            'keywords' => $seolists['keywords'] ?? '',
            'image' => asset('img/page-bg.jpg'),
            'url'=>  $seolists['currenturl'],
            'canonical'=> $seolists['trpage'],
            'robots' => 'index, follow',
        ];

        return view('frontend.pages.about',compact('breadcrumb','about'));
    }

    public function contact() {
        $breadcrumb = [
            'pages' => [

            ],
            'active'=> 'contact'
        ];

        $seolists = metaolustur('contact');

        $seo = [
            'title' =>  $seolists['title'] ?? '',
            'description' => $seolists['description'] ?? '',
            'keywords' => $seolists['keywords'] ?? '',
            'image' => asset('img/page-bg.jpg'),
            'url'=>  $seolists['currenturl'],
            'canonical'=> $seolists['trpage'],
            'robots' => 'index, follow',
        ];

        return view('frontend.pages.contact',compact('breadcrumb'));
    }
}
