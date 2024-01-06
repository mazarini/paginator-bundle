<?php

namespace App\DataFixtures;

use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use App\Entity\Category;
use App\Entity\Article;

class AppFixtures extends Fixture
{
    private ObjectManager $manager;
    public function load(ObjectManager $manager): void
    {
        $this->manager = $manager;
        for ($i = 1; $i < 10; $i++) {
            $this->loadCategory($i);
        }
        $manager->flush();
    }

    private function loadCategory(int $i)
    {
        $category = new Category();
        $category->setLabel(sprintf('Category %s', $i));
        for ($j = 1; $j < 10 * $i; $j++) {
            $this->loadArticle($category, $i, $j);
        }
        $this->manager->persist($category);
    }
    private function loadArticle(Category $category, int $i, int $j)
    {
        $article = new Article();
        $article->setLabel(sprintf('Article %s / %04s', $i, $j));
        $article->setCategory($category);
        $this->manager->persist($article);
    }

}
