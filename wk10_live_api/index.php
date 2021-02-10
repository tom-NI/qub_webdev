<?php
//response data will be sent as a JSON format
header('Content-Type: application/json');

function getUrl($searchTerm) {
    $endp = "https://en.wikipedia.org/w/api.php?action=query&titles={$searchTerm}&prop=pageimages&pithumbsize=400&formatversion=2&pilicense=any&format=json";
    $jsonres = file_get_contents($endp);
    $img = json_decode($jsonres, true);
    $path = $img["query"]["pages"][0]["thumbnail"]["source"];
    return $path;
}
 
if(!isset($_GET['2018'])){
    echo "no data";
}else{
  if( ($_SERVER['PHP_AUTH_USER'] == "ringo" ) && ( $_SERVER['PHP_AUTH_PW'] == "lockdown" )) {
        // echo "Valid username and password.";
        $find = $_GET['2018'];
    } else {
        header("WWW-Authenticate: Basic realm='Admin Dashboard'");
        header("HTTP/1.0 401 Unauthorized");
        echo "You need to enter a valid username and password.";
        exit;
    }

    $find = $_GET['2018'];
}
    // echo "build JSON response";
    // build a two dimesional array
    if($find == "imgs"){
     
      $urlPath = getUrl("Get_Out");
      $movie1 = array("movie"=>"Get Out","URL"=>"https://en.wikipedia.org/wiki/Get_Out", "imgurl"=>$urlPath);

      $urlPath = getUrl("Call_Me_by_Your_Name_(film)");
      $movie2 = array("movie"=>"Call me by your name","URL"=>"https://en.wikipedia.org/wiki/Call_Me_by_Your_Name_(film)","imgurl"=>$urlPath);

      $urlPath = getUrl("Phantom_Thread");
      $movie3 = array("movie"=>"Phantom Thread","URL"=>"https://en.wikipedia.org/wiki/Phantom_Thread","imgurl"=>$urlPath);
 
    //create the parent array
    $dataset=array();
 
    //add each row of data to the parent array
    $dataset[]=$movie1;
    $dataset[]=$movie2;
    $dataset[]=$movie3;
 
    //convert the PHP 2 dimesional array to JSON
    echo json_encode($dataset);
}
if($find == "noimgs"){
    $movie1 = array("movie"=>"Get Out","URL"=>"https://en.wikipedia.org/wiki/Get_Out");
    $movie2 = array("movie"=>"Call me by your name","URL"=>"https://en.wikipedia.org/wiki/Call_Me_by_Your_Name_(film)");
    $movie3 = array("movie"=>"Phantom Thread","URL"=>"https://en.wikipedia.org/wiki/Phantom_Thread");
 
  //create the parent array
  $dataset=array();
 
  //add each row of data to the parent array
  $dataset[]=$movie1;
  $dataset[]=$movie2;
  $dataset[]=$movie3;
 
  //convert the PHP 2 dimesional array to JSON
  echo json_encode($dataset);
 
}
 
?>
