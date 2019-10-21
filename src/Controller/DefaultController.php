<?php

namespace App\Controller;

use Aio\CmsBundle\BusinessLogic\Content\Content\ContentManager;
use Aio\CmsBundle\BusinessLogic\Content\Hierarchy\ContentHierarchyFactory;
use Aio\CmsBundle\BusinessLogic\Content\Tree\TreeManager;
use Aio\CmsBundle\BusinessLogic\Navigation\NavigationSearch;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class DefaultController extends AbstractController
{
    #[Route('/', name: 'app_index')]
    #[Route('/contents/{slug}-{id}', name: 'app_index_content')]
    public function index(?string $id, ContentManager $contentManager, TreeManager $treeManager, ContentHierarchyFactory $contentHierarchyFactory, Request $request): Response
    {
        $id = $id ?? 1;
        $content = $contentManager->findById($id, $request->getLocale());

        $tree = $treeManager->findByNameKey('main');

        $search = new NavigationSearch();
        $search->addTree($tree);
        $search->setLanguage($request->getLocale());

        $hierarchy = $contentHierarchyFactory->buildHierarchy($search, false);


        if (!$content) {
            throw $this->createNotFoundException('Content not found');
        }

        return $this->render('default/index.html.twig', ['content' => $content]);
    }

    #[Route('/test', name: 'app_test')]
    public function test(): Response
    {
        return $this->render('default/test.html.twig');
    }
}
