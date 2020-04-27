<?php

    class HomeController extends BaseController
    {

        public function index()
        {
            return View::make('index');
        }

        protected function search()
        {
            try {
                $validator = Validator::make(\Illuminate\Support\Facades\Input::all(),
                    ['txID' => ['required', 'size:64']]);

                if ($validator->fails()) {
                    $messages = $validator->messages();
                    return Response::json(['status' => $messages->first('txID'), 'code' => 1, 'data' => []]);
                }

                $txID = \Illuminate\Support\Facades\Input::get('txID');

                $data = (new BlockChainConnector())->getData($txID);
                if ($data == NULL) {
                    return Response::json(['status' => 'Transakcija ne obstaja.', 'code' => 1, 'data' => []]);
                }
                return Response::json(['status' => 'OK', 'code' => 2, 'data' => $data]);
            } catch (Exception $e) {
                return Response::json(['status' => 'Prišlo je do neželjene napake.', 'code' => 1, 'data' => []]);
            }

        }

    }
