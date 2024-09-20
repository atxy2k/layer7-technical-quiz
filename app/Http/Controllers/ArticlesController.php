<?php namespace App\Http\Controllers;

use App\Http\Requests\Articles\AddArticleRequest;
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

}
