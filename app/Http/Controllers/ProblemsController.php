<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ProblemsController extends Controller
{

    public function ExceptFives(Request $request)
    {
        $start_number = $request->start;
        $end_number = $request->end;
        if ($start_number >= $end_number)
        {
            return response()->json(['stat'=>200,'result'=>'end number must be greater than start number']);
        }
        else
        {
            $loop = $end_number - $start_number;
            $result = 0;
            $val = $start_number;
            for($i =0 ; $i <$loop+1 ; $i++)
            {
                if(!str_contains(strval($val), '5'))
                {
                    $result=$result+1;
                }
                $val=$val+1;
            }
            return response()->json(['stat'=>200,'result'=> $result]);
        }
    }

    public function AlphaString(Request $request)
    {
        $values = array("A"=>'1',"B"=>'2',"C"=>'3',"D"=>'4',"E"=>'5',"F"=>'6',
        "G"=>'7',"H"=>'8',"I"=>'9',"j"=>'10',"K"=>'11',"L"=>'12',"M"=>'13',
        "N"=>'14',"O"=>'15',"P"=>'16',"Q"=>'17',"R"=>'18',"S"=>'19',"T"=>'20',
        "U"=>'21',"V"=>'22',"W"=>'23',"X"=>'24',"Y"=>'25',"Z"=>'26');
        $string = $request->input_string;
        $length=strlen($string);
        $result = 0;
        for($i = 0;$i < $length; $i++)
        {
            if(!isset($values[$string[$i]]))
            {
                return response()->json(['stat'=>200,'result'=> 'all characters must be capital & must be a letter alphabet']);
            }
            $result*=26;
            $result+=$values[$string[$i]] - $values["A"]+1;
        }
        return response()->json(['stat'=>200,'result'=> $result]);
    }

    public function ArrayNumbers(Request $request)
    {
        $array_size = $request->N;
        $array =$request->Q;
        if(count($array)!= $array_size || $array_size <1)
        {
            return response()->json(['stat'=>200,'result'=> 'array count must equal array values & array size must be more than 1']);
        }
        $result=[];
        for($i = 0; $i < $array_size;$i++)
        {   $number_val=0;
            $number = $array[$i];
            while($number>0)
            {
                if($number%2==1)
                {
                     $number--;
                }
                else
                {
                    $number/=2;
                }
                $number_val++;
            }
            $result[$i]=$number_val;
        }
        return response()->json(['stat'=>200,'result'=> $result]);
    }
}
