<?php

namespace app\Repository;
use AWS;
use Config;

class ApiRepository{

	/**
	 * [api description]
	 * @param  [type] $params [description]
	 * @return [type]         [description]
	 */
	public static function api($params){

		$function 				= @$params['function'];

		if($function == 'deregisterImage'){
			return ApiRepository::deregisterImage($params);
		
		}elseif($function == 'createImage'){
			return ApiRepository::createImage($params);

		}

	}

	/**
	 * [createImage description]
	 * @param  [type] $params [description]
	 * @return [type]         [description]
	 */
	public static function createImage($params){

		$function 						= @$params['function'];
		$total 							= 0;

		$ec2 							= AWS::createClient('ec2');
		$reservationRaw 				= $ec2->describeInstances(array('Owners'=> array('self') ));
		$reservationArray 				= $reservationRaw['Reservations'];
		
		if(is_array($reservationArray)){
			foreach($reservationArray AS $reservation){
				$instancesArray 		= @$reservation['Instances'];

				if(is_array($instancesArray)){
					$backup 					= false;
					$instanceName 				= "";

					foreach($instancesArray AS $instance){
						$instanceId 			= @$instance['InstanceId'];
						$tagArray 				= @$instance['Tags'];

						# check if the instance has a tag called backup ------------------
						if(is_array($tagArray)){
							foreach($tagArray AS $tag){
								$tagKey 		= @strtolower( $tag['Key'] );
								if( $tagKey == strtolower( Config::get('api.awsInstanceTag') )){
									$backup 	= true;
								
								}elseif( $tagKey == 'name' ){
									$instanceName 	= @$tag['Value'];
								}
								
							}
						}

						# do the backup --------------------------------------------------
						if( $backup ){

							#check if image exists
							$imageName 						= date("Y-m-d").'_'.$instanceName;
							$imageExists 					= ApiRepository::getImageByName( $imageName );

							if( !$imageExists ){

								$createImage 				= $ec2->createImage(array(
																			'InstanceId' 	=> $instanceId,
																			'Name'			=> $imageName,
																			));
								++$total;
							}
						}
					}
				}
			}
		}

		echo "<h3>Total $function = $total</h3>";
	}

	/**
	 * [imageExists description]
	 * @param  string $instanceName [description]
	 * @return [type]               [description]
	 */
	public static function getImageByName($imageName=''){
		$returnValue 					= false;
		$ec2 							= AWS::createClient('ec2');
		$imageRaw 						= $ec2->describeImages(array('Owners'=> array('self') ));
		$imagesArray 					= @$imageRaw['Images'];
		
		if(is_array($imagesArray)){
			foreach($imagesArray AS $row){
				$name 					= @$row['Name'];
				if( strtolower($name) == strtolower($imageName) ){
					$returnValue 		= $row;
				}
			}
		}
		return $returnValue;
	}

	/**
	 * [cleanImages description]
	 * @param  [type] $params [description]
	 * @return [type]         [description]
	 */
	public static function deregisterImage($params){
		$dateNow 						= date("Ymd");
		$function 						= @$params['function'];
		$total 							= 0;
		$ec2 							= AWS::createClient('ec2');
		$imageRaw 						= $ec2->describeImages(array('Owners'=> array('self') ));

		$imageArray 					= $imageRaw['Images'];

		if(is_array($imageArray)){
			foreach($imageArray AS $row){
				$imageId 				= @$row['ImageId'];

				$date_from 				= substr($row['Name'], 0, 10);
				$date_from 				= date("Ymd", strtotime($date_from));

				if($date_from >= Config::get('api.awsImageDateFrom') ){

					if( ($date_from - $dateNow) > Config::get('api.awsImageDay') ){
						$delete 		= $ec2->deregisterImage( array( 'ImageId' => $imageId ) );
						print_r($delete)."<br />";
						++$total;
					}
				}
			}
		}
		echo "<h3>Total $function = $total</h3>";
	}

}