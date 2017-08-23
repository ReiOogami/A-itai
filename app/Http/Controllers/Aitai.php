<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App;

class Aitai extends Controller
{
    public function matching(Request $request)
    {
        //リクエストの値を変数に格納
        $name = $request->name;
        $reqLatitude = $request->latitude;
        $reqLongitude = $request->longitude;    

        //DBに自分の位置情報を登録(自分の情報があれば更新、無ければ作成)
        if(App\Waiting::where('name',$name)->exists())
        {
            App\Waiting::where('name',$name)->update(['latitude' => $reqLatitude,'longitude' => $reqLongitude]);
        }
        else
        {
            App\Waiting::create([
                'name' => $name,
                'latitude' => $reqLatitude,
                'longitude' => $reqLongitude
            ]);
        }

        //他のユーザーの位置情報を取得(自分の位置情報は省く)
        $data = App\Waiting::where('name','!=',$name)->get();

        //距離計算の処理スタート(自分から{100m}以内にユーザーが居た場合trueをreturnして終了。)        
        foreach($data as $d)
        {
            // 緯度経度をラジアンに変換
            $radLat1 = $reqLatitude * M_PI / 180.0; // 緯度１
            $radLon1 = $reqLongitude * M_PI / 180.0; // 経度１
            $radLat2 = $d->latitude * M_PI / 180.0; // 緯度２
            $radLon2 = $d->longitude * M_PI / 180.0; // 経度２

            // 平均緯度
            $radLatAve = ($radLat1 + $radLat2) / 2.0;

            // 緯度差
            $radLatDiff = $radLat1 - $radLat2;

            // 経度差算
            $radLonDiff = $radLon1 - $radLon2;

            $sinLat = sin($radLatAve);

            //計算
            $temp = 1.0 - 0.00669438 * ($sinLat*$sinLat);
            $meridianRad = 6335439.0 / sqrt($temp*$temp*$temp); // 子午線曲率半径
            $dvrad = 6378137.0 / sqrt($temp); // 卯酉線曲率半径
            
            $t1 = $meridianRad * $radLatDiff;
            $t2 = $dvrad * Cos($radLatAve) * $radLonDiff;
            $dist = sqrt(($t1*$t1) + ($t2*$t2));

            if(100 > $dist)
            {
                return response()->json('true');
            }
        }

        //上の処理でtrueがreturnされなかった（{100m}以内にユーザーが居なかった)場合はfalseをreturnして終了）
        return response()->json('false');
    }

    public function demo()
    {
        return response()->json('true');
    }
    
    public function getAllUser(Request $request)
    {
        $name = $request->name;

        $userData = App\Waiting::where('name','!=',$name)->get();
    
        return response()->json($userData);
    }
}
