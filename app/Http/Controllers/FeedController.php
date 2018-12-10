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
      $user_feed_name = array();
      foreach($user_feed as $feed){
          array_push($user_feed_url, $feed->feed_url);
          array_push($user_feed_name, $feed->feed_name);
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
      

        $response = array();
        array_push($response, $data = array('articles'=>$a,'feeds' => $user_feed_name ));
    //   Return as JSON with 200 code. 
      return response($response, 200);
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
        // Veryify url
        function verify_xml($url){
            libxml_clear_errors();
            libxml_use_internal_errors(true);
            $xml = simplexml_load_file($url, 'SimpleXMLElement', LIBXML_NOCDATA );
            if ($xml === false) {
                dd('NOPE');
                exit;                
                } 
            }
                // $xml = simplexml_load_file($url, 'SimpleXMLElement', LIBXML_NOCDATA);
                // if ($xml === false) {
                //     throw new Exception("Cannot load xml source.\n");
                //   }
                // $a = array();
                // foreach($xml->channel->item as $item)
                //     {
                //         array_push($a, $articles = array(
                //             'outlet'=> (string)$xml->channel->title,
                //             'title' => (string)$item->title,
                //             'description' => (string)$item->description,
                //             'date' => (string)$item->pubDate,
                //             'link' => (string)$item->link,
                //             ));
                        
                //     }
            // }
            
            verify_xml('https://ww.wired.com/feed/rss');
            
            // try {
            //     $var = $request['feed_url'];
            //     verify_xml('https://www.wired.com/feed/rss');
            // } catch (Exception $e) {
            //     echo 'Caught exception: ',  $e->getMessage(), "\n";
            // }

            
            
            
            

        // Create new feed entry in DB. 

        // $feed = new Feed;
        // $feed->feed_name = $request['name'];
        // $feed->feed_url = $request['feed_url'];
        // $feed->save();
        
        return('hello');


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
