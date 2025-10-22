<?php
require 'vendor/autoload.php';
use Firebase\JWT\JWT;


function getCurrentDate()
{
  $CM = new CI_Model();
  date_default_timezone_set('Asia/Jakarta');
  $now = date('Y-m-d H:i:s');

  return $now;
}

function checkSpace($id) {

  $CI = &get_instance();
  $CI->load->model('Space_model');

  $nama = "";

  if($id == "space") {
    $idpsace = $CI->session->userdata('workspace_sesi');
    $space   = $CI->Space_model->cekFolderSpace($idpsace);

    $nama = $space['folder_space'];
  } else {
    $document   = $CI->Space_model->cekSpaceDoc($id);
    if(!empty($document)) {
      $idspace = $document['id_space'];
  
      $space   = $CI->Space_model->cekFolderSpace($idspace);
  
      $nama = $space['folder_space'];
    }
  }
 
     
  return $nama;
}

function checkSpaceById($id) {

    $CI = &get_instance();
    $CI->load->model('Space_model');
  
    $nama = "";

    $space   = $CI->Space_model->cekFolderSpace($id);
    
    $nama = $space['folder_space'];

    return $nama;
  }

function checkProject($id,$type) {

    $CI = &get_instance();
    $CI->load->model('Space_model');
    $CI->load->model('Project_model');
  
    if($type == 'key') {
           
        $kr = $CI->Project_model->checkKr($id);

        $nama       =  $kr['nama_kr'];
        $progress   =  $kr['precentage'];

        $idokr =  $kr['id_okr'];

        $cekmyokr = $CI->Project_model->checkOkr($idokr);

        $pj =  $cekmyokr['id_project'];
      } else {
        $ini = $CI->Project_model->checkDataIni($id);
        if(!empty($ini)) {
            $idkr = $ini['id_kr'];

            $nama =  $ini['description'];
    
            $progress   =  $ini['value_percent'];
    
            $kr         = $CI->Project_model->checkKr($idkr);
    
            $idokr      =  $kr['id_okr'];
    
            $cekmyokr   = $CI->Project_model->checkOkr($idokr);
    
            $pj =  $cekmyokr['id_project'];

        } else {
            $pj = 'null';
            $nama = 'null';
            $idokr = 'null';
            $progress = 'null';
        }
      }
     
   return [
        'idokr' => $pj,
        'namaokr' => $nama,
        'idobjective' => $idokr,
        'progressokr' => $progress
    ];
  }

  function checkKeyResult($id) {

    $CI = &get_instance();
    $CI->load->model('Space_model');
    $CI->load->model('Project_model');

    $ini = $CI->Project_model->checkDataIni($id);
    $idkr = $ini['id_kr'];

    $kr = $CI->Project_model->checkKr($idkr);

    $idokr =  $kr['id_okr'];

    return $idokr;
  }


function checkMyAksesOKR($id) {

  $CI = &get_instance();
  $CI->load->model('Space_model');
  $CI->load->model('Team_model');

  $iduser = $CI->session->userdata('id');

  $okr   = $CI->Team_model->getUserTeamRoleOkr($id,$iduser);
   
  return $okr;
}

function checkMyAksesKey($id) {

    $CI = &get_instance();
    $CI->load->model('Space_model');
    $CI->load->model('Team_model');
  
    $iduser = $CI->session->userdata('id');
  
    $okr   = $CI->Team_model->checkAccObj($id,$iduser);
     
    return $okr;
  }

function getAccessToken() {
  $url = "https://oauth2.googleapis.com/token";
  $serviceAccountPath = FCPATH . "service-notif.json";
  
  $jwt = file_get_contents($serviceAccountPath);
  $jwt_data = json_decode($jwt, true);

  $claims = [
      'iss' => $jwt_data['client_email'],
      'scope' => 'https://www.googleapis.com/auth/firebase.messaging',
      'aud' => 'https://oauth2.googleapis.com/token',
      'exp' => time() + 3600,
      'iat' => time()
  ];

  $jwt = JWT::encode($claims, $jwt_data['private_key'], 'RS256');
  
  $post_fields = [
      'grant_type' => 'urn:ietf:params:oauth:grant-type:jwt-bearer',
      'assertion' => $jwt,
  ];

  $ch = curl_init();
  curl_setopt($ch, CURLOPT_URL, $url);
  curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
  curl_setopt($ch, CURLOPT_POST, true);
  curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($post_fields));
  $response = curl_exec($ch);
  curl_close($ch);
  
  $token_data = json_decode($response, true);
  return $token_data['access_token'];
}

function sendMessage($accessToken, $tokens, $title,$text,$myurl) {
  $url = 'https://fcm.googleapis.com/v1/projects/okre-ethes-tech/messages:send';
  $redirectUrl = $myurl;

 
  // Example message payload
  $fields = array(
      'message' => array(
          'token' => $tokens,
          'notification' => array(
              'title' => $title,
              'body' => $text,
          ),
          'data' => array(
              'story_id' => 'story_12345',
              'click_action' => $redirectUrl,
          ),
          'android' => array(
              'notification' => array(
                  'sound' => 'default',
                  'click_action' => $redirectUrl,
              ),
          ),
          'apns' => array(
              'payload' => array(
                  'aps' => array(
                      'category' => 'NEW_MESSAGE_CATEGORY',
                      'sound' => 'default',
                  ),
              ),
          ),
          'webpush' => array(
              'headers' => array(
                  'TTL' => '86400',
              ),
              'fcm_options' => array(
                  'link' => $redirectUrl, // URL redirect untuk web push notification
              ),
          ),
      ),
  );

  $headers = [
   'Authorization: Bearer ' . $accessToken,
   'Content-Type: application/json',
   ];

   $ch = curl_init();
   curl_setopt($ch, CURLOPT_URL, $url);
   curl_setopt($ch, CURLOPT_POST, true);
   curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
   curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
   curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
   curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
   curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($fields));
   $result = curl_exec($ch);
   $httpcode = curl_getinfo($ch, CURLINFO_HTTP_CODE);

      if ($httpcode != 200) {
          echo 'Error: ' . $result;
      } else {
          echo 'Success: ' . $result;
      }

   if ($result === false) {
       die('Curl failed: ' . curl_error($ch));
   }

   curl_close($ch);
   
   echo $result;  
}

function sendMessageMultiple($accessToken, $id, $title,$text,$myurl) {
    $url = 'https://fcm.googleapis.com/v1/projects/okre-ethes-tech/messages:send';
    $redirectUrl = $myurl;

    $CI = &get_instance();
    $CI->load->model('Space_model');
    $CI->load->model('Team_model');

  
    // Example message payload
    $userDocument =  $CI->Space_model->documentSign($id);

    foreach($userDocument as $sd) {
    $accounttokens =  $CI->Account_model->getAccountById($sd['id_user_doc']);
    $tokens = $accounttokens['token_users'];

        $fields = array(
            'message' => array(
                'token' => $tokens,
                'notification' => array(
                    'title' => $title,
                    'body' => $text,
                ),
                'data' => array(
                    'story_id' => 'story_12345',
                    'click_action' => $redirectUrl,
                ),
                'android' => array(
                    'notification' => array(
                        'sound' => 'default',
                        'click_action' => $redirectUrl,
                    ),
                ),
                'apns' => array(
                    'payload' => array(
                        'aps' => array(
                            'category' => 'NEW_MESSAGE_CATEGORY',
                            'sound' => 'default',
                        ),
                    ),
                ),
                'webpush' => array(
                    'headers' => array(
                        'TTL' => '86400',
                    ),
                    'fcm_options' => array(
                        'link' => $redirectUrl, // URL redirect untuk web push notification
                    ),
                ),
            ),
        );
  
    $headers = [
     'Authorization: Bearer ' . $accessToken,
     'Content-Type: application/json',
     ];
  
     $ch = curl_init();
     curl_setopt($ch, CURLOPT_URL, $url);
     curl_setopt($ch, CURLOPT_POST, true);
     curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
     curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
     curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
     curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
     curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($fields));
     $result = curl_exec($ch);
     $httpcode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
  
        if ($httpcode != 200) {
            echo 'Error: ' . $result;
        } else {
            echo 'Success: ' . $result;
        }
  
     if ($result === false) {
         die('Curl failed: ' . curl_error($ch));
     }
  
     curl_close($ch);

    }
     
     echo $result;  
  }
