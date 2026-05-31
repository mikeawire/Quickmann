<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Ad;
use Auth;
use File;
use DB;
use Carbon\Carbon;

class AdsController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
      

       
       
    }
    
    
    public function index()
    {
        
          if(Auth::user()->staffprofile->role =='CMO' ||  Auth::user()->staffprofile->role =='MD')
        {
      

         
        $ads = Ad::orderBy('created_at', 'DESC')
                   ->paginate(30);

        return view('Staff.ads.index')->with(compact('ads'));
        }
        else
        {      return redirect('/home');
        }
     
    }
    
     public function create()
    {
        
          if(Auth::user()->staffprofile->role =='CMO' ||  Auth::user()->staffprofile->role =='MD')
        {
      
   
      return view('Staff.ads.create');
        }
        else
        {      return redirect('/home');
        }
    }
    
     public function edit($id)
    {
        
          if(Auth::user()->staffprofile->role =='CMO' ||  Auth::user()->staffprofile->role =='MD')
        {
      
      $ad = Ad::findOrFail($id);
      return view('Staff.ads.edit')->with(compact('ad'));
        }
        else
        {      return redirect('/home');
        }
    }
    
    
     public function store(Request $request)
    {
        $request->validate([
            'image' => 'required|image|mimes:jpeg,png,jpg,gif,svg,png, webp|max:2048',
            'status' => 'required',
            
   
       ]);
       
         
       $image = time().'.'.$request->image->getClientOriginalExtension();
   
       $request->image->move(public_path('/ads'), $image);
       $image_link = "/ads/".$image;
       Ad::create([
           'image'=>$image_link,
           'url'=>$request->url ?? null,
            'status'=>$request->status,
           ]);
       
      
  
       return back()->with('success_msg','Ad Created Successful');
    }
    
    
     
     public function update(Request $request, $id)
    {
        $request->validate([
            'status' => 'required',
            
   
       ]);
       
         
      $ad = Ad::findOrFail($id);
         $ad->update([
           'status'=>$request->status,
           'url'=>$request->url
           ]);
       
      
  
       return back()->with('success_msg','Ad Updated Successful');
    }
    
    
     public function destroy($id)
    {
       
       
         
      $ad = Ad::findOrFail($id);
      
 $filePath = public_path($ad->image);

// Check if the file exists before attempting to delete it
if (File::exists($filePath)) {
    File::delete($filePath); // This will delete the file
   
} else {
    
}

         $ad->delete();
       
      
  
       return back()->with('success_msg','Ad Deleted Successful');
    }
}
