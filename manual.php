<?php
include 'sqs.php';
?>
<html><head><title>Camera</title></head>

<body><h2>Manual</h2><center><h1>Object Retrieval</h1>
<h4 id='text'>Retrieval in Progress</h4>
<?php
if(isset($_GET['body'])){
  $client->sendMessage(array(
                                'QueueUrl' => "https://sqs.us-east-1.amazonaws.com/391901324314/maintenanceArduino",
                                'MessageBody'=> $_GET['body'],
                        ));


}
?>

    <script>
                        function myFunction() {
                        document.getElementById('text').innerHTML = "Object Retrieved!"
                         }
                        setTimeout(myFunction,10000);
   </script>
 <button id="myBtn">Back to Object Search!</button>
                        <script type="text/javascript">
                        var rtbtn = document.getElementById('myBtn');
                        rtbtn.addEventListener('click', function(){
                        
                        document.location.href = '<?php echo 'index.php?mode=Manual'; ?>';
                        });
</script>
