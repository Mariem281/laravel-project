<?php

namespace App\Http\Controllers\Home;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\About;
use Image;

class AboutController extends Controller
{
    

    public function AboutPage(){
        $aboutpage = About::find(1);
        return view('admin.about_page.about_page_all',compact('aboutpage'));
    }


    public function UpdateAbout(Request $request){
        $about_id = $request->id;
        if ($request->file('about_img')){
                $image =$request->file('about_img');
                $name_gen = hexdec(uniqid()).'.'.$image->getClientOriginalExtension();

                Image::make($image)->resize(523,605)->save('upload/about/'.$name_gen);
                $save_url = 'upload/about/'.$name_gen;

                About::findOrFail($about_id)->update([
                        'title' => $request->title,
                        'short_title' => $request->short_title,
                        'short_description' => $request->short_description,
                        'long_description' => $request->long_description,
                        'about_img' => $save_url,
                ]);

                $notification = array(
                    'message' => 'About Page Updated with Image Successfully',
                    'alert type' => 'success'
                );
                return redirect()->back()->with($notification);
        } else{
            About::findOrFail($about_id)->update([
                'title' => $request->title,
                'short_title' => $request->short_title,
                'short_description' => $request->short_description,
                'long_description' => $request->long_description,
                
        ]);

        $notification = array(
            'message' => 'About Page Updated without Image Successfully',
            'alert type' => 'success'
        );
        return redirect()->back()->with($notification);
        }
    }



    public function HomeAbout(){
        
        $aboutpage = About::find(1);
       
        return view('frontend.about_page',compact('aboutpage'));

    }
}


