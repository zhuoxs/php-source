<?php
/*
 * Licensed to the Apache Software Foundation (ASF) under one
 * or more contributor license agreements.  See the NOTICE file
 * distributed with this work for additional information
 * regarding copyright ownership.  The ASF licenses this file
 * to you under the Apache License, Version 2.0 (the
 * "License"); you may not use this file except in compliance
 * with the License.  You may obtain a copy of the License at
 *
 *     http://www.apache.org/licenses/LICENSE-2.0
 *
 * Unless required by applicable law or agreed to in writing,
 * software distributed under the License is distributed on an
 * "AS IS" BASIS, WITHOUT WARRANTIES OR CONDITIONS OF ANY
 * KIND, either express or implied.  See the License for the
 * specific language governing permissions and limitations
 * under the License.
 */
namespace Aliyun\Api\Dypls\Request\V20170525;

use Aliyun\Core\RpcAcsRequest;

class BindAxnExtensionRequest extends RpcAcsRequest
{
	function  __construct()
	{
		parent::__construct("Dyplsapi", "2017-05-25", "BindAxnExtension");
		$this->setMethod("POST");
	}

	private  $extension;

	private  $expectCity;

	private  $phoneNoX;

	private  $resourceOwnerAccount;

	private  $expiration;

	private  $isRecordingEnabled;

	private  $phoneNoA;

	private  $resourceOwnerId;

	private  $poolKey;

	private  $ownerId;

	private  $outId;

	public function getExtension() {
		return $this->extension;
	}

	public function setExtension($extension) {
		$this->extension = $extension;
		$this->queryParameters["Extension"]=$extension;
	}

	public function getExpectCity() {
		return $this->expectCity;
	}

	public function setExpectCity($expectCity) {
		$this->expectCity = $expectCity;
		$this->queryParameters["ExpectCity"]=$expectCity;
	}

	public function getPhoneNoX() {
		return $this->phoneNoX;
	}

	public function setPhoneNoX($phoneNoX) {
		$this->phoneNoX = $phoneNoX;
		$this->queryParameters["PhoneNoX"]=$phoneNoX;
	}

	public function getResourceOwnerAccount() {
		return $this->resourceOwnerAccount;
	}

	public function setResourceOwnerAccount($resourceOwnerAccount) {
		$this->resourceOwnerAccount = $resourceOwnerAccount;
		$this->queryParameters["ResourceOwnerAccount"]=$resourceOwnerAccount;
	}

	public function getExpiration() {
		return $this->expiration;
	}

	public function setExpiration($expiration) {
		$this->expiration = $expiration;
		$this->queryParameters["Expiration"]=$expiration;
	}

	public function getIsRecordingEnabled() {
		return $this->isRecordingEnabled;
	}

	public function setIsRecordingEnabled($isRecordingEnabled) {
		$this->isRecordingEnabled = $isRecordingEnabled;
		$this->queryParameters["IsRecordingEnabled"]=$isRecordingEnabled;
	}

	public function getPhoneNoA() {
		return $this->phoneNoA;
	}

	public function setPhoneNoA($phoneNoA) {
		$this->phoneNoA = $phoneNoA;
		$this->queryParameters["PhoneNoA"]=$phoneNoA;
	}

	public function getResourceOwnerId() {
		return $this->resourceOwnerId;
	}

	public function setResourceOwnerId($resourceOwnerId) {
		$this->resourceOwnerId = $resourceOwnerId;
		$this->queryParameters["ResourceOwnerId"]=$resourceOwnerId;
	}

	public function getPoolKey() {
		return $this->poolKey;
	}

	public function setPoolKey($poolKey) {
		$this->poolKey = $poolKey;
		$this->queryParameters["PoolKey"]=$poolKey;
	}

	public function getOwnerId() {
		return $this->ownerId;
	}

	public function setOwnerId($ownerId) {
		$this->ownerId = $ownerId;
		$this->queryParameters["OwnerId"]=$ownerId;
	}

	public function getOutId() {
		return $this->outId;
	}

	public function setOutId($outId) {
		$this->outId = $outId;
		$this->queryParameters["OutId"]=$outId;
	}
	
}