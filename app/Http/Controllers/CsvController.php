<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Goodby\CSV\Import\Standard\Lexer;
use Goodby\CSV\Import\Standard\Interpreter;
use Goodby\CSV\Import\Standard\LexerConfig;
use App\Models\CsvUser;

class CsvController extends Controller
{
  public function csv_index()
  {
      return view('csv_input/csv_index');
  }

  public function upload_regist(Request $request)
  {
      $request->validate([
        'csv' => 'required|max:1024|file|mimes:csv,txt'
      ],
      [
        'csv.required' => 'CSVファイルは必須です。',
        'csv.mimes'  => 'csvまたはtxtのみです。',
      ]);

      if($request->hasFile('csv') && $request->file('csv')->isValid()) {
          // CSV ファイル保存
          $tmpname = uniqid("CSVUP_").".".$request->file('csv')->guessExtension(); //TMPファイル名
          $request->file('csv')->move(public_path()."/csv/tmp",$tmpname);
          $tmppath = public_path()."/csv/tmp/".$tmpname;

          // Goodby CSVの設定
          $config_in = new LexerConfig();
          $config_in
              ->setFromCharset("SJIS-win")
              ->setToCharset("UTF-8") // CharasetをUTF-8に変換
              ->setIgnoreHeaderLine(true) //CSVのヘッダーを無視
          ;
          $lexer_in = new Lexer($config_in);

          $datalist = array();

          $interpreter = new Interpreter();
          $interpreter->addObserver(function (array $row) use (&$datalist){
             // 各列のデータを取得
             $datalist[] = $row;
          });

          // CSVデータをパース
          $lexer_in->parse($tmppath,$interpreter);

          // TMPファイル削除
          unlink($tmppath);

          // 処理
          $count = 0;
          foreach($datalist as $row){
              // 各データ取り出し
              //$csv_user = $this->get_csv_user($row);
              CsvUser::insert(['name' => $row[0], 'email' => $row[1], 'tel' => $row[2]]);
              $count++;
              // DBへの登録
              //$this->regist_user_csv($csv_user);
          }
          return redirect()->route('csv_index')->with('successmessage', '上記'.$count.'件のCSVのデータを読み込みました。')->with('datalist', $datalist);
      }
      return redirect()->route('csv_index')->with('errormessage','CSVの送信エラーが発生しましたので、送信を中止しました。');
  }

  private function get_csv_user($row)
  {
      $user = array(
          'name' => $row[0],
          'email' => $row[1],
          'tel' => $row[2],
      );
      return $user;
  }

  private function regist_user_csv($user)
  {
      $newuser = new CsvUser;
      foreach($user as $key => $value){
          $newuser->$key = $value;
      }
      $newuser->save();
  }
}
