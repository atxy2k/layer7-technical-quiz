<?php

namespace App\Services;

use App\Models\Article;
use App\Throwables\ArticleCouldNotBeCreatedException;
use App\Throwables\ArticleNotFoundException;
use App\Throwables\CannotChangeArticleDataException;
use App\Throwables\YouNeedToBeLoggedForCreatedArticles;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\MessageBag;
use Throwable;
use Exception;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class ArticlesService
{
    public const ADD_VALIDATION_RULES = [
        'name' => 'required',
        'description' => 'required',
        'amount' => 'required|integer',
        'price'  => 'required|numeric'
    ];
    public const CHANGE_VALIDATION_RULES = [
        'name' => 'required',
        'description' => 'required',
        'amount' => 'required|integer',
        'price'  => 'required|numeric'
    ];
    public function __construct(public readonly MessageBag $messages){}

    private function pushError(string $message) : void
    {
        $this->messages->add('error', $message);
    }
    public function create(array $data) : ?Article
    {
        $return = null;
        try
        {
            DB::beginTransaction();
            $validator = Validator::make($data, ArticlesService::ADD_VALIDATION_RULES);
            throw_if($validator->fails(), new Exception($validator->errors()->first()));
            throw_if(is_null(Auth::id()), YouNeedToBeLoggedForCreatedArticles::class);
            $data['user_id'] = Auth::id();
            $record = Article::create($data);
            throw_if(is_null($record), ArticleCouldNotBeCreatedException::class);
            DB::commit();
            $return = $record;
        }
        catch (Throwable $e)
        {
            DB::rollBack();
            $this->pushError($e->getMessage());
        }
        return $return;
    }

    public function change(int $id, array $data) : bool
    {
        $return = false;
        try
        {
            DB::beginTransaction();
            $article = Article::find($id);
            throw_if(is_null($article), ArticleNotFoundException::class);
            throw_if(is_null(Auth::id()), YouNeedToBeLoggedForCreatedArticles::class);
            throw_if(Auth::id() !== $article->user_id, CannotChangeArticleDataException::class);
            $validator = Validator::make($data, ArticlesService::CHANGE_VALIDATION_RULES);
            throw_unless($validator->passes(), new Exception($validator->errors()->first()));
            $article->update($data);
            DB::commit();
            $return = true;
        }
        catch (Throwable $e)
        {
            DB::rollBack();
            $this->pushError($e->getMessage());
        }
        return $return;
    }

    public function delete(int $id) : bool
    {
        $return = false;
        try
        {
            DB::beginTransaction();
            $article = Article::find($id);
            throw_if(is_null($article), ArticleNotFoundException::class);
            throw_if(Auth::id() !== $article->user_id, CannotChangeArticleDataException::class);
            $article->delete();
            DB::commit();
            $return = true;
        }
        catch (Throwable $e)
        {
            DB::rollBack();
            $this->pushError($e->getMessage());
        }
        return $return;
    }

}
