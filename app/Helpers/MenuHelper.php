<?php

function setActive($uriSegment)
{
    // Get the current URI segment
    $currentUri = uri_string();
    
    // Check if the current URI segment matches the input segment
    return $currentUri == $uriSegment ? 'active' : '';
}