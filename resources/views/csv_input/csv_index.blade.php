@extends('layouts.app')
@section('content')
<div class="container">

  <h1>CSVインポートと簡単なJavaScriptとSession</h1>
  <p>CSVファイルを csv_users テーブルに登録します。</p>

  <form action="{{ route('csv_input') }}" method="POST" enctype="multipart/form-data">
      @csrf
      <div class="row">
          <div class="col-11">
              <div>
                <label for="csv"></label>
                  <input type="file" name="csv">
              </div>
          </div>
      </div>
      <div class="my-4">
        <button type="submit" class="btn btn-success">送信</button>
      </div>
  </form>

  @if ($errors->any())
    <div class="alert alert-danger my-4">
      <ul>
        @foreach ($errors->all() as $error)
          <li>{{ $error }}</li>
        @endforeach
      </ul>
    </div>
  @endif

  @if(Session::has('successmessage'))
    @foreach(Session::get('datalist') as $row)
      <div class="my-4 border">
        {{ $row[0] }}, {{ $row[1] }}, {{ $row[2] }}
      </div>
    @endforeach
    {{Session::get('successmessage')}}
  @endif

  @if(Session::has('errormessage'))
    {{Session::get('errormessage')}}
  @endif

</div>
@endsection
