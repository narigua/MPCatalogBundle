<?php

namespace MP\Bundle\CatalogBundle\Model;

interface ProductOwnerInterface
{
	public function getId();
	public function getName();
	public function getAddress();
	public function getPostCode();
	public function getCity();
	public function getCountry();
	public function getPhone();
	public function getMail();

}