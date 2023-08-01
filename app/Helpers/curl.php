<?php

if (!function_exists('curlPost')) {
    /**
     *  curl post
     *
     * @param string $url API url
     * @param array|string $postData
     * @param $decodeFunction 如果回傳的是加密資料, 需要傳入解密函式
     *
     * @return string
     *
     */
    function curlPost($url, $postData, $decodeFunction = null, $curlSetting = [], $showError = true)
    {
        try {
            $curlService = new CurlLogsService(config('global.platformCode'));
            $curlLogs = $curlService->insert($postData, $url);
        } catch (Exception $e) {
        }

        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'POST');
        curl_setopt($ch, CURLOPT_POSTFIELDS, $postData);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

        if(!empty($curlSetting))
        {
            foreach($curlSetting as $option => $value)
            {
                curl_setopt($ch, $option, $value);
            }
        }

        $result = curl_exec($ch);
        $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        $err = curl_error($ch);

        if (!empty($err)) {
            \Log::alert('curl error: ' . $err);
        }
        curl_close($ch);

        try {
            if (isset($curlService) && isset($curlLogs))
            {
                if (!is_null($decodeFunction))
                {
                    $responseArray = $decodeFunction($result);
                    $updateResponse = [
                        'originResponse' => $result,
                        'decodedResponse' => $responseArray
                    ];
                    $curlService->update($curlLogs, json_encode($updateResponse), $httpCode);
                }
                else {
                    $curlService->update($curlLogs, $result, $httpCode);
                }
            }
        } catch (Exception $e) {
        }

        if ($httpCode != 200 && $showError)
        {
            // CURL POST 失敗
            throw new GnException('8012');
        }
        elseif ($httpCode != 200) 
        {
            return false;
        }

        return $result;
    }
}

if (!function_exists('curlGet')) {
    /**
     *  curl get
     *
     * @param string $url API url
     *
     * @return api response
     */
    function curlGet($url, $showError = true, $curlSetting = [])
    {
        // try {
        //     $curlService = new CurlLogsService(config('global.platformCode'));
        //     $curlLogs = $curlService->insert([], $url);
        // } catch (Exception $e) {
        // }

        $ch = curl_init();

        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

        if(!empty($curlSetting))
        {
            foreach($curlSetting as $option => $value)
            {
                curl_setopt($ch, $option, $value);
            }
        }

        $result = curl_exec($ch);
        $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        $err = curl_error($ch);

        // if (!empty($err)) {
        //     \Log::alert('curl error: ' . $err);
        // }
        curl_close($ch);

        // try {
        //     if (isset($curlService) && isset($curlLogs))
        //     {
        //         $curlService->update($curlLogs, $result, $httpCode);
        //     }
        // } catch (Exception $e) {
        // }

        // if ($httpCode != 200 && $showError)
        // {
        //     // CURL POST 失敗
        //     throw new GnException('8012');
        // }
        // elseif ($httpCode != 200) 
        // {
        //     return false;
        // }

        return $result;
    }
}


if (!function_exists('curlRestful')) {
    /**
     *  curl get
     *
     * @param string $url API url
     *
     * @return api response
     */
    function curlRestful($method, $url, $postData, $curlSetting = [], $showError = true)
    {
        try {
            $curlService = new CurlLogsService(config('global.platformCode'));
            $curlLogs = $curlService->insert($postData, $url);
        } catch (Exception $e) {
        }

        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

        switch (strtoupper($method))
        {
            case "POST" :
                curl_setopt($ch, CURLOPT_POST, true);
                curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'POST');
                if (!empty($postData))
                {
                    curl_setopt ($ch, CURLOPT_POSTFIELDS, $postData);
                }else{
                    curl_setopt ($ch, CURLOPT_POSTFIELDS, '');
                }
                break;
            case "PUT" :
                curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'PUT');
                if ($postData)
                {
                    curl_setopt($ch, CURLOPT_POSTFIELDS, $postData);
                }else{
                    curl_setopt($ch, CURLOPT_POSTFIELDS, '');
                }
                break;
            case "DELETE" :
                curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'DELETE');
                break;
        }

        if (!empty($curlSetting))
        {
            foreach($curlSetting as $option => $value)
            {
                curl_setopt($ch, $option, $value);
            }
        }

        $result = curl_exec($ch);
        $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        curl_close($ch);

        try {
            if (isset($curlService) && isset($curlLogs))
            {
                $curlService->update($curlLogs, $result, $httpCode);
            }
        } catch (Exception $e) {
        }

        // http status - 200: 成功, 201: 已建立, 202: 已接受, 204: 成功但無回傳
        if (!in_array($httpCode, ['200', '201', '202', '204']) && $showError)
        {
            // CURL POST 失敗
            throw new GnException('8012');
        }
        elseif (!in_array($httpCode, ['200', '201', '202', '204'])) 
        {
            return false;
        }

        return $result;
    }
}
