<?php

namespace Tests\Feature\Api\V1\User\Api\V1\User;

use App\Events\Models\User\UserCreated;
use App\Events\Models\User\UserPermanentlyDeleted;
use App\Events\Models\User\UserUpdated;
use App\Models\User;
use App\Repositories\Api\V1\UserRepository;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Event;
use Illuminate\Support\Str;
use Spatie\QueryBuilder\AllowedFilter;
use Tests\ApiTestCase;

class UserApiTest extends ApiTestCase
{

    protected $admin;

    protected $uri = '/api/v1/users';


    protected function setUp(): void
    {
        parent::setUp();
        $this->admin = $this->loginAsAdmin();
    }


    public function test_index()
    {
        $users = factory(User::class,10)->create();

        $dummy = $users->first();

        $response = $this->json('get', $this->uri);

        $response->assertStatus(200);


        /* test sort */
        $repo = new UserRepository;
        $sortableFields = $repo->allowedSorts;

        if(!empty($sortableFields)){
            collect($sortableFields)->each(function ($sortable){
                // testing desc sort
                $response = $this->json('get', $this->uri, [
                    'sort' => '-' . $sortable
                ]);

                $results = $response->assertStatus(200)->json('data');

                // make sure array is actually sorted
                collect($results)->reduce(function ($carry, $current){
                    $this->assertTrue($carry < $current);
                    return $current;
                });
            });

        }


        /* test filter*/

        $filterables = $repo->allowedFilters;

        if(!empty($filterables)){
            collect($filterables)->each(function ($filterable) use($dummy){
                if($filterable instanceof AllowedFilter){
                    $filterable = $filterable->getName();
                }

                $dummyValue = ($dummyValue = data_get($dummy, $filterable)) instanceof Carbon ? (string)$dummyValue : $dummyValue;

                $query = http_build_query([
                    "filter[{$filterable}]" => $dummyValue,
                ]);


                $response = $this->json('get', $this->uri  .'?' . $query);

                $results = $response->assertStatus(200)->json('data');

                collect($results)->each(function ($result)use($filterable, $dummyValue){
                    $this->assertTrue(data_get($result, $filterable) === $dummyValue );
                });


            });


        }

        // test search
        if((new \ReflectionClass(User::class))->hasMethod('search') ){

            $searchableFields = collect($dummy->toSearchableArray())->except(['id'])->keys();

            $toSearch = $searchableFields->random();

            $uuid = Str::uuid()->toString();

            $dummy = factory(User::class, 5)->create([
                $toSearch => $uuid
            ]);

            $response = $this->json('get', $this->uri . '?' . http_build_query(['search' => $uuid]) );

            $results = $response->assertStatus(200)->json('data');

            $this->assertCount(5, $results);
        }

    }

    public function test_show()
    {
        $dummy = factory(User::class)->create();
        $response = $this->json('get', $this->uri . '/' . $dummy->id);

        $result = $response->assertStatus(200)->json('data');

        $this->assertEquals(data_get($result, 'id'), $dummy->id);

    }

    public function test_create()
    {
        Event::fake();
//        $fillables = collect((new User)->getFillable());

//        $toFill = $fillables->random();
//
        $dummy = factory(User::class)->make();


        $response = $this->json('post', $this->uri, $dummy->toArray());

//        $response->dump();
        $result = $response->assertStatus(201)->json('data');

        Event::assertDispatched(UserCreated::class);

//        $this->assertTrue(data_get($result, $toFill) === data_get($dummy, $toFill));
    }


    public function test_update()
    {
        Event::fake();

        $dummy = factory(User::class)->create();
        $dummy2 = factory(User::class)->make();

        $fillables = collect((new User)->getFillable());
        $toUpdate = $fillables->random();

        $response = $this->json('patch', $this->uri . '/' . $dummy->id, [
            $toUpdate => data_get($dummy2, $toUpdate)
        ]);

        $result = $response->assertStatus(200)->json('data');

        Event::assertDispatched(UserUpdated::class);

        $this->assertEquals(data_get($dummy2, $toUpdate), data_get($dummy->refresh(), $toUpdate));

    }


    public function test_delete()
    {
        Event::fake();

        $dummy = factory(User::class)->create();
        $response = $this->json('delete', $this->uri . '/' . $dummy->id);

        $result = $response->json('data');

        $this->expectException(ModelNotFoundException::class);

        User::query()->findOrFail($dummy->id);

        Event::assertDispatched(UserPermanentlyDeleted::class);


    }

}
