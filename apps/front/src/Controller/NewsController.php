<?php

namespace Front\Controller;

use Aio\CmsBundle\BusinessLogic\Content\Content\ContentManager;
use Aio\CmsBundle\BusinessLogic\Content\Content\ContentSearch;
use Aio\CmsBundle\BusinessLogic\Content\Tree\TreeManager;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/news')]
class NewsController extends AbstractController
{
    #[Route('', name: 'app_news_index')]
    public function index(TreeManager $treeManager, ContentManager $contentManager): Response
    {
        $search = new ContentSearch();
        $search->setTrees([$treeManager->findByNameKey('news')]);

        $contents = $contentManager->search($search);

        return $this->render('news/index.html.twig', [
            'contents' => $contents,
        ]);
    }
}
