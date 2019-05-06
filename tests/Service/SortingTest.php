<?php
/**
 * Created by PhpStorm.
 * User: Halyna_Mecherzhak
 * Date: 4/9/2019
 * Time: 1:33 PM
 */

namespace App\Tests\Service;

use App\Service\Sorting;
use PHPUnit\Framework\TestCase;
use App\Entity\Article;
use App\Controller\ArticleController;
use Doctrine\Common\Persistence\ObjectManager;
use Doctrine\Common\Persistence\ObjectRepository;


class SortingTest extends TestCase
{
//    public function testAdd()
//    {
//        $calculator = new Sorting();
//        $result = $calculator->add(30, 12);
//
//        $this->assertEquals(42, $result);
//    }

    public  function  testCountArticle(){
        $article= new Article();
        $article->setTitle('ahahhhahhsdhasas');
        $article->setBody('vnmbxmcvmcv');

        $articleRepository = $this->createMock(ObjectRepository::class);

        $articleRepository->expects($this->any())
            ->method('find')
            ->willReturn($article);

        $objectManager = $this->createMock(ObjectManager::class);

        $objectManager->expects($this->any())
            ->method('getRepository')
            ->willReturn($articleRepository);

        $salaryCalculator = new ArticleController($objectManager);
        $this->assertEquals(1, $salaryCalculator->countArticles());

    }
}