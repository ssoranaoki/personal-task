<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Item;
use App\Models\User;

class ItemController extends Controller
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
     * 管理者画面
     */

    public function master(Request $request)
    {
        // 検索キーワードとカテゴリを取得
        $keyword = $request->input('keyword');
        $category = $request->input('category');

        // クエリ作成
        $query = Item::query();
        $query->orderBy('updated_at', 'DESC');

        // 商品一覧取得
        $items = $query->paginate(10)->appends(['keyword' => $keyword, 'category' => $category]);

        return view('item.master', compact('items', 'keyword', 'category'));
    }

    /**
     * 絞り込み検索
     */

    public function ItemSearch(Request $request)
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
        return view('item.master', compact('items', 'keyword', 'category'));
    }

    /**
     * 商品登録画面
     */
    public function ItemCreate()
    {
        return view('item.add');
    }

    /**
     * 商品登録
     */
    public function ItemRegister(Request $request)
    {
            // バリデーション
            $this->validate($request, [
                'name' => 'required|max:100',
                'type' => 'required',
                'detail' => 'required|max:500',
                'image' => 'nullable|image|max:47',
                'price' => 'required|numeric|min:1',
            ], [
                'name.required' => '商品名を入力してください。',
                'type.required' => '商品種別を選択してください。',
                'detail.required' => '商品詳細を入力してください。',
                'price.required' => '価格を入力してください。',
                'price.numeric' => '価格は数字で入力してください。',
                'price.min' => '価格は1以上で入力してください。',
                'image.image' => '画像ファイルを選択してください。',
                'image.max' => '画像ファイルのサイズは47KB以下である必要があります。',
            ]);

            // 画面で入力されたデータを受け取る
            $data = $request->all();
            // dd($data);
            // 画像がアップロードされていれば、画像ファイルをBase64エンコードする
            if ($request->hasFile('image')) {
                $image = $request->file('image');
                // 画像ファイルをBase64エンコードする
                $base64_image = base64_encode(file_get_contents($image));
            } else {
                // 画像がアップロードされていない場合、nullが代入される
                $base64_image = null;
            }


            // ItemモデルにDBへ保存する命令を書く
            $item_id = Item::create([
                'name' => $data['name'],
                'type' => $data['type'],
                'detail' => $data['detail'],
                'price' => $data['price'],
                'image' => $base64_image, // Base64エンコードされた画像を保存
            ]);

            // 管理者画面に遷移
            return redirect()->route('master')->with('RegisterMessage', '商品登録しました');
    }

    /**
     * 商品編集
     */

    // 商品更新画面に遷移
    public function edit($id)
    {
        // urlのidとitemテーブルのidが一緒の物を1行形式で持ってくる
        $item = Item::where('id', $id)->first();

        return view('item.edit', compact('item'));
    }


    public function update(Request $request, $id)
    {
        // バリデーション
        $this->validate($request, [
            'name' => 'required|max:100',
            'type' => 'required',
            'detail' => 'required|max:500',
            'image' => 'nullable|image|max:47',
            'price' => 'required|numeric|min:1',
        ], [
            'name.required' => '商品名を入力してください。',
            'type.required' => '商品種別を選択してください。',
            'detail.required' => '商品詳細を入力してください。',
            'price.required' => '価格を入力してください。',
            'price.numeric' => '価格は数字で入力してください。',
            'price.min' => '価格は1以上で入力してください。',
            'image.image' => '画像ファイルを選択してください。',
            'image.max' => '画像ファイルのサイズは47KB以下である必要があります。',
        ]);

        $data = $request->all();

        // 画像がアップロードされていれば、画像ファイルをBase64エンコードする
        if ($request->hasFile('image')) {
            $image = $request->file('image');
            // 画像ファイルをBase64エンコードする
            $base64_image = base64_encode(file_get_contents($image));
            $data['image'] = $base64_image;
        } else {
            // 画像がアップロードされていない場合、既存の画像を使用する
            $item = Item::where('id', $id)->first();
            $data['image'] = $item->image;
        }

        // update関数を使いDBへ保存する命令を書く
        Item::where('id', $id)->update([
            'name' => $data['name'],
            'type' => $data['type'],
            'detail' => $data['detail'],
            'price' => $data['price'],
            'image' => $data['image'],
        ]);

        // 管理者画面に遷移
        return redirect()->route('master')->with('UpdateMessage', '商品更新しました');
    }

    /**
     * 削除機能
     */

    public function delete(Request $request, $id)
    {
        // urlのidとitemテーブルのidが一緒の物を1行形式で持ってくる
        $item = Item::where('id', $id)->first();
        // 物理削除
        $item->delete();

        // 管理者画面に遷移
        return redirect()->route('master')->with('DeleteMessage', '商品削除しました');
    }
}
