<?php

    $line = $argv[1];

    // Initialize a file URL to the variable
    //$url = 'http://www.mnsu.edu/news/read/?id=old-1582317240&paper=topstories';
    $url = 'http://www.mnsu.edu/news/read/?id=old-' . $line . '&paper=topstories';

    // Use basename() function to return the base name of file
    //$file_name = basename($url);
    $file_name = $line . ".html";

    // Use file_get_contents() function to get the file
    // from url and use file_put_contents() function to
    // save the file by using base name

    $fcontent = file_get_contents($url);

    $p1 = strpos($fcontent, "begin t4p content");
    $p2 = strpos($fcontent, "/t4p content");
    $p3 = strrpos($fcontent, "mailto:?subject=");

    $fcontent = substr($fcontent, $p1 + 21, $p3 - $p1 - 33);

    if (strrpos($fcontent, '<img src=') > 0) {
        $tmp = substr($fcontent, strrpos($fcontent, '<img src='), 35);
        echo "image URL: " . $tmp . " ABC ";
            $fp = fopen('list_img_url.csv', 'a');//opens file in append mode
        fwrite($fp, $line . "," . $tmp . "\n");
        fclose($fp);
  
                    $fp = fopen('list_img_ID.csv', 'a');//opens file in append mode
        fwrite($fp, $line . "," . "https://www.mnsu.edu/news/read/?id=old-" . $line . "&paper=topstories\n");
        fclose($fp);
    }

    $fcontent = str_replace('<img', '<img style="display: block;margin-bottom: 4px;"', $fcontent);
    $fcontent = str_replace('"/news/', '"https://www.mnsu.edu/news/', $fcontent);
    

    //$fcontent = str_replace('�', 'abc', $fcontent);
    //$fcontent = str_replace('鈥', 'abc', $fcontent);

    //$fcontent = str_replace('<img src="/', '<img style="display: block;margin-bottom: 14px;" src="https://www.mnsu.edu/', $fcontent);

    $p4 = strrpos($fcontent, 'uppercase">');

    if (strrpos($fcontent, '</h4>') - $p4 <= 25) {
      $fcontent = substr($fcontent, 0, $p4 + 11) . substr($fcontent, $p4 + 21);
    } else {
      $fcontent = substr($fcontent, 0, $p4 + 11) . substr($fcontent, $p4 + 28);
    }

    if (file_put_contents($file_name, $fcontent))
    {
        echo "File " . $file_name . " downloaded successfully\n";
    }
    else
    {
        echo "File downloading failed.\n";
        $fp = fopen('list_fail.csv', 'a');//opens file in append mode
        fwrite($fp, $line . "\n");
        fclose($fp);
    }
?>
