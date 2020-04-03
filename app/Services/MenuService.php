<?php

namespace App\Services;

use App\Repositories\MenuRepository;
use App\Repositories\OtherMenuItemRepository;
use Illuminate\Http\Request;

class MenuService {

	public function __construct(
		MenuRepository $repository,
		MenuItemRepository $menuItemRepository
		) {
		$this->repository = $repository;
		$this->menuItemRepository = $menuItemRepository;
	}

	public function index($perPage) {
		return $this->repository->all($perPage);
	}

	public function getList() {
		return $this->repository->getList();
	}

	public function create($request) {
		if ($this->repository->checkRecord($request['description'])) {
            return response()->json([
                'success' => false,
                'message' => 'Record already exist'
            ])->setStatusCode(400);
        }
		$data = $this->repository->create($request);
		if ($request['items']) {
			$items = $request['items'];
			if(count($items['itemsToAdd'])) {
				foreach ($items['itemsToAdd'] as $itemsToAdd) {
					$menuItem = $this->menuItemRepository->findMenuItem($itemsToAdd['id'], $data->id );
					if(!$menuItem) {
						$data = ['menu_id' => $data->id];
						$this->menuItemRepository->update($itemsToAdd['id'], $data);
					}
				}
			}
		}
		return $data;
	}

	public function update($request, $id) {
		if ($request['items']) {
			$items = $request['items'];
			if(count($items['itemsToAdd'])) {
				foreach ($items['itemsToAdd'] as $itemsToAdd) {
					$menuItem = $this->menuItemRepository->findMenuItem($itemsToAdd['id'], $request['id']);
					if(!$menuItem) {
						$data = ['menu_id' => $request['id']];
						$this->menuItemRepository->update($itemsToAdd['id'], $data);
					}
				}
			}
	
			if(count($items['itemsToRemove'])) {
				foreach ($items['itemsToRemove'] as $itemsToRemove) {
					$menuItem = $this->menuItemRepository->findMenuItem($itemsToRemove['id'], $request['id']);
					if($menuItem) {
						$data = ['menu_id' => null];
						$this->menuItemRepository->update($itemsToRemove['id'], $data);
					}
				}
			}
		}
      return $this->repository->update($id, $request);
	}

	public function read($id) {
     return $this->repository->find($id);
	}

	public function delete($id) {
      return $this->repository->delete($id);
	}
}