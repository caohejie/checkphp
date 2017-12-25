<?php
$version_ok = $pcntl_loaded = $redis_loaded = $posix_loaded =$openssl_loaded = $event_loaded = false;
if(version_compare(phpversion(), "7.0.0", ">="))
{
    $version_ok = true;
}
if(in_array("pcntl", get_loaded_extensions()))
{
    $pcntl_loaded = true;
}
if(in_array("posix", get_loaded_extensions()))
{
    $posix_loaded = true;
}
if(in_array("redis", get_loaded_extensions()))
{
    $redis_loaded = true;
}
if(in_array("openssl", get_loaded_extensions()))
{
    $openssl_loaded = true;
}
if(in_array("event", get_loaded_extensions()))
{
    $event_loaded = true;
}




function check($val)
{
    if($val)
    {
        return "\033[32;40m [OK] \033[0m\n";
    }
    else
    {
        return "\033[31;40m [fail] \033[0m\n";
    }
}

echo "PHP Version >= 7.0.0                 " . check($version_ok);

echo "Extension pcntl check                " . check($pcntl_loaded);

echo "Extension posix check                " . check($posix_loaded);

echo "Extension redis check                " . check($redis_loaded);

echo "Extension openssl check              " . check($openssl_loaded);

echo "Extension event check                " . check($event_loaded);

$check_func_map = array(
    "stream_socket_server",
    "stream_socket_client",
    "pcntl_signal_dispatch",
);
// 获取php.ini中设置的禁用函数
if($disable_func_string = ini_get("disable_functions"))
{
    $disable_func_map = array_flip(explode(",", $disable_func_string));
}
// 遍历查看是否有禁用的函数
foreach($check_func_map as $func)
{
    if(isset($disable_func_map[$func]))
    {
        echo "\n\033[31;40mFunction $func may be disabled. Please check disable_functions in php.ini\n";

        exit;
    }
}

echo "see https://github.com/caohejie/checkphp/blob/master/README.md\033[0m\n";
