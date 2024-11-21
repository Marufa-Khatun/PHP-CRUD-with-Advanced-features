<?php

/**
 * create a alert for any validation
 * @param $msg
 * @param $type
 */

function createAlert($msg, $type = "danger")
{
	return "<p class=\"alert alert-{$type} d-flex justify-content-between\">{$msg} <button class=\"btn-close\" data-bs-dismiss=\"alert\" aria-label=\"Close\"></button></p>";
}

/**
 * Get old value
 * @param $field_name
 */
function oldValue($field_name, $default = '')
{
	return $_POST[$field_name] ?? $default;
}

/**
 * reset form
 * @param $field_name
 */
function resetForm()
{
	return $_POST = [];
}
/**
 * unique id generate
 */
function generateUniqueId()
{
	return uniqid();
}


/**
 * time ago function
 */
date_default_timezone_set('Asia/Dhaka'); // আপনার টাইমজোন অনুসারে সেট করুন

function timeAgo($timestamp)
{
	// মাইক্রোসেকেন্ড বাদ দেওয়া হচ্ছে
	$timestamp = preg_replace('/\.\d+$/', '', $timestamp); // মাইক্রোসেকেন্ড বাদ দেয়

	// Timestamp কে strtotime এ রূপান্তরিত করা
	$timestamp = strtotime($timestamp);

	// যদি strtotime() কোনো কারণে টাইমস্ট্যাম্প সঠিকভাবে রূপান্তর করতে না পারে
	if ($timestamp === false) {
		return "Invalid timestamp";
	}

	// Current time এর সাথে টাইমস্ট্যাম্প এর পার্থক্য বের করা
	$timeDifference = time() - $timestamp;

	// যদি সময়ের পার্থক্য নেগেটিভ হয়, তাহলে ভবিষ্যতের সময় দেখাবে
	if ($timeDifference < 0) {
		return "The time is in the future.";
	}

	// সময়ের পার্থক্য থেকে সেকেন্ড, মিনিট, ঘণ্টা ইত্যাদি বের করা
	$seconds = $timeDifference;
	$minutes = floor($seconds / 60);
	$hours = floor($seconds / 3600);
	$days = floor($seconds / 86400);
	$weeks = floor($seconds / 604800);
	$months = floor($seconds / 2629440);
	$years = floor($seconds / 31553280);



	if ($seconds < 60) {
		return "Just now";
	} elseif ($minutes < 60) {
		return ($minutes == 1) ? "one minute ago" : "$minutes minutes ago";
	} elseif ($hours < 24) {
		return ($hours == 1) ? "one hour ago" : "$hours hours ago";
	} elseif ($days < 7) {
		return ($days == 1) ? "one day ago" : "$days days ago";
	} elseif ($weeks < 4) {
		return ($weeks == 1) ? "one week ago" : "$weeks weeks ago";
	} elseif ($months < 12) {
		return ($months == 1) ? "one month ago" : "$months months ago";
	} else {
		return ($years == 1) ? "one year ago" : "$years years ago";
	}
}


//cookie messange function

function setMessage($key, $msg)
{

	setcookie($key, $msg, time() + 2);
}

function getMessage($key, $type = 'danger')
{
	if (isset($_COOKIE[$key])) {
		$msg = $_COOKIE[$key];
		echo "<p class=\"alert alert-{$type} d-flex justify-content-between\">{$msg} <button class=\"btn-close\" data-bs-dismiss=\"alert\" aria-label=\"Close\"></button></p>";
	} else {
		echo "";
	}
}
