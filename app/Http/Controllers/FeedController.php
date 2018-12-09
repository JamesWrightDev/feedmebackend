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
    $url = 'https://www.wired.com/feed/rss';
    $xml = simplexml_load_file($url,'SimpleXMLElement', LIBXML_NOCDATA);
    $a = array();
      foreach($xml->channel->item as $item)
      {
        array_push($a, $articles = array(
            'title' => (string)$item->title,
            'description' => (string)$item->description,
            'date' => (string)$item->pubDate,
            'url' => (string)$item->link,
        ));
      }


    dd($a);
    
    
     


    //   Create new array for parsed RSS feeds
      $user_feed=array();
    //   Loop through parsed RSS feeds to create associtive array
      foreach($data['items'] as $index=>$items){
        //   Add id, Channel, Title, Description, URL and Date to array.
        array_push($user_feed, $articles = array(
            'id'=>$index,
            'channel' => $data['title'],
            'title'=>$items->get_title(),
            'description'=>$items->get_description(),
            'site_url'=>$items->get_link(),
            'date' => $items->get_local_date()
        ));
      }
    //   Return as JSON with 200 code. 
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
