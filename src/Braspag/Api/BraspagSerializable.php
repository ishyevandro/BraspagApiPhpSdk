<?php
namespace BraspagNonOffical\Api;

interface BraspagSerializable extends \JsonSerializable
{

    public function populate(\stdClass $data);
}