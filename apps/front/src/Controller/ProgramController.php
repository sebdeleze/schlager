<?php

namespace Front\Controller;

use Aio\CmsBundle\BusinessLogic\Content\Content\ContentManager;
use Aio\CmsBundle\BusinessLogic\Content\Content\ContentSearch;
use Aio\CmsBundle\BusinessLogic\Content\Tree\TreeManager;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/programmation')]
class ProgramController extends AbstractController
{
    #[Route('', name: 'app_program_index')]
    public function index(TreeManager $treeManager, ContentManager $contentManager): Response
    {
        $search = new ContentSearch();
        $search->addOrderBy('id', 'asc');
        $search->setTrees([$treeManager->findByNameKey('artists')]);

        $contents = $contentManager->search($search);

        return $this->render('program/index.html.twig', [
            'contents' => $contents,
        ]);
    }
}
