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

    public function master()
    {
        $items = Item::orderBy('updated_at', 'DESC')->paginate(10);

        return view('item.master', compact('items'));
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
                'image' => 'nullable|image|max:64',
                'price' => 'required|numeric|min:1',
            ], [
                'name.required' => '商品名を入力してください。',
                'type.required' => '商品種別を選択してください。',
                'detail.required' => '商品詳細を入力してください。',
                'price.required' => '価格を入力してください。',
                'price.numeric' => '価格は数字で入力してください。',
                'price.min' => '価格は1以上で入力してください。',
                'image.image' => '画像ファイルを選択してください。',
                'image.max' => '画像ファイルのサイズは64KB以下である必要があります。',
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
            return redirect()->route('master');
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
            'image' => 'nullable|image|max:64',
            'price' => 'required|numeric|min:1',
        ], [
            'name.required' => '商品名を入力してください。',
            'type.required' => '商品種別を選択してください。',
            'detail.required' => '商品詳細を入力してください。',
            'price.required' => '価格を入力してください。',
            'price.numeric' => '価格は数字で入力してください。',
            'price.min' => '価格は1以上で入力してください。',
            'image.image' => '画像ファイルを選択してください。',
            'image.max' => '画像ファイルのサイズは64KB以下である必要があります。',
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
        return redirect()->route('master');
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
        return redirect()->route('master');
    }
}
