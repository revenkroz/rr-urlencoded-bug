<?php

echo json_encode([
    'body' => $_POST,
], JSON_THROW_ON_ERROR | JSON_PRETTY_PRINT);
