<?php


$x_issetup = get_option( 'x_issetup');

if($x_issetup !== '1'){
	/*
	
	 */



	update_option('x_issetup', 1);
}