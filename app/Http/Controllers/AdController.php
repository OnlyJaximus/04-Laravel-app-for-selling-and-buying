<?php

namespace App\Http\Controllers;

use App\Models\Ad;
use App\Models\Category;
use App\Models\Message;
use Illuminate\Http\Request;

class AdController extends Controller
{


    public function index()
    {
        $all_ads = new Ad;

        if (isset(request()->cat)) {
            $all_ads = Ad::whereHas('category', function ($query) {
                $query->whereName(request()->cat);
            });
        }

        if (isset(request()->type)) {
            $type = (request()->type == 'lower') ? 'asc' : 'desc';
            $all_ads = $all_ads->orderBy('price', $type);
        }

        $all_ads = $all_ads->get();
        $categories = Category::all();
        return view('welcome', compact('all_ads', 'categories'));
    }


    // 2 nacin
    /*
    public function index()
    {
        if (isset(request()->cat)) {
            //     $cat = Category::where('name', request()->cat)->first();
            //     $all_ads = Ad::with('category')->where('category_id', $cat->id)->get();
            //     //  dd($all_ads);
            // }

            // *******  2 nacin selektovanja  ********

            $all_ads = Ad::whereHas('category', function ($query) {
                // $query->where('name', request()->cat);
                $query->whereName(request()->cat);
            })->get();
        } else {
            $all_ads = Ad::all();
        }


        $categories = Category::all();
        return view('welcome', compact('all_ads', 'categories'));
    }

    */

    public function show($id)
    {
        $single_ad = Ad::find($id);

        if (auth()->check() &&  auth()->user()->id !=  $single_ad->user_id) {
            $single_ad->increment('views');
        }




        return view('singleAd', compact('single_ad'));
    }


    public function sendMessage(Request $request, $id)
    {
        $ad = Ad::find($id);  // koji oglas je u pitanju
        // dd($ad);

        $ad_owner = $ad->user;  // dobijamo vlasnika oglasa pomocu metode user koju sam napravio u modelu
        //   dd($ad_owner);

        // nova poruka
        $new_msg = new Message();
        $new_msg->text = $request->msg;
        $new_msg->sender_id = auth()->user()->id;  // sender logovan user
        $new_msg->receiver_id = $ad_owner->id; // ovo je user koji dobija poruku tj vlasnik oglasa
        $new_msg->ad_id = $ad->id;
        $new_msg->save();

        // 2 nacin
        // Messsage::create([
        //     'text' => $request->msg,
        //     'sender_id' => auth()->user()->id,
        //     // itd itd medjutim za ovaj nacin treba da popunimo fillable
        // ]);

        return redirect()->back()->with('message', 'Message sent');
    }
}
