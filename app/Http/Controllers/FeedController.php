<?php

namespace App\Http\Controllers;

use App\Feed;
use Feeds;
use Illuminate\Http\Request;

class FeedController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
      $u_feed = Feed::first();
      $u_feed_url = $u_feed->feed_url;
      $feed = Feeds::make($u_feed_url);
      $data = array(
        'title'     => $feed->get_title(),
        'permalink' => $feed->get_permalink(),
        'items'     => $feed->get_items(),
      );
      $user_feed=array('user_feed');
      foreach($data['items'] as $index=>$items){
          
        array_push($user_feed, $articles = array(
            'id'=>$index,
            'channel' => $data['title'],
            'title'=>$items->get_title(),
            'description'=>$items->get_description(),
            'site_url'=>$items->get_link(),
            'date' => $items->get_date()
        ));
      }
      return response($user_feed, 200);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
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
     * @param  \App\Feed  $feed
     * @return \Illuminate\Http\Response
     */
    public function show(Feed $feed)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Feed  $feed
     * @return \Illuminate\Http\Response
     */
    public function edit(Feed $feed)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Feed  $feed
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Feed $feed)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Feed  $feed
     * @return \Illuminate\Http\Response
     */
    public function destroy(Feed $feed)
    {
        //
    }
}
