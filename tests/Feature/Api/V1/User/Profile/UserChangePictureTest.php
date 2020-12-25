<?php

namespace Tests\Feature\Api\V1\User\Profile;

use App\Models\User;
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

    private function updateProfilePicture(User $user)
    {
        $image = UploadedFile::fake()->image('fake_pp');

        return $this->json('patch', $this->profilePicUrl($user->id), [
            'avatar_img' => $image,
        ], [
            'content-type' => 'form/multipart',
        ]);
    }

    public function test_user_can_only_change_profile_pic_for_themselves()
    {
        $user = $this->loginAsUser();

        $old_profile_pic = $user->avatar_location;

        $response = $this->updateProfilePicture($user);
        $response->assertStatus(200);

        $this->assertNotEquals($old_profile_pic, $user->refresh()->avatar_location, 'Old profile pic is not the same as updated profile pic');

        // second user
        $secondUser = $this->createUser();

        $response = $this->updateProfilePicture($secondUser);

        $response->assertStatus(403);
    }

    public function test_can_only_change_picture_when_logged_in()
    {
        $user = $this->createUser();
        $response = $this->updateProfilePicture($user);
        $response->assertStatus(401);
    }
}
