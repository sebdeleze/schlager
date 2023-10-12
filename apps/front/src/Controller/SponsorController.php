<?php

namespace Front\Controller;

use Aio\CmsBundle\BusinessLogic\Content\Content\ContentManager;
use Aio\CmsBundle\BusinessLogic\Content\Content\ContentSearch;
use Aio\CmsBundle\BusinessLogic\Content\Tree\TreeManager;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/sponsors')]
class SponsorController extends AbstractController
{
    #[Route('/{id}', name: 'app_sponsor_index')]
    public function index(string $id, Request $request, TreeManager $treeManager, ContentManager $contentManager): Response
    {
        $content = $contentManager->findById((int) $id, $request->getLocale());

        $search = new ContentSearch();
        $search->addOrderBy('position', 'asc');
        $search->setTrees([$treeManager->findByNameKey('sponsors_categories')]);
        $categories = $contentManager->search($search);

        $search = new ContentSearch();
        $search->setTrees([$treeManager->findByNameKey('sponsors')]);
        $sponsors = $contentManager->search($search);

        $categories = array_map(function($item) use ($sponsors) {
            $sponsors = array_filter($sponsors, function($sponsor) use ($item) {
                return $sponsor->getProperty('category')[0] === $item->getId();
            });

            return [
                'category' => $item,
                'sponsors' => $sponsors,
            ];
        }, $categories);

        return $this->render('sponsor/index.html.twig', [
            'content' => $content,
            'categories' => $categories,
        ]);
    }
}
