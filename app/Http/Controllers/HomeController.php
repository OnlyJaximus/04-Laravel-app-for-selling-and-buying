<?php

namespace App\Http\Controllers;

use App\Models\Ad;
use App\Models\Category;
use App\Models\Message;
use App\Models\User;
// use Faker\Core\File;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;
use PDO;
use Symfony\Component\Console\Input\Input;

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
    public function index()
    {
        //$all_ads = Ad::where('user_id', Auth::user()->id)->get();


        $all_ads = Auth::user()->ads;  // ads je metoda ali je zovemo kao properti
        return view('home', ['all_ads' => $all_ads]);
    }

    public function addDeposit()
    {

        return view('home.addDeposit');
    }


    public function updateDeposit(Request $request)
    {
        $user = Auth::user();

        $request->validate(
            [
                'deposit' => 'required|max:4'
            ],
            [
                'deposit.max' => "Can't add more than 9999 rsd at once"
            ]
        );

        $user->deposit = $user->deposit + $request->deposit;
        $user->save();

        return redirect(route('home'));
    }

    public function showAdForm()
    {

        $allCategories = Category::all();

        return view('home.showAdForm', ['categories' => $allCategories]);
    }

    public function saveAd(Request $request)
    {
        $request->validate([
            'title' => 'required|max: 255',
            'body' => 'required',
            'price' => 'required',
            'image1' => 'mimes:jpeg,jpg,png',
            'image2' => 'mimes:jpeg,jpg,png',
            'image3' => 'mimes:jpeg,jpg,png',
            'category' => 'required'

        ]);


        if ($request->hasFile('image1')) {
            $image1 = $request->file('image1');
            $image1_name = time() . '1.' . $image1->extension();
            $image1->move(public_path('ad_images'), $image1_name);
        }

        if ($request->hasFile('image2')) {
            $image2 = $request->file('image2');
            $image2_name = time() . '2.' . $image2->extension();
            $image2->move(public_path('ad_images'), $image2_name);
        }

        if ($request->hasFile('image3')) {
            $image3 = $request->file('image3');
            $image3_name = time() . '3.' . $image3->extension();
            $image3->move(public_path('ad_images'), $image3_name);
        }




        Ad::create([
            'title' => $request->title,
            'body' => $request->body,
            'price' => $request->price,
            'image1' => (isset($image1_name)) ? $image1_name : null,
            'image2' => (isset($image2_name)) ? $image2_name : null,
            'image3' => (isset($image3_name)) ? $image3_name : null,
            'user_id' => Auth::user()->id, // auth()->id()
            'category_id' => $request->category

        ]);

        return redirect(route('home'));
    }

    public function showSingleAd($id)
    {
        $single_ad = Ad::find($id);

        return view('home.singleAd', ['single_ad' => $single_ad]);
    }


    public function showMessage()
    {
        $messages = Message::where('receiver_id', auth()->user()->id)->get();
        //  dd($messages);

        return view('home.messages', compact('messages'));
    }

    public function reply()
    {
        $sender_id = request()->sender_id;
        $ad_id = request()->ad_id;

        $messages = Message::where('sender_id', $sender_id)->where('ad_id', $ad_id)->get();

        return view('home.reply', compact('sender_id', 'ad_id', 'messages'));
    }


    public function replyStore(Request $request)
    {
        $sender = User::find($request->sender_id);
        $ad = Ad::find($request->ad_id);

        //nova porukla
        $new_msg = new Message();
        $new_msg->text = $request->msg;
        $new_msg->sender_id = auth()->user()->id;
        $new_msg->receiver_id = $sender->id;
        $new_msg->ad_id = $ad->id;
        $new_msg->save();

        return redirect()->route('home.showMessage')->with('poruka', 'Replay sent');
    }


    public function msgDelete($id)
    {
        DB::delete('DELETE FROM messages WHERE id=?', [$id]);
        return redirect()->route('home.showMessage')->with('msgDel', 'Message delete success');
    }


    public function edit($id)
    {
        $allCategories = Category::all();
        // $ad = Ad::find($id);
        $single_ad = Ad::find($id);
        return view('home.edit_post', ['categories' => $allCategories, 'single_ad'  => $single_ad]);
    }




    // Radi samo pravi visak slika
    public function update(Request $request, $id)
    {
        $product = Ad::find($id);

        $request->validate([
            'title' => 'required|max: 255',
            'body' => 'required',
            'price' => 'required',
            'image1' => 'mimes:jpeg,jpg,png',
            'image2' => 'mimes:jpeg,jpg,png',
            'image3' => 'mimes:jpeg,jpg,png',
            'category' => 'required'

        ]);



        //  Image 1

        if ($request->hasFile('image1')) {
            $destination = 'ad_images/' . $product->image1;
            if (File::exists($destination)) {
                File::delete($destination);
            }

            $file = $request->file('image1');
            $extension = $file->getClientOriginalExtension();
            $filename = time() . '1.' . $extension;
            $file->move('ad_images/', $filename);
            $product->image1 = $filename;
        }

        //   Image 2

        if ($request->hasFile('image2')) {
            $destination = 'ad_images/' . $product->image2;
            if (File::exists($destination)) {
                File::delete($destination);
            }

            $file = $request->file('image2');
            $extension = $file->getClientOriginalExtension();
            $filename = time() . '2.' . $extension;
            $file->move('ad_images/', $filename);
            $product->image2 = $filename;
        }

        //      Image 3
        if ($request->hasFile('image3')) {
            $destination = 'ad_images/' . $product->image3;
            if (File::exists($destination)) {
                File::delete($destination);
            }

            $file = $request->file('image3');
            $extension = $file->getClientOriginalExtension();
            $filename = time() . '3.' . $extension;
            $file->move('ad_images/', $filename);
            $product->image3 = $filename;
        }


        $product->title = request('title');
        $product->body = request('body');
        $product->price = request('price');
        $product->category_id = request('category');


        $product->update();
        // dd($product->id);
        return redirect('/home/ad/' . $product->id)->with('msgUpd', 'Product update success');
    }






    public function delete($id)
    {
        $ad = Ad::find($id);
        $ad->delete();

        return redirect('home')->with('dlt', 'Delete action success');
    }
}
