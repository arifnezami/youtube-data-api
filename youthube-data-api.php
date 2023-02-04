

<?php
    if (isset($_POST['submit']) )
     {
        $keyword = $_POST['keyword'];
        $keyword_old = $_POST['keyword'];
              $keyword = str_replace(" ", "%20", $keyword);

        if (empty($keyword))
        {
            $response = array(
                  "type" => "error",
                  "message" => "Please enter the keyword."
                );
        } 
        
         if (!empty($keyword))
  {
    $apikey = ''; // add api key here
    

   $googleApiUrl = 'https://www.googleapis.com/youtube/v3/search?part=snippet&q=' . $keyword . '&key=' . $apikey;

    $ch = curl_init();

    curl_setopt($ch, CURLOPT_HEADER, 0);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
    curl_setopt($ch, CURLOPT_URL, $googleApiUrl);
    curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
    curl_setopt($ch, CURLOPT_VERBOSE, 0);
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
    $response = curl_exec($ch);

    curl_close($ch);

    $data = json_decode($response);
    $value = json_decode(json_encode($data), true);
?>

<div class="result-heading"><?php echo  $keyword_old ; ?> Search Results via API</div>
<div class="videos-data-container" id="SearchResultsDiv">

<?php
    for ($i = 0; $i < 5; $i++) {
      $videoId = $value['items'][$i]['id']['videoId'];
      $kind = $value['items'][$i]['id']['kind'];
        $title = $value['items'][$i]['snippet']['title'];
        $description = $value['items'][$i]['snippet']['description'];
        
        
        
       
        
            $googleApiUrl2 = 'https://youtube.googleapis.com/youtube/v3/videos?part=snippet%2CcontentDetails%2Cstatistics&id=' . $videoId . '&key=' . $apikey;
   

    $ch = curl_init();

    curl_setopt($ch, CURLOPT_HEADER, 0);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
    curl_setopt($ch, CURLOPT_URL, $googleApiUrl2);
    curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
    curl_setopt($ch, CURLOPT_VERBOSE, 0);
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
    $response2 = curl_exec($ch);

    curl_close($ch);
    //echo $response2;
    $data2 = json_decode($response2);
    $value2 = json_decode(json_encode($data2), true);
     //   print_r($value2) ;
        //
        ?> 
    
<div class="video-tile">
<div  class="videoDiv">

</div>
<div class="videoInfo">
    <br><br>
<div class="videoTitle"><b>Title: <?php echo $title; ?></b></div><br>
<div class="videoTitle"><b>Kind: <?php echo $kind; ?></b></div><br>
<div class="videoDesc">Description: <?php echo $description; ?></div><br>
<div class="videoDesc">Views: <?php echo $value2['items'][0]['statistics']['viewCount']; ?> | Comments: <?php echo $value2['items'][0]['statistics']['commentCount']; ?> | Likes: <?php echo $value2['items'][0]['statistics']['likeCount']; ?> | Link: <a href="https://youtube.com/watch?v=<?php echo $videoId; ?>">https://youtube.com/watch?v=<?php echo $videoId; ?></a></div>

</div>
</div>
           <?php 
        }
    } 
    }     
?>
<h2>Search Videos by keyword using YouTube Data API V3</h2>
<div class="search-form-container">
    <form id="keywordForm" method="post" action="">
        <div class="input-row">
            Search Keyword : <input class="input-field" type="search"
                id="keyword" name="keyword"
                placeholder="Enter Search Keyword">
        </div>

        <input class="btn-submit" type="submit" name="submit"
            value="Search">
    </form>
</div>

