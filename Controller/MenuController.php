<?php

namespace Extension\Menu\Controller;

use BinCMS\Annotations\Route;
use BinCMS\Converter\ConverterService;
use BinCMS\FilterBuilder\FilterBuilder;
use BinCMS\FilterBuilder\FilterType\ODM\EqualsFilterType;
use BinCMS\FilterBuilder\FilterType\ODM\StringFilterType;
use BinCMS\Pagination\PaginationODM;
use Extension\Menu\Document\Menu;
use Extension\Menu\Form\MenuForm;
use Extension\Menu\Repository\Interfaces\MenuRepositoryInterface;
use Silex\Application;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Validator\Validator;

class MenuController
{
    /**
     * @var \Extension\Menu\Repository\Interfaces\MenuRepositoryInterface
     */
    private $menuRepository;
    /**
     * @var \BinCMS\Converter\ConverterService
     */
    private $converterService;
    /**
     * @var \Symfony\Component\Validator\Validator
     */
    private $validator;

    public function __construct(MenuRepositoryInterface $menuRepository, ConverterService $converterService, Validator $validator)
    {
        $this->menuRepository = $menuRepository;
        $this->converterService = $converterService;
        $this->validator = $validator;
    }

    /**
     * @Route(pattern="/", method="GET")
     * @param Application $app
     * @param Request $request
     * @return \Symfony\Component\HttpFoundation\JsonResponse
     */
    public function mainAction(Application $app, Request $request)
    {
        $parent = null;
        $pagination = null;
        $page = $request->get('page', 1);
        $perPage = $request->get('per_page', null);
        $parentId = $request->get('parent_id', null);
        $direct = filter_var($request->get('direct', true), \FILTER_VALIDATE_BOOLEAN);
        $isDetailed = filter_var($request->get('is_detailed', true), \FILTER_VALIDATE_BOOLEAN);

        if(null !== $parentId) {
            $parent = $this->menuRepository->find($parentId);
        }

        if(null !== $perPage) {
            $pagination = new PaginationODM($page, $perPage);
        }

        $filterBuilder = new FilterBuilder();
        $filterBuilder->add('text', 'title', new StringFilterType());
        $filterBuilder->add('alias', 'alias', new EqualsFilterType());
        $filterBuilder->bindRequest($request);

        $result = $this->menuRepository->findAllWithFilter($parent, $filterBuilder, $pagination, $direct);

        return $app->json($this->converterService->convert($result, $isDetailed));
    }

    /**
     * @Route(pattern="/", method="POST")
     * @param Application $app
     * @param Request $request
     * @return \Symfony\Component\HttpFoundation\JsonResponse
     */
    public function createAction(Application $app, Request $request)
    {
        $menuForm = new MenuForm();
        $menuForm->bindRequest($request);

        $errors = $this->validator->validate($menuForm);

        if (sizeof($errors) > 0) {
            return $app->json($this->converterService->convert($errors), 400);
        }

        $menu = new Menu();

        $parent = null;
        if(null !== $menuForm->parent) {
            $parent = $this->menuRepository->find($menuForm->parent);
        }

        $menu->setParent($parent);
        $menu->setTitle($menuForm->title);
        $menu->setUrl($menuForm->url);
        $menu->setPosition($menuForm->position);
        $menu->setAlias($menuForm->alias);

        $this->menuRepository->saveEntity($menu);

        return $app->json(
            $this->converterService->convert($menu)
        );
    }


    /**
     * @Route(pattern="/{id}", method="PUT")
     * @param Application $app
     * @param Request $request
     * @param $id
     * @return \Symfony\Component\HttpFoundation\JsonResponse
     */
    public function updateAction(Application $app, Request $request, $id)
    {
        $menuForm = new MenuForm();
        $menuForm->bindRequest($request);

        $errors = $this->validator->validate($menuForm);

        if (sizeof($errors) > 0) {
            return $app->json($this->converterService->convert($errors), 400);
        }

        $menu = $this->menuRepository->find($id);

        if(null == $menu) {
            return $app->abort(404);
        }

        $parent = null;
        if(null !== $menuForm->parent) {
            $parent = $this->menuRepository->find($menuForm->parent);
        }

        $menu->setParent($parent);
        $menu->setTitle($menuForm->title);
        $menu->setUrl($menuForm->url);
        $menu->setPosition($menuForm->position);
        $menu->setAlias($menuForm->alias);

        $this->menuRepository->saveEntity($menu);

        return $app->json(
            $this->converterService->convert($menu)
        );
    }

    /**
     * @Route(pattern="/{id}", method="GET")
     * @param Application $app
     * @param Request $request
     * @param $id
     * @return \Symfony\Component\HttpFoundation\JsonResponse
     */
    public function getAction(Application $app, Request $request, $id)
    {
        $isDetailed = filter_var($request->get('is_detailed', false), \FILTER_VALIDATE_BOOLEAN);

        $menu = $this->menuRepository->find($id);
        if(null === $menu) {
            $app->abort(404);
        }

        return $app->json($this->converterService->convert($menu, $isDetailed));
    }

    /**
     * @Route(pattern="/{id}", method="DELETE")
     * @param Application $app
     * @param $id
     * @return \Symfony\Component\HttpFoundation\JsonResponse
     */
    public function removeAction(Application $app, $id)
    {
        $menu = $this->menuRepository->find($id);
        if(null === $menu) {
            $app->abort(404);
        }

        $this->menuRepository->removeAndFlushEntity($menu);

        return $app->abort(204);
    }

} 