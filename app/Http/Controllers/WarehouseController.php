<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use App\UseCases\Import\ImportUseCase;
use App\UseCases\ImportDetail\ImportDetailUseCase;

class WarehouseController extends Controller
{
    protected $importUseCase;
    protected $importDetailUseCase;

    public function __construct(ImportUseCase $importUseCase, ImportDetailUseCase $importDetailUseCase)
    {
        $this->importUseCase = $importUseCase;
        $this->importDetailUseCase = $importDetailUseCase;
    }

    public function index(Request $request)
    {   
        try {
            $postInput = file_get_contents('php://input');
            $response = json_decode($postInput, true);
            $importDetail = $response['import_detail'];

            if(empty($importDetail)) {
                return response()->json([
                    'code' => 400,
                    'message' => 'Bad Request',
                ], 400);
            }

            unset($response['import_detail']);

            $response['import_date'] = date("Y-m-d H:i:s");

            $this->importUseCase->create($response);

            $lastIndex = $this->importUseCase->getLastIndex()['id'];

            foreach ($importDetail as $key => $data) {
                unset($importDetail[$key]['id']);
            }

            foreach ($importDetail as $data) {
                $data['import_id'] = $lastIndex;
                $this->importDetailUseCase->create($data);
            }

            return response()->json([
                'code' => 201,
                'message' => 'Recorded',
            ], 201);
            
        } catch (\Exception $e) {
            return response()->json(['code'=> 500,'error' => $e->getMessage()], 500);
        }
    }

    public function show($id)
    {
      
    }

    public function store(Request $request)
    {
      
    }

    public function update(Request $request, $id)
    {
        
    }

    public function destroy($id)
    {
       
       
    }
}