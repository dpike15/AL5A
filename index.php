<?php
include 'sqs.php';

if(isset($_GET['mode'])){
	$queueUrl = 'https://sqs.us-east-1.amazonaws.com/391901324314/maintenance';

	echo "<html><head><title>Camera</title></head>"; ?>
	<body><h2> <?php echo $_GET['mode']; ?></h2><center><h1>Object Retrieval</h1>

	<?php
	echo "<h3>Looking for Objects......</h3>"; ?>

<!--	<img src="http://192.168.0.17:88/snapshot.cgi?user=guest&pwd=guest&t="/><br> -->

	<?php
	while(true){
		$result = $client->receiveMessage(array(
    		'QueueUrl' => $queueUrl,
		));
		//echo $result;
		if($result['Messages'] != null){
			echo '<p id="text">Object Detected!</p>';

			$body = $result['Messages'][0]['Body'];
			if($_GET['mode'] == 'Manual'){ 
			   $result2 = $client->deleteMessage(array(
                        'QueueUrl' => $queueUrl,
                        'ReceiptHandle'=> $result['Messages'][0]['ReceiptHandle']
                        ));

                          $result1 =  $client->purgeQueue(array(
                                'QueueUrl' => $queueUrl,
                        ));
			?>
			<button id="retrieve">Retrieve Object</button><br><br>
			<button id="myBtn">Continue Searching</button>
	  		<script type="text/javascript">
			var rtbtn = document.getElementById('retrieve');
			rtbtn.addEventListener('click', function(){
			document.getElementById('text').innerHTML = "Retrieving Object Now!";
			document.location.href = '<?php echo 'manual.php?body=' . $body; ?>';
			});
			</script>
			<script>
    			var btn = document.getElementById('myBtn');
    			btn.addEventListener('click', function() {
      			document.location.href = '<?php echo 'index.php?mode=' . $_GET['mode']; ?>';
    			});
 			 </script>
			<?php
			}else{
			echo '<h3>Retrieving Object Now!<h3>';		
			
			$client->sendMessage(array(
				'QueueUrl' => "https://sqs.us-east-1.amazonaws.com/391901324314/maintenanceArduino",
				'MessageBody'=> $body,
			));

			 $result2 = $client->deleteMessage(array(
                        'QueueUrl' => $queueUrl,
                        'ReceiptHandle'=> $result['Messages'][0]['ReceiptHandle']
                        ));

                          $result1 =  $client->purgeQueue(array(
                                'QueueUrl' => $queueUrl,
                        ));


			?>
                        <script>
                        function myFunction() {
                        location.reload();
                         }
                        setTimeout(myFunction,5000);
                      	</script>
			<?php			

			}
		   
		}else{
			echo "<p>No Objects Detected!</p>"; ?> 
			<button id="mode">Switch Modes</button></center>;
                        <script type="text/javascript">
                        var mode = document.getElementById('mode');
                        mode.addEventListener('click', function(){
                        
                        document.location.href = '<?php echo 'mode.php'; ?>';
                        });
                        </script>
			<?php
			sleep(3);?>
			<script>
        		function myFunction() {
        		location.reload();
       			 }
       			 myFunction();
		      </script>	
	<?php

		}

	break;
	}
	
}
else{
	echo "<html><head><title>Camera</title></head>";
	echo "<body><center><h1>No Mode Selected!</h1></center>";

}

?>


