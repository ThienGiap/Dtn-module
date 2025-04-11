<?php

namespace Dtn\Office\Controller\Index;

use Magento\Framework\App\Action\Action;
use Magento\Framework\App\Action\Context;
use Magento\Framework\App\Action\HttpGetActionInterface;
use Magento\Framework\App\Action\HttpPostActionInterface;
use Magento\Framework\Controller\Result\JsonFactory;
use Laminas\Http\Client;
use Laminas\Http\Request;

class Index extends Action implements HttpGetActionInterface, HttpPostActionInterface
{
    protected $resultJsonFactory;

    public function __construct(Context $context, JsonFactory $resultJsonFactory)
    {
        parent::__construct($context);
        $this->resultJsonFactory = $resultJsonFactory;
    }

    public function execute()
    {
        $apiKey = $this->_objectManager->get('Magento\Framework\App\DeploymentConfig')
            ->get('gemini_api_key');

        $client = new Client(
            'https://generativelanguage.googleapis.com/v1beta/models/gemini-2.0-flash:generateContent?key=' . $apiKey,
            ['adapter' => 'Laminas\Http\Client\Adapter\Curl']
        );

        $client->setMethod(Request::METHOD_POST);
        $client->setHeaders([
            'Content-Type' => 'application/json',
        ]);

        $question = $this->getRequest()->getParam('question');

        $client->setRawBody(json_encode([
            'contents' => [
                [
                    'parts' => [
                        ['text' => $question]
                    ]
                ]
            ]
        ]));

        try {
            $response = $client->send();
            $body = json_decode($response->getBody(), true);

            return $this->resultJsonFactory->create()->setData([
                'success' => true,
                'answer' => $body['candidates'][0]['content']['parts'][0]['text'] ?? 'Error.'
            ]);
        } catch (\Exception $e) {
            return $this->resultJsonFactory->create()->setData([
                'success' => false,
                'error' => $e->getMessage()
            ]);
        }
    }
}
