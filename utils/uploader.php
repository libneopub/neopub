<?php
require "utils/token.php";
require "config.php";

function uploadFileToGitHub($file_path, $file_name) {
    global $token, $github_user;

    $sha = sha1_file($file_path);
    $file_content = file_get_contents($file_path);
    $file_ext = pathinfo($file_path, PATHINFO_EXTENSION);
    $file_name = "$file_name.$file_ext";

    $data = array(
        "sha" => $sha,
        "message" => "Upload image",
        "content" => base64_encode($file_content),
        "committer" => array(
            "name" => $github_user,
            "email" => "60298132+RobinBoers@users.noreply.github.com"
        )
    );
    
    $data_json = json_encode($data);
    $curl = curl_init("https://api.github.com/repos/$github_user/images/contents/uploads/$file_name");
    
    curl_setopt($curl, CURLOPT_CUSTOMREQUEST, "PUT");
    curl_setopt($curl, CURLOPT_POSTFIELDS, $data_json);
    curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($curl, CURLOPT_HTTPHEADER, array(
        "Content-Type: application/json",
        "User-Agent: Mozilla/5.0 (Windows NT 6.1; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/76.0.3809.132 YaBrowser/19.9.3.314 Yowser/2.5 Safari/537.36",
        "Authorization: token $token"
    ));
    
    $response = curl_exec($curl);
    echo $response;

    $data = json_decode($response);
    return $data->content->download_url;
}
?>