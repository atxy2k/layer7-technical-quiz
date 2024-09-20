<?php namespace App\Throwables;

use Exception;

class YouNeedToBeLoggedForCreatedArticles extends Exception
{
    protected $message = 'Necesitas haber iniciado sesión para crear un artículo';
}
