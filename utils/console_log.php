<?php
function console_log($output, $with_script_tags = true)
{
    $js_code = 'console.log(\'' . $output . '\');';
    if ($with_script_tags) {
        $js_code = '<script>' . $js_code . '</script>';
    }
    echo $js_code;
}