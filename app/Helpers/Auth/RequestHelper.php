<?php


namespace App\Helpers\Auth;

class RequestHelper
{
    /** A helper function for request classes, for authorisation
     * To check whether the current logged in user is authorised to execute the api operation
     * @param int $resourceSegmentIndex
     * @return bool
     */
    public static function isCurrentUserAuthorisedToCallResource(int $resourceSegmentIndex)
    {
        $resourceId = (int)\Illuminate\Support\Facades\Request::segment($resourceSegmentIndex);
        // make sure the user can only change own's password or user is admin
        return auth()->user()->getAuthIdentifier() === $resourceId || auth()->user()->isAdmin();
    }
}
