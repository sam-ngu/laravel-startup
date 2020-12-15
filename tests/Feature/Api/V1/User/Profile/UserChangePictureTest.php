<?php

namespace Tests\Feature\Api\V1\User\Profile;

use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Http\UploadedFile;
use Tests\ApiTestCase;

class UserChangePictureTest extends ApiTestCase
{
    use WithFaker;

    private function profilePicUrl(string $userId)
    {
        return '/api/v1/users/' . $userId . '/profile/picture';
    }

    public function test_user_can_only_change_profile_pic_for_themselves()
    {
        $user = $this->loginAsUser();

        $old_profile_pic = $user->avatar_location;

        $image = UploadedFile::fake()->image('fake_pp');

        $response = $this->json('patch', $this->profilePicUrl($user->id), [
            'avatar_img' => $image,
        ], [
            'content-type' => 'form/multipart',
        ]);

        $response->assertStatus(200);

        $this->assertNotEquals($old_profile_pic, $user->refresh()->avatar_location, 'Old profile pic is not the same as updated profile pic');

        // second user
        $secondUser = $this->createUser();

        $response = $this->json('patch', $this->profilePicUrl($secondUser->id), [
            'avatar_img' => $image,
        ], [
            'content-type' => 'form/multipart',
        ]);

        $response->assertStatus(403);
    }




    public function test_user_can_change_profile_picture()
    {


        $user = $this->loginAsUser();



    }
}
