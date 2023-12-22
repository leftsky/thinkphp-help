<?php

// 成功

if (!function_exists('rsps')) {
    /**
     * laravel 封装回执
     * @param int $code
     * @param null $data
     * @param string|null $msg
     * @return \think\response\Json
     */
    function rsps(int $code, $data = null, string $msg = null)
    {
        return $response = json([
            "code" => $code,
            "msg" => $msg ?? define_to_message($code),
            "data" => $data
        ]);
    }
}

if (!function_exists("get_cur_domain")) {
    /**
     * 获得当前的域名，【app.imgDomain】-【$_SERVER】-【domain】
     * @return string
     */
    function get_cur_domain(): string
    {
        $domain = config("app.imgDomain");
        if (!$domain) {
            if (isset($_SERVER['SERVER_PORT']) && isset($_SERVER['HTTP_HOST']))
                $domain = ((int)$_SERVER['SERVER_PORT'] === 80
                        ? 'http://' : 'https://') . $_SERVER['HTTP_HOST'];
            else $domain = config("domain");
        }
        return $domain;
    }
}

if (!function_exists("fix_img")) {
    /**
     * 使用域名拼接图片路径
     * @param string $value
     * @return string
     */
    function fix_img(string $value): string
    {
        if ($value == "") $value = config("default.image") ? config("default.image") : "";
        if (strstr($value, "http")) return $value;
        $domain = get_cur_domain();
        return "$domain$value";
    }
}

if (!function_exists("undo_fix_img")) {
    /**
     * 消除图片路径中的本域名信息
     * @param string $value
     * @return string
     */
    function undo_fix_img(string $value): string
    {
        if ($value == "" || !strstr($value, "http")) return $value;
        $domain = get_cur_domain();
        return str_replace($domain, "", $value);
    }
}

if (!function_exists("fix_article")) {
    /**
     * 使用域名拼接替换文章内资源路径
     * @param string $value
     * @param string $search
     * @return string
     */
    function fix_article(string $value, string $search): string
    {
        if (strstr($value, "http")) return $value;
        if ($value == "") return config("default.image") ? config("default.image") : "";
        $domain = get_cur_domain();
        return str_replace($search, $domain . $search, $value);
    }
}

if (!function_exists("undo_fix_article")) {
    /**
     * 消除文章内的路径信息
     * @param string $value
     * @param string $search
     * @return string
     */
    function undo_fix_article(string $value, string $search): string
    {
        if ($value == "" || !strstr($value, "http")) return $value;
        $domain = get_cur_domain();
        return str_replace($domain . $search, $search, $value);
    }
}
