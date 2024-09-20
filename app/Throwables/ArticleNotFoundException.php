<?php namespace App\Throwables;
use Exception;
class ArticleNotFoundException extends Exception
{
    protected $message = 'Ocurrió un error al localizar el elemento seleccionado';
}
