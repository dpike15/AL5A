<?php
include 'sqs.php';

if(isset($_GET['mode'])){
	$queueUrl = 'https://sqs.us-east-1.amazonaws.com/391901324314/maintenance';
	
	echo "<html><head><title>Camera</title></head>"; ?>
	<body><h2> <?php echo $_GET['mode']; ?></h2><center><h1>Object Retrieval</h1>

	<?php
	echo "<h3>Looking for Objects......</h3></body></html>"; 
	?>
	<iframe src="https://player.twitch.tv/?channel=dapike7979" frameborder="0" allowfullscreen="true" scrolling="no" height="378" width="620"></iframe><a href="https://www.twitch.tv/dapike7979?tt_medium=live_embed&tt_content=text_link" style="padding:2px 0px 4px; display:block; width:345px; font-weight:normal; font-size:10px; text-decoration:underline;">Watch live video from dapike7979 on www.twitch.tv</a>  	
	<body>
	<p id="result"></p>
<?php



$result = $client->receiveMessage(array(
        'QueueUrl'=>$queueUrl,
));
if($result['Messages']  != null){
$body = $result['Messages'][0]['Body']; 
$rec = $result['Messages'][0]['ReceiptHandle'];
	if($_GET['mode'] == Manual){ 


?>
        <button id="retrieve">Retrieve Object</button><br><br>
<script type="text/javascript">
	document.getElementById("result").innerHTML = "Object Detected!";
                        var rtbtn = document.getElementById('retrieve');
                        rtbtn.addEventListener('click', function(){
                        document.location.href = '<?php echo 'manual.php?body=' . $body . '&rec=' . $rec; ?>';
                        });
 function myFunctionDetected() {
                        location.reload();
                         }
                        setTimeout(myFunctionDetected,60000);  
</script>
<?php
}else{
	?>
	<script>
	document.getElementById("result").innerHTML = "Retrieving Now!";
	</script>
	<?php
	$client->sendMessage(array(
	'QueueUrl'=>'https://sqs.us-east-1.amazonaws.com/391901324314/maintenanceArduino',
	'MessageBody'=> $body,
	));

	$result3 = $client->deleteMessage(array(
             'QueueUrl' => $queueUrl,
             'ReceiptHandle'=> $result['Messages'][0]['ReceiptHandle'],
         ));

         $result4 =  $client->purgeQueue(array(
                'QueueUrl' => $queueUrl,
          )); ?>
	 <script>
                        function myFunctionA() {
                        location.reload();
                         }
                        setTimeout(myFunctionA,40000);        
	 </script>

<?php
}
}else{ ?>
       

  <script>
	document.getElementById("result").innerHTML = "No Objects Detected!";
                        function myFunction() {
                        location.reload();
                         }
                        setTimeout(myFunction,10000);         </script>
<?php } ?>
</body>
</html>


<?php


}
?>





