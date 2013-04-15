<?php
include('./raw-pagination.php');
//set POST variables
$url = 'http://librarytest.med.ucf.edu/WebServices/Communications.asmx/GetResourcesByValueAndResourceType';
$fields = array(
		'contextKey' => 'L1bRar4T3st',
		'resourceTypeID' => 3,
		'value' => 'O'
);
$fields_string="";
//url-ify the data for the POST
foreach($fields as $key=>$value) {
	$fields_string .= $key.'='.$value.'&';
}
rtrim($fields_string, '&');

//open connection
$ch = curl_init();

//set the url, number of POST vars, POST data
curl_setopt($ch,CURLOPT_URL, $url);
curl_setopt($ch,CURLOPT_POST, count($fields));
curl_setopt($ch,CURLOPT_POSTFIELDS, $fields_string);
curl_setopt($ch, CURLOPT_RETURNTRANSFER,1);
	
//execute post
$result = curl_exec($ch);

//close connection
curl_close($ch);
$xml = simplexml_load_string($result);
$json = json_encode($xml);
$library_data_array = json_decode($json,TRUE);
if( isset( $_GET['page'] ) ) {
	$current_page = $_GET['page'];
} else {
	$current_page = 1;
}

?>
<?php echo getPaginationString($current_page, count($library_data_array['WebserviceResourceData']), 15, 2, "index.php", "?page=");?>

<div>
	<input type="text" class="auto-clear" value="Search by Title"/>
	<input type="button" value="Go"/>
	<input type="text" class="auto-clear" value="Search by Subject"/>
	<input type="button" value="Go"/>
</div>

		<ul class="library-data-header">
			<li class="thumbnail-cell"></li>
			<li class="title-cell">Title</li>
			<li class="year-cell">Year</li>
			<li class="provider-cell">Provider</li>
		</ul>
	<?php foreach($library_data_array['WebserviceResourceData'] as $resource){?>
		<ul class="library-data-row">
			<li class="title-cell"><?php echo $resource['Title']; ?></li>
		</ul>					
	<?php }
			?>
</div>



<style type="text/css">
div.library-table{
	font-size:.8em;
}

ul.library-pagination {
	float: left;
	list-style: none outside none;
	display: block;
	width:100%;	
}

ul.library-pagination li {
	float: left;
	display: block;
}


ul.library-data-header {
	float: left;
	list-style: none outside none;
	display: block;
	width:100%;
}

ul.library-data-header li {
	float: left;
	display: block;
}

ul.library-data-row {
	float: left;
	list-style: none outside none;
	display: block;
	width:100%;	
}

ul.library-data-row li {
	float: left;
	display: block;
}
.thumbnail-cell {
	width: 2%;
}
.author-cell {
	width: 20%;
}

.title-cell {
	width: 30%;
}

.year-cell {
	width: 3%;
}

.provider-cell {
	width: 15%;
}




div.pagination {
	padding: 3px;
	margin: 3px;
}

div.pagination a {
	padding: 2px 5px 2px 5px;
	margin: 2px;
	border: 1px solid #AAAADD;
	
	text-decoration: none; /* no underline */
	color: #000099;
}
div.pagination a:hover, div.pagination a:active {
	border: 1px solid #000099;

	color: #000;
}
div.pagination span.current {
	padding: 2px 5px 2px 5px;
	margin: 2px;
		border: 1px solid #000099;
		
		font-weight: bold;
		background-color: #000099;
		color: #FFF;
	}
	div.pagination span.disabled {
		padding: 2px 5px 2px 5px;
		margin: 2px;
		border: 1px solid #EEE;
	
		color: #DDD;
	}
	

</style>
