<?php

include "Pack.php";

class MethodContent
{
	protected $mText = null;
	protected $mSourseRoutingInfo = null;
	protected $mOperationCode = null;
	protected $mPackerSize = null;
	protected $mPack = null;

	public function __construct($iMethodArray)
	{
		$this->mText = $iMethodArray['Text'];
		$this->mSourseRoutingInfo = $iMethodArray['SourseRoutingInfo'];
		$this->mOperationCode = $iMethodArray['OperationCode'];
		$this->mPackerSize = $iMethodArray['PackerSize'];
		$packArray = $iMethodArray['Pack'];
		if($packArray != null)
		{
			$vars = array();
			foreach ( $packArray as $value )
			{
				$vars[] = new Pack($value);
			}
	    $this->mPack = $vars;
	    }
	    else
	    {
	    	$this->mPack = null;
	    }
	}

	public function getText ()
	{
		return $this->mText;
	}

	public function getSourseRoutingInfo ()
	{
		return $this->mSourseRoutingInfo;
	}

	public function getOperationCode ()
	{
		return $this->mOperationCode;
	}

	public function getPackerSize ()
	{
		return $this->mPackerSize;
	}

	public function getPack ()
	{
		return $this->mPack ;
	}
}