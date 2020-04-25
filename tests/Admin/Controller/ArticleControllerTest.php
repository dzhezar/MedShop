<?php


namespace App\Tests\Admin\Controller;


use App\Entity\Article;
use App\Entity\Language;
use App\Entity\User;
use Doctrine\ORM\EntityManagerInterface;
use Faker\Factory;
use Symfony\Bundle\FrameworkBundle\Routing\Router;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use Symfony\Component\BrowserKit\Cookie;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Security\Core\Authentication\Token\UsernamePasswordToken;

class ArticleControllerTest extends WebTestCase
{
    private $client = null;
    /**
     * @var EntityManagerInterface
     */
    private $entityManager;
    /**
     * @var Router
     */
    private $router;
    /**
     * @var \Faker\Generator
     */
    private $faker;
    /**
     * @var string
     */
    private $root_path;

    public function setUp()
    {
        $this->client = static::createClient();
        $kernel = self::bootKernel();

        $this->entityManager = $kernel->getContainer()
            ->get('doctrine')
            ->getManager();

        $this->router = $kernel->getContainer()
            ->get('router');

        $this->faker = Factory::create();

        $this->root_path = $kernel->getProjectDir();

    }

    public function testArticlesShow()
    {
        exec($this->root_path.'/load_fixtures.sh');
        $this->logIn();
        $this->client->request('GET', $this->router->generate('admin_article_index'));

        $this->assertSame(Response::HTTP_OK, $this->client->getResponse()->getStatusCode());
    }

    public function testArticleCreate()
    {
        $this->logIn();
        $this->client->request('GET', $this->router->generate('admin_article_create'));
        $photo = new UploadedFile(
            $this->root_path.'/public/admin/img/tooltips/short_description.png',
            'short_description.png',
            'image/png',
            null
        );
        $languages = Language::LANGUAGES_ARRAY;

        $fields = [
            'article_form[image]' => $photo,
        ];

        foreach ($languages as $language) {
            $language = strtoupper($language);
            $fields = array_merge(
                $fields,
                [
                    'article_form[isVisible]' => true,
                    'article_form[title' . $language . ']' => $this->faker->title,
                    'article_form[shortDescription' . $language . ']' => $this->faker->text(50),
                    'article_form[description' . $language . ']' => $this->faker->randomHtml(200),
                    'article_form[seoTitle' . $language . ']' => $this->faker->text(25),
                    'article_form[seoDescription' . $language . ']' => $this->faker->text(60),
                ]
            );
        }

        $this->client->submitForm('article_form_submit', $fields);

        $this->assertSame(Response::HTTP_FOUND, $this->client->getResponse()->getStatusCode());
    }

    public function testArticleUpdate()
    {
        if ($article = $this->entityManager->getRepository(Article::class)->findOneBy([])) {
            $id = $article->getId();
            $this->logIn();
            $this->client->request('GET', $this->router->generate('admin_article_update', ['id' => $id]));
            $languages = Language::LANGUAGES_ARRAY;

            $fields = [];

            foreach ($languages as $language) {
                $language = strtoupper($language);
                $fields = array_merge(
                    $fields,
                    [
                        'article_form[isVisible]' => true,
                        'article_form[title' . $language . ']' => $this->faker->title,
                        'article_form[shortDescription' . $language . ']' => $this->faker->text(50),
                        'article_form[description' . $language . ']' => $this->faker->randomHtml(200),
                        'article_form[seoTitle' . $language . ']' => $this->faker->text(25),
                        'article_form[seoDescription' . $language . ']' => $this->faker->text(60),
                    ]
                );
            }

            $this->client->submitForm('article_form_submit', $fields);

            $this->assertSame(Response::HTTP_FOUND, $this->client->getResponse()->getStatusCode());

            /** @var Article $article */
            $article = $this->entityManager->getRepository(Article::class)->findOneBy(['id' => $id]);
            $this->assertNotEmpty($article->getImage());
        }
    }

    public function testArticleRemove()
    {
        if ($article = $this->entityManager->getRepository(Article::class)->findOneBy([])) {
            $id = $article->getId();
            $this->logIn();
            $this->client->request('GET', $this->router->generate('admin_article_remove', ['id' => $id]));
            $this->assertSame(Response::HTTP_FOUND, $this->client->getResponse()->getStatusCode());
            $this->assertSame(null, $this->entityManager->getRepository(Article::class)->findOneBy(['id' => $id]));
        }
    }

    private function logIn()
    {
        $session = self::$container->get('session');

        /** @var User $user */
        $user = $this->entityManager->getRepository(User::class)->findOneBy([]);

        $firewallName = 'main';
        $firewallContext = 'main';
        $token = new UsernamePasswordToken($user, null, $firewallName, $user->getRoles());
        $session->set('_security_' . $firewallContext, serialize($token));
        $session->save();

        $cookie = new Cookie($session->getName(), $session->getId());
        $this->client->getCookieJar()->set($cookie);
    }
}