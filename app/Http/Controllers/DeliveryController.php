<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\City;
use App\Models\Province;
use App\Models\Wards;
use App\Models\Feeship;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Session;
session_start();

class DeliveryController extends Controller
{
    //
    public function delivery(Request $request){

        $city = City::orderBy('city_id','desc')->get();
        return view('admin.delivery.add', compact('city'));
    }

    // Chọn địa chỉ để thêm phí vận chuyển
    public function select_delivery(Request $request){
        $data = $request->all();
        if($data['action']){
            $output = '';
            if($data['action']=='city'){
                $select_province = Province::where('city_id',$data['dd_id'])->orderby('qh_id','asc')->get();
                $output.='<option>---Chọn quận, huyện---</option>';
                foreach($select_province as $key => $province){
                    $output.= '<option value="'.$province->qh_id.'">'.$province->qh_name.'</option>';
                }
            }else{
                $select_wards = Wards::where('qh_id',$data['dd_id'])->orderby('xa_id','asc')->get();
                $output.='<option>---Chọn xã, phường, thị trấn---</option>';
                foreach($select_wards as $key => $ward){
                    $output.= '<option value="'.$ward->xa_id.'">'.$ward->xa_name.'</option>';
                }
            }
        }
        echo $output;
    }

    // Thêm phí vận chuyển 
    public function add_delivery(Request $request){
        $data = $request->all();
        $fee_ship = new Feeship();
        $fee_ship->fee_city_id = $data['city'];
        $fee_ship->fee_qh_id = $data['province'];
        $fee_ship->fee_xa_id = $data['wards'];
        $fee_ship->fee_freeship = $data['fee_ship'];
        $fee_ship->save();
        Session::put('message','Thêm phí vận chuyển thành công');
        return Redirect::to('/delivery');
    }

    // Lấy dữ liệu ra bằng Ajax
    public function all_delivery(){
        $feeship = Feeship::orderBy('fee_id','desc')->get();
        $output = '';
        $output.='
            <div class="table-responsive">
                <table class="table table-bordered">
                    <thread>
                        <tr>
                            <th>Tên tỉnh, thành phố</th>
                            <th>Tên quận, huyện</th>
                            <th>Tên xã, phường, thị trấn</th>
                            <th>Phí vận chuyển (VND)</th>
                        </tr> 
                    </thread>
                    <tboby>';
                        foreach($feeship as $key => $val){
                            $output.='
                                <tr>
                                    <td>'.$val->city->city_name.'</td>
                                    <td>'.$val->province->qh_name.'</td>
                                    <td>'.$val->wards->xa_name.'</td>
                                    <td contenteditable data-feeship_id="'.$val->fee_id.'" class="fee_feeship_edit">'.number_format($val->fee_freeship,0,',','.').'</td>
                                </tr>';
                        }
                        
        $output.='  </tboby>
                </table>
            </div>';
        echo $output;
    }

    // Cập nhật phí vận chuyển
    public function update_delivery(Request $request){
        $data = $request->all();
        $fee_ship = Feeship::find($data['feeship_id']);
        $fee_value = rtrim($data['fee_value'],'.');
        $fee_ship->fee_freeship = $fee_value;
        $fee_ship->save();
        Session::put('message','Thêm phí vận chuyển thành công');
        return Redirect::to('/delivery');
    }
}
