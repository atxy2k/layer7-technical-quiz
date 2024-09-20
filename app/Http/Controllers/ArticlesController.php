<?php namespace App\Http\Controllers;

use App\Http\Requests\Articles\AddArticleRequest;
use App\Http\Requests\Articles\ChangeArticleRequest;
use App\Models\Article;
use App\Services\ArticlesService;
use Illuminate\Support\Facades\Auth;

class ArticlesController extends Controller
{

    public function index()
    {
        $user = Auth::user();
        $articles = Article::where('user_id', $user->id)->get();
        return view('articles.index', compact('articles'));
    }

    public function add()
    {
        return view('articles.add');
    }

    public function store(AddArticleRequest $request, ArticlesService $service)
    {
        $article = $service->create($request->all());
        if(!is_null($article))
        {
            return redirect()->route('dashboard');
        }
        return redirect()->back()->withInput($request->all())->withErrors($service->messages);
    }

    public function show(int $id)
    {
        $article = Article::find($id);
        if(is_null($article)) return redirect()->route('dashboard');
        return view('articles.show', compact('article'));
    }

    public function change(int $id)
    {
        $article = Article::find($id);
        if(is_null($article)) return redirect()->route('dashboard');
        return view('articles.change', compact('article'));
    }

    public function storeChange(int $id, ChangeArticleRequest $request, ArticlesService $service)
    {
        $article = Article::find($id);
        if(is_null($article)) return redirect()->route('dashboard');
        if($service->change($id, $request->all()))
        {
            return redirect()->route('dashboard');
        }
        return redirect()->back()->withInput($request->all())->withErrors($service->messages);
    }

    public function delete(int $id, ArticlesService $service)
    {
        $article = Article::find($id);
        if(is_null($article)) return redirect()->route('dashboard');
        $service->delete($article->id);
        return redirect()->route('dashboard');
    }

}
