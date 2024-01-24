<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Dawson\Youtube\Facades\Youtube;


use Google_Client;
use Google_Service_YouTube;
use Google_Service_YouTube_VideoSnippet;


class YoutubeVideoUploadTestingController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function upload(Request $request)
    {
        if ($request->isMethod('GET')) {
            return view('youtube-video-upload-testing.upload');
        }
        

        if ($request->isMethod('POST')) {
            try {
                $video = Youtube::upload($request->file('video')->getPathName(), [
                    'title'       => $request->title,
                    'description' => $request->description
                ]);

                return redirect()->route('youtube-video-upload-testings.upload')->withMessage('Video uploaded in youtube successfully. Video ID is #' . $video->getVideoId());

            } catch (\Throwable $th) {
                dd($th->getMessage());
                // return $th->getMessage();
                return redirect()->back()->withErrors($th->getMessage());
            }
        }
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
