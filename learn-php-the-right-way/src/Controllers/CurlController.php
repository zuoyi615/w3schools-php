<?php

namespace App\Controllers;

use App\Attributes\Get;

class CurlController
{

    #[Get('/curl')]
    public function index(): void
    {
        $handle = curl_init();

        // $url = 'https://jsonplaceholder.typicode.com/todos';
        $url = 'https://picsum.photos/v2/list?page=2&limit=100';

        curl_setopt($handle, CURLOPT_URL, $url);
        curl_setopt($handle, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($handle, CURLOPT_SSL_VERIFYPEER, false); // for https
        curl_setopt($handle, CURLOPT_SSL_VERIFYHOST, false); // for https

        $content = curl_exec($handle);

        if ($error = curl_error($handle)) {
            echo "Error happened: curl get `{$url}`, $error ";

            return;
        }

        if ($content === false) {
            echo "curl $url failed.";

            return;
        }

        $data = json_decode($content, true);

        echo '<pre>';
        var_dump($data);
        echo '</pre>';
    }

}
