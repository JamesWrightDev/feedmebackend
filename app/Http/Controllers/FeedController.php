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

    public function index(Request $request)
    {
        $user_feed = Feed::all();
        $user_feed_url = array();
        $user_feed_name = array();
            foreach($user_feed as $feed){
                array_push($user_feed_url, $feed->feed_url);
                array_push($user_feed_name, $feed->feed_name);
            }  


        // Simple Pie
        $results= array();
        $feed = Feeds::make($user_feed_url);
        $data = array(
            'title'     => $feed->get_title(),
            'permalink' => $feed->get_permalink(),
            'items'     => $feed->get_items(),
          );
          foreach($data['items'] as $i){
              array_push($results, $articles = array(
                  
                  'title' => $i->get_title(),
                  'description' => $i->get_description(),
                  'link' => $i->get_link(),
                  'date' => $i->get_date(),

              ));
          }
          return response($results);


        // Access User RSS Feeds
    //   $user_feed = Feed::all();
    //   $user_feed_url = array();
    //   $user_feed_name = array();
    //   foreach($user_feed as $feed){
    //       array_push($user_feed_url, $feed->feed_url);
    //       array_push($user_feed_name, $feed->feed_name);
    //   }  
      
    // //   RSS Parser
    // $url = $user_feed_url;
    // $a = array();
    // foreach($user_feed_url as $url)
    //     {
    //         $xml = simplexml_load_file($url,'SimpleXMLElement', LIBXML_NOCDATA);
    //         foreach($xml->channel->item as $item)
    //             {
    //                 array_push($a, $articles = array(
    //                     'outlet'=> (string)$xml->channel->title,
    //                     'title' => (string)$item->title,
    //                     'description' => (string)$item->description,
    //                     'date' => (string)$item->pubDate,
    //                     'link' => (string)$item->link,
    //                     ));
    //             }
    //     }
      

    //     $response = array();
    //     array_push($response, $data = array('articles'=> $a,'feeds' => $user_feed_name ));
    // //   Return as JSON with 200 code. 
      
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
        // Fetch URL
            $feed_url = $request->feed_url;
            $feed_name = $request->feed_name;
            
            $cSession = curl_init(); 
            
            curl_setopt($cSession,CURLOPT_URL,$feed_url);
            curl_setopt($cSession,CURLOPT_RETURNTRANSFER,true);
            curl_setopt($cSession,CURLOPT_HEADER, false); 
            $result = curl_exec($cSession);
            
                // Check URL is valid
                if (curl_error($cSession)) {
                    $error_msg = curl_error($cSession);
                    abort($error_msg);
                }
                // Check file recieved is XML. 
                if(substr($result, 0, 5) !== "<?xml") {
                    abort(403,'Not valid RSS'); 
                } 
            $xml = simplexml_load_file($feed_url,'SimpleXMLElement', LIBXML_NOCDATA);
            
            curl_close($cSession);
                $feed = new Feed;
                $feed->feed_name = $xml->channel->title;
                $feed->feed_url = $feed_url;
                $feed->save();
            return('Feed added');


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
