<?php

// load the json data or re-initialise the data
$fileStore = 'reactions.json';
$json = file_get_contents($fileStore) ?: '[]';

// if we have something to to
if (isset($_POST['action'])) {
	// decode the JSON or re-initialise the data
	$reactions = json_decode($json) ?: array();

	if (isset($_POST['name']) && isset($_POST['text'])) {
		// add our reaction
		$reactions[] = array(
			'key' => end($reactions)->key + 1, // increment the last key
			'name' => $_POST['name'],
			'text' => $_POST['text'],
			'when' => gmdate('c')
		);

		// save the new data
		file_put_contents($fileStore, $json = json_encode($reactions));
	}

	if (isset($_POST['delete'])) {
		foreach ($reactions as $i=>$reaction) {
			if ($reaction->key == $_POST['delete']) {
				delete($reactions[$i]);

				// save the data
				file_put_contents($fileStore, $json = json_encode($reactions));

				break;
			}
		}
	}
}

// output the json data
header('Content-Type: application/json');
die($json);
