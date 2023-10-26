<?php

namespace Front\Controller;

use Aio\CmsBundle\BusinessLogic\Content\Content\ContentManager;
use Aio\CmsBundle\BusinessLogic\Content\Content\ContentSearch;
use Aio\CmsBundle\BusinessLogic\Content\Hierarchy\ContentHierarchyFactory;
use Aio\CmsBundle\BusinessLogic\Content\Tree\TreeManager;
use Aio\CmsBundle\BusinessLogic\Navigation\NavigationSearch;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class DefaultController extends AbstractController
{
    #[Route('/', name: 'app_default_index')]
    public function index(TreeManager $treeManager, ContentManager $contentManager): Response
    {
        $search = new ContentSearch();
        $search->addOrderBy('dateFrom', 'desc');
        $search->setPageSize(2);
        $search->setTrees([$treeManager->findByNameKey('news')]);

        $news = $contentManager->search($search);

        $search = new ContentSearch();
        $search->setTrees([$treeManager->findByNameKey('sponsors')]);
        $search->setCategoriesFilters(['category' => [25]]);
        $search->addOrderBy('position', 'ASC');
        $sponsors = $contentManager->search($search);

        return $this->render('default/index.html.twig', ['news' => $news, 'sponsors' => $sponsors]);
    }

    #[Route('/contents/{id}/{slug}', name: 'app_default_content')]
    public function content(?string $id, ContentManager $contentManager, Request $request): Response
    {
        $content = $contentManager->findById((int) $id, $request->getLocale());

        if (!$content) {
            throw $this->createNotFoundException('Content not found');
        }

        return $this->render('default/content.html.twig', ['content' => $content]);
    }

    #[Route('/header', name: 'app_default_header')]
    public function header(Request $request, TreeManager $treeManager, ContentHierarchyFactory $contentHierarchyFactory): Response
    {
        $tree = $treeManager->findByNameKey('main');

        $search = new NavigationSearch();
        $search->addTree($tree);
        $search->clearStatuses();
        $search->addStatus(2);
        $search->setLanguage($request->getLocale());

        $navigation = $contentHierarchyFactory->buildHierarchy($search, false);

        return $this->render('default/partial/_header.html.twig', [
            'contents' => $navigation->getHierarchy(),
        ]);
    }

    #[Route('/footer', name: 'app_default_footer')]
    public function footer(Request $request, TreeManager $treeManager, ContentHierarchyFactory $contentHierarchyFactory, ContentManager $contentManager): Response
    {
        $tree = $treeManager->findByNameKey('footer');

        $search = new NavigationSearch();
        $search->addTree($tree);
        $search->clearStatuses();
        $search->addStatus(2);
        $search->setLanguage($request->getLocale());

        $navigation = $contentHierarchyFactory->buildHierarchy($search, false);

        $search = new ContentSearch();
        $search->setTrees([$treeManager->findByNameKey('sponsors')]);
        $search->setCategoriesFilters(['category' => [26, 27]]);
        $search->addOrderBy('position', 'ASC');
        $sponsors = $contentManager->search($search);

        return $this->render('default/partial/_footer.html.twig', [
            'contents' => $navigation->getContents(),
            'sponsors' => $sponsors,
        ]);
    }
}
