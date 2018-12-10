<?php

namespace App\Http\Controllers;

use App\Feed;
use Feeds;
Use SimplePie;
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
        
        // Access User RSS Feeds
      $user_feed = Feed::all();
      $user_feed_url = array();
      foreach($user_feed as $feed){
          array_push($user_feed_url, $feed->feed_url);
      }  
      
    //   RSS Parser
    $url = $user_feed_url;
    $a = array();
    foreach($user_feed_url as $url)
        {
            $xml = simplexml_load_file($url,'SimpleXMLElement', LIBXML_NOCDATA);
            foreach($xml->channel->item as $item)
                {
                    array_push($a, $articles = array(
                        'outlet'=> (string)$xml->channel->title,
                        'title' => (string)$item->title,
                        'description' => (string)$item->description,
                        'date' => (string)$item->pubDate,
                        'link' => (string)$item->link,
                        ));
                }
        }
      


    
    //   Return as JSON with 200 code. 
      return response($a, 200);
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
        return($request->all());
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
