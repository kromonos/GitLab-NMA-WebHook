<?php
  if( isset($_GET['APIKEY'])  && !empty($_GET['APIKEY']) && strlen($_GET['APIKEY']) == 48 ) {
    $data = json_decode($HTTP_RAW_POST_DATA);
    require dirname(__FILE__).'/inc/ext/nmaApi.class.php';
    $nma = new nmaApi(
      Array(
        'apikey' => $_GET['APIKEY']
      )
    );

    if( $nma->verify() ){
      $lastCommit = end($data->commits);

      $app = 'GitLab';
      $event = 'New commit';
      $text = 'New commit into ' . $data->repository->name . ' from ' . 
              $lastCommit->author->name . ' &lt;' . $lastCommit->author->email . 
              '&gt; <br>Message:<p>' . $lastCommit->message . '</p>';
      $url = $lastCommit->url;
      $nma->notify($app, $event, $text, $url);
    }
  }
?>