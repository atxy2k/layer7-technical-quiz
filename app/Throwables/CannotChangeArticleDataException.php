<?php namespace App\Throwables;

use Exception;

class CannotChangeArticleDataException extends Exception
{
    protected $message = 'No tienes permitido cambiar los datos de éste artículo';
}
