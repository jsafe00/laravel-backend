<?php

namespace Tests\Feature;

use App\Models\Post;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

/**
 * Post Test
 */
class PostTest extends TestCase
{
    use RefreshDatabase;

    /**
     * Test the list endpoint.
     *
     * @return void
     */
    public function testListEndpoint_withSeededData_expectTheCorrectCount()
    {
        Post::factory()->times(3)->create();

        $this->get(route('posts.list'))
            ->assertStatus(200)
            ->assertJsonCount(3, 'data');
    }

    /**
     * Test the list endpoint with static data.
     *
     * @return void
     */
    public function testListEndpoint_withStaticData_expectCorrectDataReturned()
    {
        Post::factory()
            ->create(
                [
                    'title' => 'title1',
                    'description' => 'description1',
                ]
            );

        Post::factory()
            ->create(
                [
                    'title' => 'title2',
                    'description' => 'description2',
                ]
            );

        Post::factory()
            ->create(
                [
                    'title' => 'title3',
                    'description' => 'description3',
                ]
            );

        $this->get(route('posts.list'))
            ->assertStatus(200)
            ->assertJsonCount(3, 'data')
            ->assertJson([
                'data' => [
                    [
                        'title' => 'title1',
                        'description' => 'description1',
                    ],
                    [
                        'title' => 'title2',
                        'description' => 'description2',
                    ],
                    [
                        'title' => 'title3',
                        'description' => 'description3',
                    ],
                ]
            ]);
    }

    /**
     * Test the create endpoint validation.
     *
     * @return void
     */
    public function testCreateEndpoint_withInvalidData_expectValidationErrors()
    {
        $this->postJson(route('posts.create'), [])
            ->assertJsonValidationErrors(['title', 'description']);

        $this->postJson(route('posts.create'), [
            'title' => null,
            'description' => 'descriptionCreateValidation',
        ])
            ->assertJsonValidationErrors(['title']);
    }

    /**
     * Test the create endpoint.
     *
     * @return void
     */
    public function testCreateEndpoint_withValidData_expectResource()
    {
        $this->postJson(route('posts.create'), [
            'title' => 'titleCreate',
            'description' => 'descriptionCreate',
        ])
            ->assertStatus(201)
            ->assertJson([
                'data' => [
                    'title' => 'titleCreate',
                    'description' => 'descriptionCreate',
                ]
            ]);
    }

    /**
     * Test the show endpoint with missing resource.
     *
     * @return void
     */
    public function testShowEndpoint_withMissingResource_expectPageNotFound()
    {
        $this->get(route('posts.show', 2))
            ->assertNotFound();
    }

    /**
     * Test the show endpoint.
     *
     * @return void
     */
    public function testShowEndpoint_withCorrectRoute_expectResource()
    {
        $post = Post::factory()->create([
            'title' => 'titleShow',
            'description' => 'descriptionShow',
        ]);

        $this->get(route('posts.show', $post))
            ->assertStatus(200)
            ->assertJson([
                'data' => [
                    'title' => 'titleShow',
                    'description' => 'descriptionShow',
                ]
            ]);
    }

    /**
     * Test the update endpoint validation.
     *
     * @return void
     */
    public function testUpdateEndpoint_withInvalidData_expectValidationErrors()
    {
        $this->putJson(route('posts.update', 2))
            ->assertNotFound();

        $post = Post::factory()->create();

        $this->putJson(route('posts.update', $post), [])
            ->assertJsonValidationErrors(['title', 'description']);

        $this->putJson(route('posts.update', $post), [
            'title' => 'titleUpdateError',
            'description' => null,
        ])
            ->assertJsonValidationErrors(['description']);
    }

    /**
     * Test the update endpoint.
     *
     * @return void
     */
    public function testUpdateEndpoint_withValidData_expectResource()
    {
        $post = Post::factory()->create([
            'description' => 'UpdateDesc',
        ]);

        $this->putJson(route('posts.update', $post), [
            'title' => 'titleUpdate',
            'description' => 'descriptionUpdate',
        ])
            ->assertStatus(200)
            ->assertJson([
                'data' => [
                    'title' => 'titleUpdate',
                    'description' => 'descriptionUpdate',
                ]
            ]);
    }

    /**
     * Test the destroy endpoint validation.
     *
     * @return void
     */
    public function testDestroyEndpoint_withMissingResource_expectPageNotFound()
    {
        $this->deleteJson(route('posts.destroy', 2))
            ->assertNotFound();
    }

    /**
     * Test the destroy endpoint.
     *
     * @return void
     */
    public function testDestroyEndpoint_withCorrectRoute_expectSuccessMessage()
    {
        $post = Post::factory()->create([
            'title' => 'Delete Title',
           
        ]);

        $this->deleteJson(route('posts.destroy', $post))
            ->assertStatus(200)
            ->assertJson([
                'messages' => [
                    'Delete Title has been deleted',
                ]
            ]);
    }
}
