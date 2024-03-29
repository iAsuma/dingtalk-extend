<?php
/**
 * dingtalk API: dingtalk.oapi.impaas.user.getprofile request
 * 
 * @author auto create
 * @since 1.0, 2018.08.23
 */
class OapiImpaasUserGetprofileRequest
{
	/** 
	 * 获取profile入参
	 **/
	private $request;
	
	private $apiParas = array();
	
	public function setRequest($request)
	{
		$this->request = $request;
		$this->apiParas["request"] = $request;
	}

	public function getRequest()
	{
		return $this->request;
	}

	public function getApiMethodName()
	{
		return "dingtalk.oapi.impaas.user.getprofile";
	}
	
	public function getApiParas()
	{
		return $this->apiParas;
	}
	
	public function check()
	{
		
	}
	
	public function putOtherTextParam($key, $value) {
		$this->apiParas[$key] = $value;
		$this->$key = $value;
	}
}
