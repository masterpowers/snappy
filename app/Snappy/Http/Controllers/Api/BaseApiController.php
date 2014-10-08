<?php namespace Snappy\Http\Controllers\Api;

use Input;
use Response;
use Controller;
use League\Fractal\Manager;
use League\Fractal\Resource\Item;
use League\Fractal\Resource\Collection;
use League\Fractal\Serializer\JsonApiSerializer;

class BaseApiController extends Controller
{
    const CODE_WRONG_ARGS = 'GEN-FUBARGS';
    const CODE_NOT_FOUND = 'GEN-LIKETHEWIND';
    const CODE_INTERNAL_ERROR = 'GEN-AAAGGH';
    const CODE_UNAUTHORIZED = 'GEN-MAYBGTFO';
    const CODE_FORBIDDEN = 'GEN-GTFO';
    const CODE_INVALID_MIME_TYPE = 'GEN-UMWUT';

    protected $statusCode = 200;

    /**
     * Create a new base api controller instance.
     * 
     * @return void
     */
    public function __construct(Manager $fractal)
    {
        $this->fractal = $fractal;
        //$this->fractal->setSerializer(new JsonApiSerializer);
        $this->fractal->parseIncludes(Input::get('include', []));
    }

    /**
     * Return the status code.
     * 
     * @return int
     */
    public function getStatusCode()
    {
        return $this->statusCode;
    }

    /**
     * Set the status code.
     * 
     * @param  int  $statusCode
     * @return self
     */
    public function setStatusCode($statusCode)
    {
        $this->statusCode = $statusCode;

        return $this;
    }

    /**
     * Build HTTP response with a resource collection.
     * 
     * @param  mixed  $collection
     * @param  mixed  $transformer
     * @return Response
     */
    public function respondWithCollection($collection, $transformer, $key = null)
    {
        $resource = new Collection($collection, $transformer, $key);

        $rootScope = $this->fractal->createData($resource);

        return $this->respondWithArray($rootScope->toArray());
    }

    /**
     * Build HTTP response with a resource item.
     * 
     * @param  mixed  $item
     * @param  mixed  $transformer
     * @return Response
     */
    public function respondWithItem($item, $transformer, $key = null)
    {
        $resource = new Item($item, $transformer, $key);

        $rootScope = $this->fractal->createData($resource);

        return $this->respondWithArray($rootScope->toArray());
    }

    /**
     * Build HTTP response with error message.
     * 
     * @param  string  $message
     * @return Response
     */
    public function respondWithError($message, $errorCode)
    {
        $statusCode = $this->statusCode;

        if ($statusCode === 200)
        {
            trigger_error("You better have a really good reason for erroring on a 200", E_USER_WARNING);
        }

        $error = [
            'error' => [
                'code' => $errorCode,
                'http_code' => $statusCode,
                'message' => $message
            ]
        ];

        return $this->respondWithArray($error);
    }

    /**
     * Build HTTP response from an array.
     * 
     * @param  array  $array
     * @param  array  $headers
     * @return Response
     */
    public function respondWithArray(array $array, array $headers = array())
    {
        $mimeTypeRaw = Input::server('HTTP_ACCEPT', '*/*');

        // If its empty or has */* then default to JSON
        if ($mimeTypeRaw === '*/*') {
            $mimeType = 'application/json';
        } else {
            // You will probably want to do something intelligent with charset if provided.
            // This chapter just assumes UTF8 everything everywhere.
            $mimeParts = (array) explode(';', $mimeTypeRaw);
            $mimeType = strtolower($mimeParts[0]);
        }

        switch ($mimeType) {
            case 'application/json':
                $contentType = 'application/json';
                $content = json_encode($array);
                break;

            case 'text/html,application/xhtml+xml,application/xml':
                $contentType = 'application/json';
                $content = json_encode($array);
                break;

            case 'application/x-yaml':
                $contentType = 'application/x-yaml';
                $dumper = new YamlDumper();
                $content = $dumper->dump($array, 2);
                break;

            default:
                $contentType = 'application/json';
                $content = json_encode([
                    'error' => [
                        'code' => static::CODE_INVALID_MIME_TYPE,
                        'http_code' => 415,
                        'message' => sprintf('Content of type %s is not supported.', $mimeType),
                    ]
                ]);
        }

        $response = Response::make($content, $this->statusCode, $headers);
        $response->header('Content-Type', $contentType);

        return $response;
    }

    /**
     * Generates a Response with a 403 HTTP header and a given message.
     *
     * @return  Response
     */
    public function errorForbidden($message = 'Forbidden')
    {
        return $this->setStatusCode(403)->respondWithError($message, self::CODE_FORBIDDEN);
    }

    /**
     * Generates a Response with a 500 HTTP header and a given message.
     *
     * @return  Response
     */
    public function errorInternalError($message = 'Internal Error')
    {
        return $this->setStatusCode(500)->respondWithError($message, self::CODE_INTERNAL_ERROR);
    }
    
    /**
     * Generates a Response with a 404 HTTP header and a given message.
     *
     * @return  Response
     */
    public function errorNotFound($message = 'Resource Not Found')
    {
        return $this->setStatusCode(404)->respondWithError($message, self::CODE_NOT_FOUND);
    }

    /**
     * Generates a Response with a 401 HTTP header and a given message.
     *
     * @return  Response
     */
    public function errorUnauthorized($message = 'Unauthorized')
    {
        return $this->setStatusCode(401)->respondWithError($message, self::CODE_UNAUTHORIZED);
    }

    /**
     * Generates a Response with a 400 HTTP header and a given message.
     *
     * @return  Response
     */
    public function errorWrongArgs($message = 'Wrong Arguments')
    {
        return $this->setStatusCode(400)->respondWithError($message, self::CODE_WRONG_ARGS);
    }
}
