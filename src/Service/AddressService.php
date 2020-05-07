<?php


namespace App\Service;


use Symfony\Component\HttpClient\HttpClient;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Contracts\HttpClient\Exception\ClientExceptionInterface;
use Symfony\Contracts\HttpClient\Exception\RedirectionExceptionInterface;
use Symfony\Contracts\HttpClient\Exception\ServerExceptionInterface;
use Symfony\Contracts\HttpClient\Exception\TransportExceptionInterface;

class AddressService
{
    const ADDRESS_PATH = 'https://nominatim.openstreetmap.org/search';
    /**
     * @var \Symfony\Contracts\HttpClient\HttpClientInterface
     */
    private $client;

    /**
     * AddressService constructor.
     */
    public function __construct()
    {
        $this->client = HttpClient::create();
    }

    public function find(Request $request)
    {
        $data = \json_decode($request->getContent(), true);

        $data['country'] = 'US';
        $data['format'] = 'json';

        try {
            $response = \json_decode(
                $this->client->request(
                    'GET',
                    self::ADDRESS_PATH, ['query' => $data])->getContent(),
                true
            );
        } catch (TransportExceptionInterface $e) {
            return [];
        } catch (ClientExceptionInterface $e) {
            return [];
        } catch (RedirectionExceptionInterface $e) {
            return [];
        } catch (ServerExceptionInterface $e) {
            return [];
        }

        return $response;
    }
}