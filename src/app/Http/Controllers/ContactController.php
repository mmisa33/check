<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\ContactRequest;
use App\Models\Category;
use App\Models\Contact;

class ContactController extends Controller
{
    // お問い合わせフォーム入力ページ表示
    public function index()
    {
        $categories = Category::all();
        return view('contact', compact('categories'));
    }

    // お問い合わせフォーム確認ページ表示
    public function confirm(ContactRequest $request)
    {
        $contacts = $request->all();
        $category = Category::find($request->category_id);
        return view('confirm', compact('contacts', 'category'));
    }

    // 入力したお問い合わせデータの保存
    public function store(ContactRequest $request)
    {
        // Javaなしでname'back'入れたらリダイレクト先設定できる
        if ($request->has('back')) {
            return redirect('/')->withInput();
        }

        // 電話番号をtellに統一
        $request['tell'] = $request->tel_1 . $request->tel_2 . $request->tel_3;

        Contact::create(
            $request->only([
                'category_id',
                'first_name',
                'last_name',
                'gender',
                'email',
                'tell',
                'address',
                'building',
                'detail'
            ])
        );

        return view('thanks');
    }
}

    // 自分が作成したコード
    // // お問い合わせフォーム入力ページ表示
    // public function index()
    // {
    //     $contacts = Contact::with('category')->get();
    //     $categories = Category::all();

    //     return view('index', compact('contacts', 'categories'));
    // }

    // // お問い合わせフォーム確認ページ表示
    // public function confirm(ContactRequest $request)
    // {
    //     $contact = $request->only(['category_id', 'first_name', 'last_name', 'gender', 'email', 'tel_area', 'tel_number', 'tel_end', 'address', 'building', 'detail']);
    //     $category = Category::find($contact['category_id']);

    //     return view('confirm', compact('contact', 'category'));
    // }

    // // 入力したお問い合わせデータの保存
    // public function store(ContactRequest $request)
    // {
    //     $contact = $request->only(['category_id', 'first_name', 'last_name', 'gender', 'email', 'tel_area', 'tel_number', 'tel_end', 'address', 'building', 'detail']);
    //     Contact::create($contact);

    //     return view('thanks');
    // }