<?php
namespace App\Controller;

use Slim\Container;
use Slim\Http\Request;
use Slim\Http\Response;

class Controller
{
    private $app;

    public function __construct(Container $app)
    {
        $this->app = $app;
    }

    public function index(Request $request, Response $response)
    {
        $url = null;

        if ($request->isPost()) {
            $sessionId = $this->app->videoChatService->createSession();
            $url =  $request->getUri()->getBaseUrl() . "/rooms/{$sessionId}";
        }

        return $this->app->view->render($response, 'index', [
        'url' => $url,
    ]);
    }

    public function room(Request $request, Response $response, $params)
    {
        $sessionId = $params['sessionId'];

        $token = $this->app->videoChatService->getToken($sessionId);

        $key = $this->app->videoChatService->getKey();

        $jsonData = [
            'sessionId' => $sessionId,
            'token' => $token,
            'key' => $key,
        ];

        return $this->app->view->render($response, 'room', [
            'params' => json_encode($jsonData, JSON_HEX_TAG | JSON_HEX_AMP | JSON_HEX_APOS | JSON_HEX_QUOT),
        ]);
    }
}
