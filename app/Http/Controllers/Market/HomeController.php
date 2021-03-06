<?php

namespace App\Http\Controllers\Market;

use App\Http\Controllers\Controller;
use App\Models\Article;
use App\Models\ArticleCategory;
use App\Models\Product;
use App\Models\ProductCategory;
use App\ViewModel\Home\ItemBoxVM;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use phpDocumentor\Reflection\Types\Collection;

class HomeController extends Controller
{
    // Website Index page
    public function Index()
    {
        return view('Market.index');
    }

    public function search(Request $request)
    {

        $key = $request['key'];

        //pagination variable
        $page = request('page');
        $take = request('take');

        //Default page
        if ($page == null)
            $page = 1;

        //default take
        if ($take == null)
            $take = 4;

        #TODO Search box
        if ($request['key'] !== null) {
            switch ($request['category']) {
                case 1:
                    $items = $this->SearchArticle($key, $page, $take);
                    return view('market.Article_Search', ['articles' => $items, 'key' => $key]);
                    break;
                case 2:
                    $items = $this->SearchProduct($key, $page, $take);
                    return view('market.Product_Search', ['products' => $items, 'key' => $key]);
                    break;
                default :
                    dd("Select a Category for search");
                    break;
            }
        }
    }

    public function SearchArticle(string $key, int $page, int $take): array
    {
        //pagination
        $count = Article::query()->where('title', 'LIKE', '%' . $key . '%')->skip(($page - 1) * $take)->take($take)->count();
        $pageCount = $count / $take;
        if ($count % $take !== 0)
            $pageCount++;

        //Run order - pagination Query
        $articles = Article::query()->where('title', 'LIKE', '%' . $key . '%')->skip(($page - 1) * $take)->take($take)->get();

        //return items
        return ['items' => $articles, 'count' => $pageCount];;
    }

    public function SearchProduct(string $key, int $page, int $take): array
    {
        //pagination
        $count = Product::query()->where('title', 'LIKE', '%' . $key . '%')->get()->count();
        $pageCount = $count / $take;
        if ($count % $take !== 0)
            $pageCount++;

        //Run order - pagination Query
        //$products = DB::table('products')->where('title', "Like", '%' . $key . '%')->skip(($page - 1) * $take)->take($take)->join('product_galleries', function ($join) {
        //$join->on('products.galleryId	', '=', 'product_galleries.id');
        //})->get();

        $products = Product::query()->where('title', 'LIKE', '%' . $key . '%')->skip(($page - 1) * $take)->take($take)->get();

        //return items
        return ['items' => $products, 'count' => $pageCount];;
    }

    public function GetProduct(int $id)
    {
        $product = Product::findOrFail($id);
        return view('market.showProduct', ['item' => $product]);
    }

    public function GetArticle(int $id)
    {
        $article = Article::findOrFail($id);
        $article->visit = $article->visit + 1;
        $article->save();
        return view('blog.showArticle', ['item' => $article]);
    }

    public function Purchase(int $id, Request $request)
    {
        return "the " . $request['count'] . ' of product number:' . $id . ' successfully add to your cart.';
    }

    public function GetArticleCatgeory(int $id, int $page, int $take)
    {

        //categoryName
        $categoryName = ArticleCategory::findOrFail($id);

        //Articles
        $articles = Article::query()->where('categoryId', '=', $id)->skip(($page - 1) * $take)->take($take)->get();

        //Article Count
        $count = Article::query()->where('categoryId', '=', $id)->count();

        $pageCount = $count / $take;
        if ($count % $take !== 0)
            $pageCount++;

        //return items
        return view('blog.Category', ['articles' => $articles, 'pageCount' => $pageCount, 'category' => $categoryName, 'page' => $page, 'take' => $take, 'count' => $count]);
    }

    public function GetProductCatgeory(int $id, int $page, int $take)
    {
        //categoryName
        $categoryName = ProductCategory::findOrFail($id);
        //product list
        $products = Product::query()->where('categoryId', '=', $id)->skip(($page - 1) * $take)->take($take)->get();

        //product Count
        //resources/views/Market/Products/Category.blade.php
        $count = Product::query()->where('categoryId', '=', $id)->count();

        $pageCount = $count / $take;
        if ($count % $take !== 0)
            $pageCount++;

        //return items

        return view('Market.Products.Category', ['products' => $products, 'pageCount' => $pageCount, 'category' => $categoryName, 'page' => $page, 'take' => $take, 'count' => $count]);

    }
}
