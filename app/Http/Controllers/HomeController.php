<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Item;
use App\Models\User;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */

    // ホーム画面
    public function index()
    {
        return view('home');
    }

    /**
     * 商品一覧画面
     */
    public function list(Request $request)
    {
        // 検索キーワードとカテゴリを取得
        $keyword = $request->input('keyword');
        $category = $request->input('category');

        // クエリ作成
        $query = Item::query();
        $query->orderBy('updated_at', 'DESC');

        // 商品一覧取得
        $items = $query->paginate(10)->appends(['keyword' => $keyword, 'category' => $category]);


        return view('home.index', compact('items', 'keyword', 'category'));
    }

    /**
     * 商品詳細画面
     */

    public function detail(Request $request)
    {
        //一覧から指定されたIDと同じIDのレコードを取得する
        $item = Item::where('id', '=', $request->id)->first();
        return view('home.detail')->with([
            'item' => $item,
        ]);
    }

    /**
     * 絞り込み検索
     */

    public function search(Request $request)
    {
        //検索フォームに入力された値を取得
        $keyword = $request->input('keyword');
        //セレクトボックスから指定された値を取得
        $category = $request->input('category');
        // dd($category, $keyword);

        // クエリ作成
        $query = Item::query();

        // セレクトボックスだけの値で検索
        if (isset($category) && empty($keyword)) {
            $query->where('type', 'like', $category);
        }

        // キーワードだけの値で検索
        if (isset($keyword) && empty($category)) {
            $query->where('name', 'like', '%' . $keyword . '%')
                ->orWhere('type', 'like', '%' . $keyword . '%')
                ->orWhere('price', 'like', '%' . $keyword . '%');
        }

        // セレクトボックスの値とキーワードの値で検索
        if (isset($keyword) && isset($category)) {
            $query->where('type', $category)
                ->where(function ($query) use ($keyword) {
                    $query->orWhere('name', 'like', '%' . $keyword . '%')
                        ->orWhere('type', 'like', '%' . $keyword . '%')
                        ->orWhere('price', 'like', '%' . $keyword . '%');
                });
        }

        // 実行
        $items = $query->orderBy('updated_at', 'DESC')->paginate(10)->appends(['keyword' => $keyword, 'category' => $category]);

        // ビューへ結果を渡す
        return view('home.index', compact('items', 'keyword', 'category'));
    }
}
