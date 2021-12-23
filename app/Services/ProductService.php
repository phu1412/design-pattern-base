<?php
namespace App\Services;

use App\Repositories\Interfaces\ProductInterface;
use Illuminate\Support\Facades\Request;

class ProductService 
{
    private $productRepository;
    public function __construct(ProductInterface $productRepository)
    {
        $this->productRepository = $productRepository;
    }
    public function all(Request $request)
    {
        $params['paginate'] = [
            'per_page' => 10,
            'current_paged' => request('page'),
        ];

        return $this->productRepository->advancedGet($params);
    }

    /**
     * [getProduct description].
     *
     * @param [type] $id [description]
     *
     * @return [type] [description]
     */
    public function getProduct($id)
    {
        return $this->productRepository->findById($id);
    }

    /**
     * [createProduct description].
     *
     * @param Request $request [description]
     *
     * @return [type] [description]
     */
    public function createProduct(Request $request)
    {
        $data = $request->only('name');

        return $this->productRepository->create($data);
    }

    /**
     * [updateProduct description].
     *
     * @param [type]  $id      [description]
     * @param Request $request [description]
     *
     * @return [type] [description]
     */
    public function updateProduct($id, Request $request)
    {
        $data = $request->only('name');

        return $this->productRepository->update(['id' => $id], $data);
    }

    /**
     * [deleteProduct description].
     *
     * @param [type] $id [description]
     *
     * @return [type] [description]
     */
    public function deleteProduct($id)
    {
        return $this->productRepository->deleteBy(['id' => $id]);
    }

}