<?php
namespace BraspagNonOfficial\Api;

interface BraspagSerializable extends \JsonSerializable
{

    public function populate(\stdClass $data);
}