<?php

namespace Tests\Feature;

use App\Models\Article;
use App\Models\User;
use App\Services\ArticlesService;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Tests\TestCase;

class ArticlesServiceTest extends TestCase
{
    use DatabaseMigrations;
    protected $default_email ='ivan.alvarado@serprogramador.es';
    public function setUp(): void
    {
        parent::setUp();
        $existent = User::where('email',$this->default_email)->first();
        if(is_null($existent))
        {
            User::create([
               'name' => 'Ivan Alvarado',
                'email' => $this->default_email,
                'password' => Hash::make('mytestpassword')
            ]);
        }
    }
    /**
     * A basic feature test example.
     */
    public function test_create_article_with_wrong_data_return_null(): void
    {
        $user = User::where('email', $this->default_email)->first();
        $this->assertNotNull($user);
        $this->assertInstanceOf(User::class, $user);

        /** @var ArticlesService $articlesService */
        $articlesService = $this->app->make(ArticlesService::class);
        $this->assertNotNull($articlesService);
        $uncompleted_data = [
            'name' => 'Article 1',
            'description' => 'This is my description1'
        ];
        $response = $articlesService->create($uncompleted_data);
        $this->assertNull($response);
    }

    public function test_create_article_without_login_raise_error(): void
    {
        $user = User::where('email', $this->default_email)->first();
        $this->assertNotNull($user);
        $this->assertInstanceOf(User::class, $user);

        /** @var ArticlesService $articlesService */
        $articlesService = $this->app->make(ArticlesService::class);
        $this->assertNotNull($articlesService);
        $data = [
            'name' => 'Article 1',
            'description' => 'This is my description1',
            'amount' => 1,
            'price' => 15.5
        ];
        $response = $articlesService->create($data);
        $this->assertNull($response);
    }

    public function test_create_with_data_return_article()
    {
        $user = User::where('email', $this->default_email)->first();
        $this->assertNotNull($user);
        $this->assertInstanceOf(User::class, $user);
        Auth::login($user);
        /** @var ArticlesService $articlesService */
        $articlesService = $this->app->make(ArticlesService::class);
        $this->assertNotNull($articlesService);
        $data = [
            'name' => 'Article 1',
            'description' => 'This is my description1',
            'amount' => 1,
            'price' => 15.5
        ];
        $article = $articlesService->create($data);
        $this->assertNotNull($article, $articlesService->messages->first());
        $this->assertInstanceOf(Article::class, $article);
        $this->assertEquals($data['name'], $article->name);
        $this->assertEquals($data['description'], $article->description);
        $this->assertEquals($data['amount'], $article->amount);
        $this->assertEquals($data['price'], $article->price);
        $this->assertEquals($user->id, $article->user_id);
        $this->assertNotNull($article->user);
        $this->assertInstanceOf(User::class, $article->user);

    }

}
