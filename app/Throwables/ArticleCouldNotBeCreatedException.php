<?php namespace App\Throwables;

use Exception;

class ArticleCouldNotBeCreatedException extends Exception
{
    protected $message = 'Ocurrió un error al intentar registrar el artículo';
}
