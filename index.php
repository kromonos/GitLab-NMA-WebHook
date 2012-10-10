<?php
  
  if( isset($_GET['APIKEY'])  && !empty($_GET['APIKEY']) && strlen($_GET['APIKEY']) == 48 ) {
    $data = json_decode($HTTP_RAW_POST_DATA);
    file_put_contents('tmp.txt', print_r($data, true));
    
    require dirname(__FILE__).'/inc/ext/nmaApi.class.php';
    $nma = new nmaApi(
      Array(
        'apikey' => $_GET['APIKEY']
      )
    );

    if($nma->verify()){
      if($nma->notify('GitLab', 'New commit', 'New commit into ' . $data->repository->name . ' from ' . $data->user_name, 'http://' . $data->repository->url)){
          echo "Notifcation sent!";
      }
    }
  }
?>