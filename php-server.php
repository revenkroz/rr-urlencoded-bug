<?php

file_put_contents('test_downloaded.png', $_POST['attachments'][0]['data']);

echo 'ok';
