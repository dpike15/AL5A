<?php
// Include the SDK using the Composer autoloader
require '/var/www/html/vendor/autoload.php';
$client = new Aws\Sqs\SqsClient([
    'version' => 'latest',
    'region'  => 'us-east-1'
]);
?>
