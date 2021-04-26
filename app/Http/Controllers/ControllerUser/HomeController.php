<?php

namespace App\Http\Controllers\ControllerUser;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {

    }

    /**
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        return view('user.home.index');
    }

    public function tos()
    {
        return view('user.tos');
    }

    /**
     */
    public function contact()
    {
        return view('user.contact');
    }

    /**
     * @return mixed
     */
    public function sitemap()
    {
        $categories = \App\Models\Category::select('alias', 'updated_at')->get();
        $authors     = \App\Models\Author::select('alias', 'updated_at')->get();
        $stories    = \App\Models\Story::select('alias', 'updated_at')->orderBy('created_at', 'DESC')->get();
        $contents = \View::make('user.sitemap')->with(['categories' => $categories , 'authors' =>$authors, 'stories' =>$stories]);
        $response = \Response::make($contents, 200);
        $response->header('Content-Type', 'application/xml');
        return $response;
    }

    public function sendContact(Request $request)
    {
        $data = $request->all();
        \Mail::send('email.contact', $data, function($m) use ($data){
            $m->from($data['email'], $data['name']);
            $m->to(\App\Models\Option::getvalue('email_contact'), 'Admin');
            $m->subject($data['subject'] . ' - From the story website');
        });
        return 'Email Sent, Thank you!';
    }
}
