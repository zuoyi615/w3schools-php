<?php

namespace App\Controllers;

use App\Attributes\Get;

class CurlController
{

    #[Get('/curl')]
    public function index(): void
    {
        $handle = curl_init();

        $url = 'https://www.bilibili.com/';
        curl_setopt($handle, CURLOPT_URL, $url);
        curl_setopt($handle, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($handle, CURLOPT_SSL_VERIFYPEER, false); // for https
        curl_setopt($handle, CURLOPT_SSL_VERIFYHOST, false); // for https

        $content = curl_exec($handle);

        if ($error = curl_error($handle)) {
            echo "Error happened: curl get `{$url}`, $error ";

            return;
        }

        echo '<pre>';
        print_r(curl_getinfo($handle));
        echo '</pre>';
        // echo $content;
    }

}
